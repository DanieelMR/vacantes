<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cookie Settings
    |--------------------------------------------------------------------------
    */

    'path' => env('COOKIE_PATH', '/'),

    'domain' => env('COOKIE_DOMAIN'),

    'secure' => env('COOKIE_SECURE', false),

    'http_only' => true,

    'raw' => false,

    'same_site' => env('COOKIE_SAME_SITE', 'lax'),

];
