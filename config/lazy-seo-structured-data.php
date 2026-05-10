<?php

return [
    'enabled' => true,

    'components' => [
        'register_legacy_aliases' => true,
    ],

    'unknown_type_behavior' => 'fallback', // fallback|exception

    'custom_types' => [
        // 'course' => App\Support\Seo\CourseSchema::class,
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
