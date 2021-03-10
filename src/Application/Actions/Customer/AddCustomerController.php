<?php
declare(strict_types=1);

namespace App\Application\Actions\Customer;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class AddCustomerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $parsedBody = $this->request->getParsedBody();

        $name = $parsedBody['name'];
        $balance = (float) $parsedBody['balance'];

        $statement = $this->pdo->prepare(
            "INSERT INTO customers (`name`, `balance`) VALUES (:name, :balance)"
        );

        $statementParams = [':name' => $name, ':balance' => $balance];

        $executed = $statement->execute($statementParams);
        if (!$executed) {
            throw new \Exception('Customer not added');
        }

        return $this->response("Customer {$name} added!");
    }
}
