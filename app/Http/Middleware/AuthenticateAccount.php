<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class AuthenticateAccount
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     * @param string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::check()) {
            throw new AuthenticationException();
        } else {
            $user = Auth::user();

            // Urls available for non-active users
            $urls = [
                'account/user/activate',
                'account/user/activate/resend',
                'account/user/gdpr',
            ];

            // Redirect user to activation page if not active or not in array of allowed urls
            if (!$user->active && !(in_array($request->path(), $urls))) {
                return redirect('/account/user/activate');
            } else {
                return $next($request);
            }
        }
    }
}
