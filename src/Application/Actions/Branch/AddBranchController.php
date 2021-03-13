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
        /** @var Branch $branch */
        $branch = $this->model;
        $branchId = $this->branchRepository->insertBranch($branch);

        if (!$branchId) {
            throw new \Exception('Branch not added', StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);
        }

        $customerIds = $this->model->getCustomers();

        if ($customerIds) foreach (explode(',', $customerIds) as $customerId) {
            $this->customerRepository->setBranch($branchId, (int) $customerId);
        }

        return $this->response("Branch {$branch->getLocation()} added!");
    }

    protected function initializeModel()
    {
        $this->model = $this->hydrator->factory($this->modelClass, $this->request->getParsedBody());
    }
}
