<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class ApiBaseController extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Set language
        $this->middleware(function($request, $next) {
            $this->setLang($request, $next);

            return $next($request);
        });
    }

    /**
     * Set language middleware.
     *
     * @param Request $request
     * @param Closure $next
     */
    protected function getLang()
    {
        return $this->setLang();
    }

    /**
     * Get current language.
     *
     * @return string
     */
    public function setLang()
    {
        $request = \Request();

        // No language is set so we make sure there's always a language
        if (!$request->segment(1) || !array_key_exists($request->segment(1), config('app.locales'))) {
            // Default is to redirect to default lang
            $lang = config('app.locale');

            // If user is logged in we can redirect to the users specificied langauge
            if (Auth::check() && Auth::user()->active) {
                $user = Auth::user();
                $lang = $user->language;
            }

            $query = str_replace($request->url(), '', $request->fullUrl());
            return redirect('/' . $lang . '/' . $request->path() . $query);
        }

        // If lang value is present in request store it
        if ($request->segment(1) && array_key_exists($request->segment(1), config('app.locales'))) {
            $lang = $request->segment(1);
        }

        \App::setLocale($lang);

        return $lang;
    }
}
