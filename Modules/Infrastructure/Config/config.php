<?php

return [
    'name' => 'Infrastructure',
    'console-urls' => [
        's3' => 'https://s3.console.aws.amazon.com/s3/buckets/',
        'ec2' => 'https://console.aws.amazon.com/ec2/v2/home'
    ],
    'services' => [
        'aws' => [
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
        ],
    ],
];
