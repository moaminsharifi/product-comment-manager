<?php

return [
    'default' => 'yml',
    'connections' => [
        'redis' => 'default',
        'json' => [
            'driver' => 'file',
            'path' => 'warehouse.json',
        ],
        'yml' => [
            'driver' => 'file',
            'path' => 'warehouse.yml',
        ],

    ],
];
