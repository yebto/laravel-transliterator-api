<?php
return [
    'base_url' => env('YEB_API_BASE', 'https://api.yeb.to/v1/'),
    'key'      => env('YEB_KEY_ID'),
    'curl'     => [
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_USERAGENT      => 'yebto-transliterator-api-php',
    ],
];
