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
        // Add body class based on view
        $this->middleware(function ($request, $next) {
            view()->composer('*', function($view) {
                $view_name = str_replace('.', '-', $view->getName());
                view()->share('viewName', $view_name);
            });

            return $next($request);
        });

        // Check GDPR consent
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            $validRoutes = ['logout', 'account/user/delete', 'account/user/gdpr/delete/confirm', 'account/user/gdpr'];
            $isValidRoute = in_array($request->path(), $validRoutes);
            if (!$isValidRoute && ($user && !$user->gdprConsent())) {
                return new Response(view('account.user.gdpr-consent'));
            }

            return $next($request);
        });

        // Add user object to all views
        $this->middleware(function ($request, $next) {
            $user = Auth::user() ?: new User();
            View::share('user', $user);

            return $next($request);
        });

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

        // Use users chosen language
        if (Auth::check() && Auth::user()->active) {
            $user = Auth::user();
            $lang = $user->language;
        }

        // Use session if set
        else if (\Session::get('locale')) {
            $lang = \Session::get('locale');
        }

        // If lang value is present in request store it
        else if ($request->has('lang') && array_key_exists($request->get('lang'), config('app.locales'))) {
            \Session::put('locale', $request->get('lang'));
            $lang = $request->get('lang');
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
