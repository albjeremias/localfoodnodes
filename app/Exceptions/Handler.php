<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)){
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
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
            $query = str_replace($request->url(), '',$request->fullUrl());
            return redirect('/' . $lang . '/' . $request->path() . $query);
        }

        // Handle HTTP exceptions
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            $customViews = ['403', '404'];

            if (in_array($exception->getStatusCode(), $customViews)) {
                return response()->view('new.errors.' . $statusCode, [], $statusCode);
            } else {
                return response()->view('new.errors.' . $statusCode[0] . 'xx', [], $statusCode);
            }

            return $this->renderHttpException($exception);
        }

        if ($exception instanceof TokenMismatchException) {
            $request->session()->flash('message', [trans('admin/messages.session_expired')]);

            return redirect()->route('login');
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $exception->getMessage()], 401);
        }

        return redirect()->guest('login');
    }
}
