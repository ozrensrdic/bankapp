<?php

return [
    'migration_dirs' => [
        'migration' => __DIR__ . '/migration',
    ],
    'environments' => [
        'local' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'port' => 3306, // optional
            'username' => 'root',
            'password' => '',
            'db_name' => 'bankapp',
            'charset' => 'utf8',
        ]
    ],
    'default_environment' => 'local',
    'log_table_name' => 'phoenix_log',
];