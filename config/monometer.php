<?php


return [
    'default' => env('MONOMETER_DRIVER', 'stats-house'),

    'drivers' => [
        // default statshouse driver
        'stats-house' => [
            'driver' => \LaravelMonometer\Drivers\StatsHouseDriver::class,
            'addr' => env('MONOMETER_ADDR'),
        ],
    ],
];