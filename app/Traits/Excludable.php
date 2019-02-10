<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Excludable
{
    /**
     * Set language middleware.
     *
     * @param Request $request
     * @param Closure $next
     */
    protected function setLang()
    {
        \App::setLocale($this->getLang());
    }

    /**
     * Get current language.
     *
     * @return string
     */
    public function getLang()
    {
        $request = \Request();

        // No language set
        if (!$request->segment(1) || !array_key_exists($request->segment(1), config('app.locales'))) {
            // Default is to redirect to default lang
            $lang = config('app.locale');

            // If user is logged in we can redirect to the users specificied langauge
            if (Auth::check() && Auth::user()->active) {
                $user = Auth::user();
                $lang = $user->language;
            }

            View::share('lang', $lang);

            $query = str_replace($request->url(), '', $request->fullUrl());
            return redirect('/' . $lang . '/' . $request->path() . $query);
        }

        // If lang value is present in request store it
        if ($request->segment(1) && array_key_exists($request->segment(1), config('app.locales'))) {
            $lang = $request->segment(1);
        }

        return $lang;
    }
}
