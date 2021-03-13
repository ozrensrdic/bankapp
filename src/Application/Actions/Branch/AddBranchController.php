<?php
declare(strict_types=1);

namespace App\Application\Actions\Branch;

use App\Application\Actions\Controller;
use App\Domain\Branch\Branch;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;

class AddBranchController extends Controller
{
    /**
     * @var string
     */
    protected string $modelClass = Branch::class;

    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO branches (`location`) VALUES (:location)"
        );

        $statementParams = [':location' => $this->model->getLocation()];

        $executed = $statement->execute($statementParams);

        if (!$executed) {
            throw new \Exception('Branch not added', StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);
        }

        $branchId = $this->pdo->lastInsertId();
        $customerIds = $this->model->getCustomers();

        if ($customerIds) foreach (explode(',', $customerIds) as $customerId) {
            $updateCustomer = $this->pdo->prepare(
                'UPDATE customers SET `branch_id` = :branchId WHERE `id` = :id'
            );

            $updateCustomer->execute([':branchId' => $branchId, ':id' => (int) $customerId]);
        }

        return $this->response("Branch {$this->model->getLocation()} added!");
    }

    protected function initializeModel()
    {
        $this->model = $this->hydrator->factory($this->modelClass, $this->request->getParsedBody());
    }
}
