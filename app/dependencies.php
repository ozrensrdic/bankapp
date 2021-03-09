<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use FaaPz\PDO\Database as Pdo;
use Slim\Views\Twig;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Pdo::class => function(ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);

            $pdoSettings = $settings->get('pdo');

            $dsn = "mysql:host={$pdoSettings['host']};dbname={$pdoSettings['dbName']};charset={$pdoSettings['charset']}";
            $user = $pdoSettings['user'];
            $password = $pdoSettings['password'];

            $pdo = new Pdo($dsn, $user, $password);

            return $pdo;
        },
        Twig::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);

            $twigSettings = $settings->get('twig');
            $twig = Twig::create($twigSettings['path']);

            return $twig;
        },
    ]);
};
