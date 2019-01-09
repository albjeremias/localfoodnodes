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
        $this->middleware(function ($request, $next) {
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
    private function setLang($request, $next)
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

        // If lang value is present in request store it
        if ($request->has('lang') && array_key_exists($request->get('lang'), config('app.locales'))) {
            $lang = $request->get('lang');
        }

        // Use users chosen language
        else if (Auth::check() && Auth::user()->active) {
            $user = Auth::user();
            $lang = $user->language;
        }

        // Use session if set
        else if (\Session::get('locale')) {
            $lang = \Session::get('locale');
        }

        // Use browser language setting
        else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }

        // Default app setting
        else {
            $lang = config('app.locale');
        }

        return $lang;
    }
}
