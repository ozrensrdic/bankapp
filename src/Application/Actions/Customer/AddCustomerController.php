<?php
declare(strict_types=1);

namespace App\Application\Actions\Customer;

use App\Application\Actions\Controller;
use App\Domain\Customer\Customer;
use Psr\Http\Message\ResponseInterface as Response;

class AddCustomerController extends Controller
{
    protected string $modelClass = Customer::class;

    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO customers (`name`, `balance`) VALUES (:name, :balance)"
        );

        $statementParams = [':name' => $this->model->getName(), ':balance' => $this->model->getBalance()];

        $executed = $statement->execute($statementParams);
        if (!$executed) {
            throw new \Exception('Customer not added');
        }

        return $this->response("Customer {$this->model->getName()} added!");
    }

    protected function initializeModel()
    {
        $this->model = $this->hydrator->factory($this->modelClass, $this->request->getParsedBody());
    }
}
