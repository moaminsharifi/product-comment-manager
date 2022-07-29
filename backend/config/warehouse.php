<?php
use Illuminate\Support\Str;
return [

    'connections' => [
        'redis' => 'default',
        'json' => [
            'driver' => 'file',
            'path' => 'warehouse.json',
        ]

    ],
];
