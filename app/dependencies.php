<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use App\Infrastructure\Persistence\Connection\EloquentConnection;
use App\Application\Services\Transfer\CurlClient;
use App\Application\Services\Transfer\AuthorizationService;
use App\Application\Services\Transfer\NotificationService;
use App\Application\Services\Transfer\TransferService;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        'db' => function () {
            return EloquentConnection::bootstrap();
        },
        CurlClient::class => DI\autowire(CurlClient::class),

        AuthorizationService::class => DI\autowire(AuthorizationService::class),
        
        NotificationService::class => DI\autowire(NotificationService::class),
        
        TransferService::class => DI\autowire(TransferService::class),
    ]);
};


