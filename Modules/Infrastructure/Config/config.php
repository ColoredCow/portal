<?php

return [
    'name' => 'Infrastructure',

    'services' => [
        'aws' => [
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY')
        ]
    ]
];
