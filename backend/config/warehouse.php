<?php

return [
    'default' => 'yml',
    'connections' => [
        'redis' => 'default',
        'json' => [
            'driver' => 'file',
            'path' => 'storage/app/warehouse.json',
        ],
        'yml' => [
            'driver' => 'file',
            'path' => 'storage/app/warehouse.yml',
        ],

    ],
];
