<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use FaaPz\PDO\Database as Pdo;
use App\Application\Actions\Branch\AddBranchController;
use App\Application\Actions\Branch\GetBranchController;
use App\Application\Actions\Branch\GetBranchesController;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response) {
        $pdo = $this->get(Pdo::class);

        $response->getBody()->write('Hello world! Banking App');
        return $response;
    });

    $app->group('/branches', function (Group $group) {
        $group->get('', GetBranchesController::class);
        $group->get('/{id}', GetBranchController::class);
        $group->post('', AddBranchController::class);
    });
};
