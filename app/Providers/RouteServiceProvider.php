<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->accountRoutes();
        $this->apiRoutes();
        $this->adminRoutes();
        $this->authRoutes();
        $this->systemRoutes();

        // Custom producer domains
        $this->producerDomainRoutes();

        // Needs to be last since the permalink controller tries to match all request
        // and returns a 404 is fail.
        $this->publicRoutes();
    }

    /**
     * Define the account routes for the application.
     *
     * @return void
     */
    protected function accountRoutes()
    {
        $prefix = [
            'en' => 'en/account',
            'sv' => 'sv/konto',
        ];

        foreach (config('app.locales') as $langCode => $language) {
            Route::group([
                'middleware' => ['web', 'auth.account'],
                'namespace' => $this->namespace,
                'prefix' => $prefix[$langCode],
            ], function ($router) use ($langCode) {
                require base_path('routes/' . $langCode . '/account.php');
            });
        }
    }

    /**
     * Define the api routes for the application.
     *
     * @return void
     */
    protected function apiRoutes()
    {
        foreach (config('app.locales') as $langCode => $language) {
            // Account API -> API
            Route::group([
                'middleware' => ['auth:api'],
                'namespace' => $this->namespace,
                'prefix' => $langCode . '/api/account',
            ], function ($router) {
                require base_path('routes/api/account/routes.php');
            });

            // Utils API
            Route::group([
                'middleware' => ['api'],
                'namespace' => $this->namespace,
                'prefix' => $langCode . '/api',
            ], function ($router) {
                require base_path('routes/api/utils/routes.php');
            });
        }

        // App API
        Route::group([
            'middleware' => ['auth:api'], // Passport
            'namespace' => $this->namespace,
            'prefix' => 'api/v1',
        ], function ($router) {
            require base_path('routes/api/app/v1/routes.php');
        });
    }

    /**
     * Define the admin routes for the application.
     *
     * @return void
     */
    protected function adminRoutes()
    {
        $options = [
            'middleware' => ['web', 'auth.admin'],
            'namespace' => $this->namespace,
            'prefix' => 'admin',
        ];

        Route::group($options, function ($router) {
            require base_path('routes/admin.php');
        });
    }

    /**
     * Define the auth and password routes for the application.
     *
     * @return void
     */
    protected function authRoutes()
    {
        foreach (config('app.locales') as $langCode => $language) {
            $options = [
                'middleware' => 'web',
                'namespace' => $this->namespace,
                'prefix' => $langCode,
            ];

            Route::group($options, function ($router) use ($langCode) {
                require base_path('routes/' . $langCode . '/auth.php');
            });
        }
    }

    /**
     * Define system routes, like cron.
     *
     * @return void
     */
    protected function systemRoutes()
    {
        $options = [
            'middleware' => 'web',
            'namespace' => $this->namespace,
            'prefix' => 'system',
        ];

        Route::group($options, function ($router) {
            require base_path('routes/system.php');
        });
    }

    /**
     * Producer custom domains routes.
     *
     * Todo: If no domain match redirect to .env domain
     *
     * @return void
     */
    protected function producerDomainRoutes()
    {
        $producers = [
            // ['id' => '2', 'domain' => 'test.dev'],
            // ['id' => '3', 'domain' => 'dev.test']
        ];

        foreach ($producers as $producer) {
            Route::domain($producer['domain'])->group(function() use ($producer) {
                Route::get('/', function(\Illuminate\Http\Request $request) use ($producer) {
                    return app('App\Http\Controllers\IndexController')->producer($request, $producer['id']);
                });
            });
        }
    }

    /**
     * Define the public routes for the application.
     *
     * @return void
     */
    protected function publicRoutes()
    {
        foreach (config('app.locales') as $langCode => $language) {
            Route::group([
                'middleware' => 'web',
                'namespace' => $this->namespace,
                'prefix' => $langCode,
            ], function ($router) use ($langCode) {
                require base_path('routes/' . $langCode . '/public.php');
            });
        }
    }
}
