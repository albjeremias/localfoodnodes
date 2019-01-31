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
    }

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

        // IF: no language is set in the URL
        //   IF: user is logged in
        //     Use users language
        //   ELSE:
        //     Use site default lang
        // ELSE:
        //   Use URL language

        // No lang, redirect...
        if (!$request->segment(1) || !array_key_exists($request->segment(1), config('app.locales'))) {
            // ... to default lang
            $lang = config('app.locale');

            // or to user specificied lang
            if (Auth::check() && Auth::user()->active) {
                $user = Auth::user();
                $lang = $user->language;
            }

            // No lang, redirect to default lang
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
