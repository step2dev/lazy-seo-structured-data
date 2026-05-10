<?php

return [
    'enabled' => true,

    'components' => [
        'register_legacy_aliases' => true,
    ],

    'defaults' => [
        'title' => env('APP_NAME', 'Laravel'),
        'description' => '',
    ],

    'organization' => [
        'name' => env('APP_NAME', 'Laravel'),
        'url' => env('APP_URL'),
        'logo' => null,
        'same_as' => [],
    ],

    'json' => [
        'pretty' => true,
        'unescaped_unicode' => true,
        'unescaped_slashes' => true,
    ],
];
