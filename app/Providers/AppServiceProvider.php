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
            $data['theme'] . 'partials.footer',
            $data['theme'] . 'partials.searchItem',
            $data['theme'] . 'page'
        ], function ($view) {
            $headerMenu = ManageMenu::where('menu_section', 'header')->first();
            $view->with('headerMenu', $headerMenu);

            $footerMenu = ManageMenu::where('menu_section', 'footer')->first();
            $Staticfooter = Content::with('contentDetails')->where('name','footer')->get();
            $allLanguage = Language::where('status',1)->get();
            $loginContent = ContentDetails::with('content')->whereHas('content',function ($query){
                $query->where('name','login');
            })->get();
            $data['categories'] =  CarCategory::get();
            $data['brands'] =  CarBrand::get();
            $view->with('loginContent', $loginContent);
            $view->with('Staticfooter', $Staticfooter);
            $view->with('allLanguage', $allLanguage);
            $view->with('footerMenu', $footerMenu);
            $view->with('categories', $data['categories']);
            $view->with('brands', $data['brands']);

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
