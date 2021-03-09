<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'pdo' => [
                    'host' => '127.0.0.1',
                    'dbName' => 'bankapp',
                    'charset' => 'utf8',
                    'user' => 'root',
                    'password' => ''
                ],
                'twig' => [
                    'path' => './../templates/docs',
                ]
            ]);
        }
    ]);
};
