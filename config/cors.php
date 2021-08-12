<?php

return [
    'paths' => [
        '/api/*',
        // '/login',
        // '/logout',
        // '/sanctum/token',
    ],

    'allowed_methods' => ['get','post','delete','put'],
    'allowed_origins' => ['http://localhost:*'],
    // 'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
