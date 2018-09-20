<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    */

    'name' => 'Laravel',

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'sv',
    'locales' => [
        'da' => 'Dansk',
        'en' => 'English',
        'sv' => 'Svenska',
        'es' => 'Español',
        'nl' => 'Nederlands',
    ],
    'fallback_locale' => 'en',

    'currencies' => [
        'AED' => 'United Arab Emirates Dirham',
        'AFN' => 'Afghani',
        'ALL' => 'Lek',
        'AMD' => 'Armenian Dram',
        'ANG' => 'Netherlands Antillian Guilder',
        'AOA' => 'Kwanza',
        'ARS' => 'Argentine Peso',
        'AUD' => 'Australian Dollar',
        'AWG' => 'Aruban Guilder',
        'AZN' => 'Azerbaijanian Manat',
        'BAM' => 'Convertible Marks',
        'BBD' => 'Barbados Dollar',
        'BDT' => 'Taka',
        'BGN' => 'Bulgarian Lev',
        'BHD' => 'Bahraini Dinar',
        'BIF' => 'Burundi Franc',
        'BMD' => 'Bermudian Dollar',
        'BND' => 'Brunei Dollar',
        'BOB' => 'Boliviano Mvdol',
        'BOV' => 'Boliviano Mvdol',
        'BRL' => 'Brazilian Real',
        'BSD' => 'Bahamian Dollar',
        'BTN' => 'Bhutanese Ngultrum',
        'BWP' => 'Pula',
        'BYR' => 'Belarussian Ruble',
        'BZD' => 'Belize Dollar',
        'CAD' => 'Canadian Dollar',
        'CDF' => 'Congolese Franc',
        'CHF' => 'Swiss Franc',
        'CLF' => 'Chilean Unidades de fomento',
        'CLP' => 'Chilean Peso',
        'CNY' => 'Yuan Renminbi',
        'COP' => 'Colombian Peso Unidad de Valor Real',
        'CRC' => 'Costa Rican Colon',
        'CUC' => 'Cuban Peso',
        'CUP' => 'Cuban Peso',
        'CVE' => 'Cape Verde Escudo',
        'CZK' => 'Czech Koruna',
        'DJF' => 'Djibouti Franc',
        'DKK' => 'Danish Krone',
        'DOP' => 'Dominican Peso',
        'DZD' => 'Algerian Dinar',
        'EEK' => 'Kroon',
        'EGP' => 'Egyptian Pound',
        'ERN' => 'Nakfa',
        'ETB' => 'Ethiopian Birr',
        'EUR' => 'Euro',
        'FJD' => 'Fiji Dollar',
        'FKP' => 'Falkland Islands Pound',
        'GBP' => 'Pound Sterling',
        'GEL' => 'Lari',
        'GHS' => 'Cedi',
        'GIP' => 'Gibraltar Pound',
        'GMD' => 'Dalasi',
        'GNF' => 'Guinea Franc',
        'GTQ' => 'Quetzal',
        'GYD' => 'Guyana Dollar',
        'HKD' => 'Hong Kong Dollar',
        'HNL' => 'Lempira',
        'HRK' => 'Croatian Kuna',
        'HTG' => 'Haitian Gourde',
        'HUF' => 'Forint',
        'IDR' => 'Rupiah',
        'ILS' => 'New Israeli Sheqel',
        'INR' => 'Indian Rupee',
        'IQD' => 'Iraqi Dinar',
        'IRR' => 'Iranian Rial',
        'ISK' => 'Iceland Krona',
        'JMD' => 'Jamaican Dollar',
        'JOD' => 'Jordanian Dinar',
        'JPY' => 'Yen',
        'KES' => 'Kenyan Shilling',
        'KGS' => 'Som',
        'KHR' => 'Riel',
        'KMF' => 'Comoro Franc',
        'KPW' => 'North Korean Won',
        'KRW' => 'Won',
        'KWD' => 'Kuwaiti Dinar',
        'KYD' => 'Cayman Islands Dollar',
        'KZT' => 'Tenge',
        'LAK' => 'Kip',
        'LBP' => 'Lebanese Pound',
        'LKR' => 'Sri Lanka Rupee',
        'LRD' => 'Liberian Dollar',
        'LTL' => 'Lithuanian Litas',
        'LVL' => 'Latvian Lats',
        'LYD' => 'Libyan Dinar',
        'MAD' => 'Moroccan Dirham',
        'MDL' => 'Moldovan Leu',
        'MGA' => 'Malagasy Ariary',
        'MKD' => 'Denar',
        'MMK' => 'Kyat',
        'MNT' => 'Tugrik',
        'MOP' => 'Pataca',
        'MRO' => 'Ouguiya',
        'MUR' => 'Mauritius Rupee',
        'MVR' => 'Rufiyaa',
        'MWK' => 'Kwacha',
        'MXN' => 'Mexican Peso Mexican Unidad de Inversion (UDI)',
        'MYR' => 'Malaysian Ringgit',
        'MZN' => 'Metical',
        'NGN' => 'Naira',
        'NIO' => 'Cordoba Oro',
        'NOK' => 'Norwegian Krone',
        'NPR' => 'Nepalese Rupee',
        'NZD' => 'New Zealand Dollar',
        'OMR' => 'Rial Omani',
        'PAB' => 'Balboa US Dollar',
        'PEN' => 'Nuevo Sol',
        'PGK' => 'Kina',
        'PHP' => 'Philippine Peso',
        'PKR' => 'Pakistan Rupee',
        'PLN' => 'Zloty',
        'PYG' => 'Guarani',
        'QAR' => 'Qatari Rial',
        'RON' => 'New Leu',
        'RSD' => 'Serbian Dinar',
        'RUB' => 'Russian Ruble',
        'RWF' => 'Rwanda Franc',
        'SAR' => 'Saudi Riyal',
        'SBD' => 'Solomon Islands Dollar',
        'SCR' => 'Seychelles Rupee',
        'SDG' => 'Sudanese Pound',
        'SEK' => 'Swedish Krona',
        'SGD' => 'Singapore Dollar',
        'SHP' => 'Saint Helena Pound',
        'SLL' => 'Leone',
        'SOS' => 'Somali Shilling',
        'SRD' => 'Surinam Dollar',
        'STD' => 'Dobra',
        'SVC' => 'El Salvador Colon US Dollar',
        'SYP' => 'Syrian Pound',
        'SZL' => 'Lilangeni',
        'THB' => 'Baht',
        'TJS' => 'Somoni',
        'TMT' => 'Manat',
        'TND' => 'Tunisian Dinar',
        'TOP' => 'Pa\'anga',
        'TRY' => 'Turkish Lira',
        'TTD' => 'Trinidad and Tobago Dollar',
        'TWD' => 'New Taiwan Dollar',
        'TZS' => 'Tanzanian Shilling',
        'UAH' => 'Hryvnia',
        'UGX' => 'Uganda Shilling',
        'USD' => 'US Dollar',
        'UYU' => 'Peso Uruguayo Uruguay Peso en Unidades Indexadas',
        'UZS' => 'Uzbekistan Sum',
        'VEF' => 'Bolivar Fuerte',
        'VND' => 'Dong',
        'VUV' => 'Vatu',
        'WST' => 'Tala',
        'XAF' => 'CFA Franc BEAC',
        'XAG' => 'Silver',
        'XAU' => 'Gold',
        'XCD' => 'East Caribbean Dollar',
        'XDR' => 'SDR',
        'XFU' => 'UIC-Franc',
        'XOF' => 'CFA Franc BCEAO',
        'XPD' => 'Palladium',
        'XPF' => 'CFP Franc',
        'XPT' => 'Platinum',
        'YER' => 'Yemeni Rial',
        'ZAR' => 'Rand',
        'ZMK' => 'Zambian Kwacha',
        'ZWL' => 'Zimbabwe Dollar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => env('APP_LOG', 'single'),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Barryvdh\Cors\ServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Sentry\SentryLaravel\SentryLaravelServiceProvider::class,
        LocalFoodNodes\LanguageTable\ServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Sentry' => Sentry\SentryLaravel\SentryFacade::class,

        'UnitsHelper' => App\Helpers\UnitsHelper::class,
        'Uuid' => Webpatser\Uuid\Uuid::class,
    ],

];
