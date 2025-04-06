<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\Transfer\TransferAction;
use App\Infrastructure\Models\User;
use App\Domain\MerchantUser\MerchantUser;
use App\Domain\CommonUser\CommonUser;
use App\Application\Services\Transfer\TransferService;
use App\Application\Services\Transfer\CurlClient;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Services\Transfer\AuthorizationService;
use App\Application\Services\Transfer\NotificationService;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("Bem vindo(a) !");

        return $response;
    });

    $app->post('/transfer', TransferAction::class);

};
