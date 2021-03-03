<?php
return [
    'settings' => [
        'healthCheck' => [
            'modules' => [
                'cassandra',
                'storage',
                'redis',
                'elasticsearch',
                'mariadb'
            ],
            'containers' => [
            ]
        ],

    ],
];
