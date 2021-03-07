<?php
declare(strict_types=1);

namespace App\Application\Actions\Report;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class GetValuableBranchesController extends Controller
{
    const BALANCE_LIMIT = 50000;

    const NUMBER_OF_IMPORTANT_CUSTOMERS = 2;

    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $statement = $this->pdo->prepare(
            "SELECT b.location, c.balance, c.name FROM customers as c " .
            "RIGHT JOIN branches as b ON c.branch_id = b.id " .
            "WHERE c.balance > :balanceLimit"
        );
        $balanceLimit = self::BALANCE_LIMIT;
        $statement->bindParam(':balanceLimit', $balanceLimit);
        $statement->execute();
        $customers = $statement->fetchAll();

        $branches = $this->getBranches($customers);

        return $this->response($branches);
    }

    private function getBranches($customers): array
    {
        $branches = [];

        foreach ($customers as $customer) {
            $branches[$customer['location']][$customer['name']] = $customer['balance'];
        }

        foreach (array_keys($branches) as $branchKey) {
            if (count($branches[$branchKey]) <= self::NUMBER_OF_IMPORTANT_CUSTOMERS) {
                unset($branches[$branchKey]);
            }
        }

        return $branches;
    }
}
