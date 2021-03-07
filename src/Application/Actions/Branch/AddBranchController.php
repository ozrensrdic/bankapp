<?php
declare(strict_types=1);

namespace App\Application\Actions\Branch;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class AddBranchController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $parsedBody = $this->request->getParsedBody();

        $location = $parsedBody['location'];
        $customerIds = $parsedBody['customers'];

        $statement = $this->pdo->prepare(
            "INSERT INTO branches (`location`) VALUES (:name)"
        );

        $statementParams = [':name' => $location];

        $executed = $statement->execute($statementParams);

        if (!$executed) {
            throw new \Exception('Branch not added');
        }

        $branchId = $this->pdo->lastInsertId();
        foreach (explode(',', $customerIds) as $customerId) {
            $updateCustomer = $this->pdo->prepare(
                'UPDATE customers SET `branch_id` = :branchId WHERE `id` = :id'
            );

            $updateCustomer->execute([':branchId' => $branchId, ':id' => $customerId]);
        }

        return $this->response("Branch $location added!");
    }
}
