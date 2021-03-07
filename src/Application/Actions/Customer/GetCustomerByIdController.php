<?php
declare(strict_types=1);

namespace App\Application\Actions\Customer;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class GetCustomerByIdController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $id = $this->resolveArg('id');
        $statement = $this->pdo->prepare("SELECT * FROM customers WHERE `id` = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $customer = $statement->fetch();

        return $this->response($customer);
    }
}
