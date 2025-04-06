<?php

declare(strict_types=1);

use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Repositories\EloquentUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepositoryInterface::class => \DI\autowire(EloquentUserRepository::class),
    ]);
};
