<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Log\LoggerInterface;
use FaaPz\PDO\Database as Pdo;
use Slim\App;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response) {
        $pdo = $this->get(Pdo::class);

        $response->getBody()->write('Hello world!');
        return $response;
    });

//    $app->group('/users', function (Group $group) {
//        $group->get('', ListUsersAction::class);
//        $group->get('/{id}', ViewUserAction::class);
//    });
};
