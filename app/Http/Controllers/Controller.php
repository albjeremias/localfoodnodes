<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

use View;
use App\User\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setLang();

        // Check GDPR consent
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            $validRouteNames = ['logout', 'account_user_delete', 'account_user_gdpr_delete_confirm', 'account_user_gdpr', 'account_user_gdpr_confirm'];
            $isValidRoute = in_array(substr($request->route()->getName(), 3), $validRouteNames);

            if (!$isValidRoute && ($user && !$user->gdprConsent())) {
                return redirect(route('account_user_gdpr'));
            }

            return $next($request);
        });

        // Add user object to all views
        $this->middleware(function ($request, $next) {
            $user = Auth::user() ?: new User();
            View::share('user', $user);

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
