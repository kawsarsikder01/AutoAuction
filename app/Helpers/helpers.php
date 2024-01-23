<?php

use App\Models\BasicControl;
use App\Models\ManageMenu;
use App\Models\PageDetail;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Language;


use Illuminate\Support\Facades\Storage;


function checkReact($reacts){
        foreach($reacts as $react){
            if($react->ip_address === request()->ip()){
                return true;
            }
        }
}






function template($asset = false)
{
    $activeTheme = basicControl()->theme;
    if ($asset) return 'assets/themes/' . $activeTheme . '/';
    return 'themes.' . $activeTheme . '.';
}

if (!function_exists('staticPagesAndRoutes')) {
    function staticPagesAndRoutes($name)
    {
//        dd($name);
        return [
            'blog' => 'blog',
            'plan' => 'plan',
            'auction' => 'auction',
            'login' => 'login'
        ][$name];
    }
}


if (!function_exists('getHeaderMenuData')) {
    function getHeaderMenuData()
    {
        $menu = ManageMenu::where('menu_section', 'header')->first();
        $menuData = [];

        foreach ($menu->menu_items as $key => $menuItem) {
            if (is_numeric($key)) {
                $pageDetails = getPageDetails($menuItem);
                $menuIDetails = [
                    'name' => $pageDetails->name ?? $menuItem,
                    'route' => isset($pageDetails->page->slug) ? route('page', $pageDetails->page->slug) : route(staticPagesAndRoutes($menuItem)),
                ];
            } elseif (is_array($menuItem)) {
                $pageDetails = getPageDetails($key);
                $child = getHeaderChildMenu($menuItem);
                $menuIDetails = [
                    'name' => $pageDetails->name,
                    'route' => isset($pageDetails->page->slug) ? route('page', $pageDetails->page->slug) : route(staticPagesAndRoutes($key)),
                    'child' => $child
                ];
            }
            $menuData[] = $menuIDetails;
        }

        return $menuData;
    }
}


if (!function_exists('getHeaderChildMenu')) {
    function getHeaderChildMenu($menuItem, $menuData = [])
    {
        foreach ($menuItem as $key => $item) {
            if (is_numeric($key)) {
                $pageDetails = getPageDetails($item);
                $menuData[] = [
                    'name' => $pageDetails->name ?? $item,
                    'route' => isset($pageDetails->page->slug) ? route('page', $pageDetails->page->slug) : route(staticPagesAndRoutes($item)),
                ];
            } elseif (is_array($item)) {
                $pageDetails = getPageDetails($key);
                $child = getHeaderChildMenu($item);
                $menuData[] = [
                    'name' => $pageDetails->name ?? $key,
                    'route' => isset($pageDetails->page->slug) ? route('page', $pageDetails->page->slug) : route(staticPagesAndRoutes($key)),
                    'child' => $child
                ];
            } else {
                $pageDetails = getPageDetails($key);
                $child = getHeaderChildMenu([$item]);
                $menuData[] = [
                    'name' => $pageDetails->name ?? $key,
                    'route' => isset($pageDetails->page->slug) ? route('page', $pageDetails->page->slug) : route(staticPagesAndRoutes($key)),
                    'child' => $child
                ];
            }
        }

        return $menuData;
    }
}


if (!function_exists('getPageDetails')) {
    function getPageDetails($name)
    {
        return PageDetail::select('id', 'page_id', 'name')
            ->with('page:id,name,slug')
            ->whereHas('page', function ($query) use ($name) {
                $query->where('name', $name);
            })
            ->first();
    }
}

if (!function_exists('renderHeaderMenu')) {
    function renderHeaderMenu($menuItems)
    {

        foreach ($menuItems as $key => $menuItem) {
            if (isset($menuItem['child'])) {
                echo '<li class="dropdown text-capitalize">';
                echo '<a href="javascript:void(0)"><span>' . $menuItem['name'] . '</span> <i class="bi bi-chevron-down"></i></a>';
                renderHeaderMenu($menuItem['child']);
            } else {
                if(Auth::user()&& $menuItem['name'] == 'login'){
                    continue;
                }
                if ($key == 0){
                    echo "<li class='nav-item'>
                          <a class='nav-link active' href=".$menuItem['route'].">".$menuItem['name']."</a>
                      </li>";
                }else{
                    echo "<li class='nav-item'>
                          <a class='nav-link' href=".$menuItem['route'].">".$menuItem['name']."</a>
                      </li>";
                }


            }
        }

    }
}


if (!function_exists('getFooterMenuData')) {
    function getFooterMenuData($type)
    {
        $menu = ManageMenu::where('menu_section', 'footer')->first();
        $menuData = [];

        if (isset($menu->menu_items[$type])) {
            foreach ($menu->menu_items[$type] as $key => $menuItem) {
                $pageDetails = getPageDetails($menuItem);
                $menuIDetails = [
                    'name' => $pageDetails->name ?? $menuItem,
                    'route' => isset($pageDetails->page->slug) ? route('page', $pageDetails->page->slug) : route(staticPagesAndRoutes($menuItem)),
                ];
                $menuData[] = $menuIDetails;
            }
            foreach ($menuData as $item) {
                $che = '<li><i class="bi bi-chevron-right"></i><a class="text-capitalize" href="' . $item['route'] . '">' . $item['name'] . '</a></li>';
                $flattenedMenuData[] = $che;
            }
            return $flattenedMenuData;
        }
    }
}

function getPageName($name){
    $defaultLanguage = Language::where('default_status', true)->first();
    $pageDetails = PageDetail::select('id', 'page_id', 'name')
        ->with('page:id,name,slug')
        ->where('language_id', $defaultLanguage->id)
        ->whereHas('page', function ($query) use ($name) {
            $query->where('name', $name);
        })
        ->first();
    return $pageDetails->name ?? $pageDetails->page->name ?? $name;
}
if (!function_exists('getThemesNames')) {
    function getThemesNames()
    {
        $directory = resource_path('views/themes');
        return File::isDirectory($directory) ? array_map('basename', File::directories($directory)) : [];
    }
}

if (!function_exists('stringToTitle')) {
    function stringToTitle($string)
    {
        return implode(' ', array_map('ucwords', explode(' ', preg_replace('/[^a-zA-Z0-9]+/', ' ', $string))));
    }
}


if (!function_exists('getTitle')) {
    function getTitle($title)
    {
        return ucwords(preg_replace('/[^A-Za-z0-9]/', ' ', $title));
    }
}

if (!function_exists('getRoute')) {
    function getRoute($route, $params = null)
    {
        return isset($params) ? route($route, $params) : route($route);
    }
}


function getPageSections()
{
    $sectionsPath = resource_path('views/') . str_replace('.', '/', template()) . 'sections';
    $pattern = $sectionsPath . '/*';
    $files = glob($pattern);

    $fileBaseNames = [];

    foreach ($files as $file) {
        if (is_file($file)) {
            $basename = basename($file);
            $basenameWithoutExtension = str_replace('.blade.php', '', $basename);
            $fileBaseNames[$basenameWithoutExtension] = $basenameWithoutExtension;
        }
    }

//    $sectionNameWithWhitespace = array_map(function ($string) {
//        $string = preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);
//        $string = preg_replace('/-/', ' ', $string);
//        $string = str_replace('_', ' ', $string);
//        $string = str_replace('-', ' ', $string);
//        return $string;
//    }, $fileBaseNames);

    return $fileBaseNames;
}


function hex2rgba($color, $opacity = false)
{
    $default = 'rgb(0,0,0)';

    if (empty($color))
        return $default;

    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    $rgb = array_map('hexdec', $hex);

    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }
    return $output;
}


if (!function_exists('basicControl')) {
    function basicControl()
    {
        $configure = \Cache::get('ConfigureSetting');
        if (!$configure) {
            $configure = BasicControl::firstOrCreate();
            \Cache::put('ConfigureSetting', $configure);
        }
        if(session()->get('themeMode') == null){
            session()->put('themeMode', 'auto');
        }
        return $configure;
    }
}

function checkTo($currencies, $selectedCurrency = 'USD')
{
    foreach ($currencies as $key => $currency) {
        if (property_exists($currency, strtoupper($selectedCurrency))) {
            return $key;
        }
    }
}


if (!function_exists('menuActive')) {
    function menuActive($routeName, $type = null)
    {
        $class = 'active';
        if ($type == 3) {
            $class = 'active collapsed';
        } elseif ($type == 2) {
            $class = 'show';
        }

        if (is_array($routeName)) {
            foreach ($routeName as $key => $value) {
                if (request()->routeIs($value)) {
                    return $class;
                }
            }
        } elseif (request()->routeIs($routeName)) {
            return $class;
        }
    }
}


if (!function_exists('isMenuActive')) {
    function isMenuActive($routes, $type = 0)
    {
        $class = [
            '0' => 'active',
            '1' => 'style=display:block',
            '2' => true
        ];

        if (is_array($routes)) {
            foreach ($routes as $key => $route) {
                if (request()->routeIs($route)) {
                    return $class[$type];
                }
            }
        } elseif (request()->routeIs($routes)) {
            return $class[$type];
        }

        if ($type == 1) {
            return 'style=display:none';
        } else {
            return false;
        }
    }
}


function strRandom($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if (!function_exists('getFile')) {


    function getFile($disk = 'local', $image = '', $upload = false)
    {
        $root = storage_path('framework/testing/disks/'.$disk);

        $default = ($upload == true) ? asset(config('filelocation.default2')) : asset(config('filelocation.default'));
        try {
            if ($disk == 'local') {

                $localImage = asset('/assets/upload') . '/' . $image;
                return !empty($image) && Storage::disk($disk)->exists($image) ? $localImage : $default;
            } else {
                return !empty($image) && Storage::disk($disk)->exists($image) ? Storage::disk($disk)->url($image) : $default;
            }
        } catch (Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('getFileForEdit')) {
    function getFileForEdit($disk = 'local', $image = null)
    {
        try {
            if ($disk == 'local') {
                $localImage = asset('/assets/upload') . '/' . $image;
                return !empty($image) && Storage::disk($disk)->exists($image) ? $localImage : null;
            } else {
                return !empty($image) && Storage::disk($disk)->exists($image) ? Storage::disk($disk)->url($image) : asset(config('location.default'));
            }
        } catch (Exception $e) {
            return null;
        }
    }
}

function options($string)
{
    return $options = explode(",",$string);
}

function title2snake($string)
{
    return Str::title(str_replace(' ', '_', $string));
}

function snake2Title($string)
{
    return Str::title(str_replace('_', ' ', $string));
}

function kebab2Title($string)
{
    return Str::title(str_replace('-', ' ', $string));
}

function getMethodCurrency($gateway)
{
    foreach ($gateway->currencies as $key => $currency) {
        if (property_exists($currency, $gateway->currency)) {
            if ($key == 0) {
                return $gateway->currency;
            } else {
                return 'USD';
            }
        }
    }
}

function twoStepPrevious($deposit)
{
    if ($deposit->depositable_type == \App\Models\Fund::class) {
        return route('fund.initialize');
    }
}


function slug($title)
{
    return Str::slug($title);
}

function clean($string)
{
    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    \Carbon\Carbon::setlocale($lang);
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function loopIndex($object)
{
    return ($object->currentPage() - 1) * $object->perPage() + 1;
}

function dateTime($date, $format = 'd/m/Y H:i')
{
    $format = basicControl()->date_time_format;
    return date($format, strtotime($date));
}


if (!function_exists('getProjectDirectory')) {
    function getProjectDirectory()
    {
        return str_replace((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]", "", url("/"));
    }
}

if (!function_exists('defaultLang')) {
    function defaultLang()
    {
        return Language::where('default_status', true)->first();
    }
}

if (!function_exists('removeHyphenInString')) {
    function removeHyphenInString($string)
    {
        return str_replace("_", " ", $string);
    }
}


function updateWallet($user_id, $currency_id, $amount, $action = 0)
{
    $wallet = Wallet::firstOrCreate(['user_id' => $user_id, 'currency_id' => $currency_id]);
    $balance = 0;

    if ($action == 1) { //add money
        $balance = $wallet->balance + $amount;
        $wallet->balance = $balance;
    } elseif ($action == 0) { //deduct money
        $balance = $wallet->balance - $amount;
        $wallet->balance = $balance;
    }

    $wallet->save();
    return $balance;
}

function updateBalance($user_id, $amount, $action = 0)
{
    $user = User::where('id', $user_id)->firstOr(function () {
        throw new \Exception('User not found!');
    });
    if ($amount > $user->balance) {
        return back()->with('error', 'Insufficient Balance to deducted.');
    }
    if ($action == 1) { //add money
        $balance = $user->balance + $amount;
        $user->balance = $balance;
    } elseif ($action == 0) { //deduct money
        $balance = $user->balance - $amount;
        $user->balance = $balance;
    }
    $user->save();
}


function getAmount($amount, $length = 0)
{
    if ($amount == 0) {
        return 0;
    }
    if ($length == 0) {
        preg_match("#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($amount), $o);
        return $o[1] . sprintf('%d', $o[2]) . ($o[3] != '.' ? $o[3] : '');
    }

    return round($amount, $length);
}

if (!function_exists('currencyPosition')) {
    function currencyPosition($amount)
    {
        $basic = basicControl();
        $amount = fractionNumber($amount);
        return $basic->is_currency_position == 'left' && $basic->has_space_between_currency_and_amount ? "{$basic->currency_symbol} {$amount}" :
            ($basic->is_currency_position == 'left' && !$basic->has_space_between_currency_and_amount ? "{$basic->currency_symbol}{$amount}" :
                ($basic->is_currency_position == 'right' && $basic->has_space_between_currency_and_amount ? "{$amount} {$basic->base_currency} " :
                    "{$amount}{$basic->base_currency}"));
    }

}


if (!function_exists('fractionNumber')) {
    function fractionNumber($amount, $afterComma = true)
    {
        $basic = basicControl();
        if ($afterComma == false) {
            return number_format($amount);
        }
        return number_format($amount, $basic->fraction_number ?? 2);
    }
}


function hextorgb($hexstring)
{
    $integar = hexdec($hexstring);
    return array("red" => 0xFF & ($integar >> 0x10),
        "green" => 0xFF & ($integar >> 0x8),
        "blue" => 0xFF & $integar);
}

function renderCaptCha($rand)
{
//    session_start();
//You can customize your captcha settings here

    $captcha_code = '';
    $captcha_image_height = 50;
    $captcha_image_width = 130;
    $total_characters_on_image = 6;

//The characters that can be used in the CAPTCHA code.
//avoid all confusing characters and numbers (For example: l, 1 and i)
    $possible_captcha_letters = 'bcdfghjkmnpqrstvwxyz23456789';
    $captcha_font = 'assets/monofont.ttf';

    $random_captcha_dots = 50;
    $random_captcha_lines = 25;
    $captcha_text_color = "0x142864";
    $captcha_noise_color = "0x142864";


    $count = 0;
    while ($count < $total_characters_on_image) {
        $captcha_code .= substr(
            $possible_captcha_letters,
            mt_rand(0, strlen($possible_captcha_letters) - 1),
            1);
        $count++;
    }


    $captcha_font_size = $captcha_image_height * 0.65;
    $captcha_image = @imagecreate(
        $captcha_image_width,
        $captcha_image_height
    );

    /* setting the background, text and noise colours here */
    $background_color = imagecolorallocate(
        $captcha_image,
        255,
        255,
        255
    );

    $array_text_color = hextorgb($captcha_text_color);
    $captcha_text_color = imagecolorallocate(
        $captcha_image,
        $array_text_color['red'],
        $array_text_color['green'],
        $array_text_color['blue']
    );

    $array_noise_color = hextorgb($captcha_noise_color);
    $image_noise_color = imagecolorallocate(
        $captcha_image,
        $array_noise_color['red'],
        $array_noise_color['green'],
        $array_noise_color['blue']
    );

    /* Generate random dots in background of the captcha image */
    for ($count = 0; $count < $random_captcha_dots; $count++) {
        imagefilledellipse(
            $captcha_image,
            mt_rand(0, $captcha_image_width),
            mt_rand(0, $captcha_image_height),
            2,
            3,
            $image_noise_color
        );
    }

    /* Generate random lines in background of the captcha image */
    for ($count = 0; $count < $random_captcha_lines; $count++) {
        imageline(
            $captcha_image,
            mt_rand(0, $captcha_image_width),
            mt_rand(0, $captcha_image_height),
            mt_rand(0, $captcha_image_width),
            mt_rand(0, $captcha_image_height),
            $image_noise_color
        );
    }

    /* Create a text box and add 6 captcha letters code in it */
    $text_box = imagettfbbox(
        $captcha_font_size,
        0,
        $captcha_font,
        $captcha_code
    );
    $x = ($captcha_image_width - $text_box[4]) / 2;
    $y = ($captcha_image_height - $text_box[5]) / 2;
    imagettftext(
        $captcha_image,
        $captcha_font_size,
        0,
        $x,
        $y,
        $captcha_text_color,
        $captcha_font,
        $captcha_code
    );

    /* Show captcha image in the html page */
// defining the image type to be shown in browser widow
    header('Content-Type: image/jpeg');
    imagejpeg($captcha_image); //showing the image
    imagedestroy($captcha_image); //destroying the image instance
//    $_SESSION['captcha'] = $captcha_code;

    session()->put('captcha', $captcha_code);
}

function getIpInfo()
{
//	$ip = '210.1.246.42';
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;


    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}


function convertRate($currencyCode, $payout)
{

    $convertRate = 0;
    $rate = optional($payout->method)->convert_rate;

    if ($rate) {
        $convertRate = $rate->$currencyCode;
    }

    return (float)$convertRate;
}

function browserIcon($string)
{
    $list = [
        "Unknown Browser" => "unknown",
        'Internet Explorer' => 'internetExplorer',
        'Firefox' => 'firefox',
        'Safari' => 'safari',
        'Chrome' => 'chrome',
        'Edge' => 'edge',
        'Opera' => 'opera',
        'Netscape' => 'netscape',
        'Maxthon' => 'maxthon',
        'Konqueror' => 'unknown',
        'UC Browser' => 'ucBrowser',
        'Safari Browser' => 'safari'];
    return $list[$string] ?? 'unknown';

}

function browserColor($string)
{
    $list = [
        "Unknown Browser" => "#999999",
        'Internet Explorer' => '#0072C6',
        'Firefox' => '#FF9500',
        'Safari' => '#5EAA51',
        'Chrome' => '#4285F4',
        'Edge' => '#0078D4',
        'Opera' => '#FF1B2D',
        'Netscape' => '#006699',
        'Maxthon' => '#002558',
        'Konqueror' => '#003399',
        'UC Browser' => '#3E74A0',
        'Safari Browser' => '#5EAA51'];
    return $list[$string] ?? '#999999';

}

function deviceIcon($string)
{
    $list = [
        'Tablet' => 'bi-laptop',
        'Mobile' => 'bi-phone',
        'Computer' => 'bi-display'];
    return $list[$string] ?? '';

}

if (!function_exists('timeAgo')) {
    function timeAgo($timestamp)
    {
        //$time_now = mktime(date('h')+0,date('i')+30,date('s'));
        $datetime1 = new DateTime("now");
        $datetime2 = date_create($timestamp);
        $diff = date_diff($datetime1, $datetime2);
        $timemsg = '';
        if ($diff->y > 0) {
            $timemsg = $diff->y . ' year' . ($diff->y > 1 ? "s" : '');

        } else if ($diff->m > 0) {
            $timemsg = $diff->m . ' month' . ($diff->m > 1 ? "s" : '');
        } else if ($diff->d > 0) {
            $timemsg = $diff->d . ' day' . ($diff->d > 1 ? "s" : '');
        } else if ($diff->h > 0) {
            $timemsg = $diff->h . ' hour' . ($diff->h > 1 ? "s" : '');
        } else if ($diff->i > 0) {
            $timemsg = $diff->i . ' minute' . ($diff->i > 1 ? "s" : '');
        } else if ($diff->s > 0) {
            $timemsg = $diff->s . ' second' . ($diff->s > 1 ? "s" : '');
        }
        if ($timemsg == "")
            $timemsg = "Just now";
        else
            $timemsg = $timemsg . ' ago';

        return $timemsg;
    }
}



function getLinksObj($item, $menu_section = 'header')
{
    $headerMenu = ManageMenu::where('menu_section', $menu_section)->first();
    if ($headerMenu) {
        $result = $headerMenu->scopeLinksRouteList()->where('name', $item)->first();
        return $result ?? [];
    }
    return '';
}

function code($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}


