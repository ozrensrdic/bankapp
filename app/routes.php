<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use FaaPz\PDO\Database as Pdo;
use App\Application\Actions\Branch\AddBranchController;
use App\Application\Actions\Branch\GetBranchByIdController;
use App\Application\Actions\Branch\GetBranchesController;
use App\Application\Actions\Report\GetBranchesBalancesController;
use App\Application\Actions\Report\GetValuableBranchesController;
use App\Application\Actions\Customer\AddCustomerController;
use App\Application\Actions\Customer\GetCustomersController;
use App\Application\Actions\Customer\GetCustomerByIdController;
use App\Application\Actions\Transaction\SendAmountController;
use App\Application\Actions\Docs\SwaggerAction;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response) {
        return $response->withHeader('Location', '/docs/v1/');
    });

    $app->group('/branches', function (Group $group) {
        $group->get('', GetBranchesController::class);
        $group->get('/{id}', GetBranchByIdController::class);
        $group->post('', AddBranchController::class);
    });

    $app->group('/customers', function (Group $group) {
        $group->get('', GetCustomersController::class);
        $group->post('', AddCustomerController::class);
        $group->get('/{id}', GetCustomerByIdController::class);
    });

    $app->group('/transactions', function (Group $group) {
        $group->post('/sender/{senderId}/receiver/{receiverId}', SendAmountController::class);
    });

    $app->group('/reports', function (Group $group) {
        $group->get('/branches/balance[/{balance}/{sort}]', GetBranchesBalancesController::class);
        $group->get('/valuable/branches', GetValuableBranchesController::class);
    });

    $app->get('/docs/v1/', SwaggerAction::class);

};
