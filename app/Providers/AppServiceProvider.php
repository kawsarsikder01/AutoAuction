<?php

namespace App\Providers;

use App\Models\CarBrand;
use App\Models\CarCategory;
use App\Models\Content;
use App\Models\ContentDetails;
use App\Models\Language;
use App\Models\ManageMenu;
use App\Models\Page;
use App\Models\PageDetail;
use App\Models\UserKyc;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Mailchimp\Transport\MandrillTransportFactory;
use Symfony\Component\Mailer\Bridge\Sendgrid\Transport\SendgridTransportFactory;
use Symfony\Component\Mailer\Bridge\Sendinblue\Transport\SendinblueTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // dd(Auth::guard('web')->check());
        $data['basicControl'] = basicControl();
        $data['theme'] = template();
        $data['themeTrue'] = template(true);
        View::share($data);

        view()->composer([
            $data['theme'] . 'partials.navbar',
            $data['theme'] . 'sections.footer',
            $data['theme'] . 'auth.login',
            $data['theme'] . 'partials.searchItem',
            $data['theme'] . 'page',
            $data['theme'] . 'plans.plan'
        ], function ($view) {

            $languages = Language::orderBy('name')->where('status', 1)->get();
            $headerMenu = ManageMenu::where('menu_section', 'header')->first();

            $view->with('headerMenu', $headerMenu);

            $footerMenu = ManageMenu::where('menu_section', 'footer')->first();
            $Staticfooter = Content::with('contentDetails')->where('name', 'footer')->get();
            $plan = Content::with('contentDetails')->where('name', 'plan')->get();

            $loginContent = ContentDetails::with('content')->whereHas('content', function ($query) {
                $query->where('name', 'login');
            })->get();
            $data['categories'] = CarCategory::get();
            $data['brands'] = CarBrand::get();
            $view->with('loginContent', $loginContent);
            $view->with('Staticfooter', $Staticfooter);
            $view->with('languages', $languages);
            $view->with('footerMenu', $footerMenu);
            $view->with('categories', $data['categories']);
            $view->with('brands', $data['brands']);
            $view->with('plan', $plan);

            $footerMenu = ManageMenu::where('menu_section', 'footer')->first();
            $view->with('footerMenu', $footerMenu);

            $section = 'footer';
            $footer_section1 = ContentDetails::with('content')
                ->whereHas('content', function ($query) use ($section) {
                    $query->where('name', $section);
                })
                ->get();
            $singleContent = $footer_section1->where('content.name', $section)->where('content.type', 'single')->first() ?? [];
            $multipleContents = $footer_section1->where('content.name', $section)->where('content.type', 'multiple')->values()->map(function ($multipleContentData) {
                return collect($multipleContentData->description)->merge($multipleContentData->content->only('media'));
            });
            $data = [
                'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                'multiple' => $multipleContents
            ];

            $view->with('footer', $data);

        });
        if (basicControl()->force_ssl == 1) {
            if ($this->app->environment('production') || $this->app->environment('local')) {
                \URL::forceScheme('https');
            }
        }

        Mail::extend('sendinblue', function () {
            return (new SendinblueTransportFactory)->create(
                new Dsn(
                    'sendinblue+api',
                    'default',
                    config('services.sendinblue.key')
                )
            );
        });

        Mail::extend('sendgrid', function () {
            return (new SendgridTransportFactory)->create(
                new Dsn(
                    'sendgrid+api',
                    'default',
                    config('services.sendgrid.key')
                )
            );
        });

        Mail::extend('mandrill', function () {
            return (new MandrillTransportFactory)->create(
                new Dsn(
                    'mandrill+api',
                    'default',
                    config('services.mandrill.key')
                )
            );
        });


    }
}
