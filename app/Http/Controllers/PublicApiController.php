<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PublicApiController extends BaseController
{
    /**
     * Translations endpoint.
     *
     * @param Request $request
     * @return void
     */
    public function translations(Request $request)
    {
        if (!$request->has('keys')) {
            return response()->json($this->error('Missing keys.'));
        }

        $keys = explode(',', $request->get('keys'));
        $translations = [];
        foreach ($keys as $key) {
            $translationKey = 'public-api.' . $key;
            $translations += trans($translationKey);
        }

        $res = $this->error('Could not find translation.');
        if ($translations !== $translationKey) {
            $res = ['data' => $translations];
        }

        return response()->json($res);
    }

    /**
     * Format error messages
     *
     * @param string $message
     * @return void
     */
    private function error($message)
    {
        return [
            'error' => [
                'message' => $message
            ]
        ];
    }
}
