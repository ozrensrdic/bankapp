<?php
declare(strict_types=1);

namespace App\Application\Actions\Customer;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class GetCustomersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        return $this->response($this->customerRepository->findAll());
    }
}
