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
        /** @var Customer $customer */
        $customer = $this->model;
        $lastInsertId = $this->customerRepository->insertCustomer($customer);

        if (!$lastInsertId) {
            throw new \Exception();
        }

        return $this->response("Customer {$customer->getName()} added!");
    }

    protected function initializeModel()
    {
        $parsedBody = $this->request->getParsedBody();
        $data = [
            'name' => $parsedBody['name'] ?? '',
            'balance' => $parsedBody['balance'] ? (float) $parsedBody['balance'] : (float) 0
        ];

        $this->model = $this->hydrator->factory($this->modelClass, $data);
    }
}
