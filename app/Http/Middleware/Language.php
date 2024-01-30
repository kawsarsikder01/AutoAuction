<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Language as LanguageModel;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        session()->put('lang', $this->getCode());
        session()->put('rtl', $this->getDirection());
         app()->setLocale(session('lang', $this->getCode()));
        return $next($request);
    }

    public function getCode()
    {
        if (session()->has('lang')) {
            return session('lang');
        }

        $language = LanguageModel::where('status', 1)->where('default_status', 1)->first();
        if (!$language) {
            $language = LanguageModel::where('status', 1)->first();
        }

        return $language ? $language->short_name : 'en';
    }

    public function getDirection()
    {
        if (session()->has('rtl')) {
            return session('rtl');
        }
        $language = LanguageModel::where('status', 1)->where('default_status', 1)->first();
        if (!$language) {
            $language = LanguageModel::where('status', 1)->first();
        }
        return $language ? $language->rtl : 0;
    }
}
