<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Order\OrderDateItemLink;

class SystemController extends BaseController
{
    public function info(Request $request)
    {
        echo phpinfo();
    }

    public function changeLocale(Request $request, $locale)
    {
        if ($locale) {
            \Session::put('locale', $locale);
            \App::setLocale($locale);

            // Try to stay on the current page when chaging locale
            $parts = parse_url(url()->previous());

            $urlSegments = $this->getUrlSegments($parts['path']);
            if (isset($urlSegments[0]) || array_key_exists($urlSegments[0], config('app.locales'))) {
                $urlSegments[0] = $locale;
                $parts['path'] = '/' . implode('/', $urlSegments);
            } else {
                $parts['path'] = '/' . $locale; // Fallback
            }

            $redirectUrl =  $parts['path'];
            if (isset($parts['query'])) {
                $redirectUrl .= '?' . $parts['query'];
            }

            return redirect($redirectUrl);
        }

        return redirect()->back();
    }

    private function getUrlSegments($path) {
        $segments = explode('/', $path);

        return array_values(array_filter($segments, function ($value) {
            return $value != '';
        }));
    }
}
