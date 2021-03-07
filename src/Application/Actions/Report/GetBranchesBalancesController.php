<?php
declare(strict_types=1);

namespace App\Application\Actions\Report;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class GetBranchesBalancesController extends Controller
{
    /**
     * @var string
     */
    private string $balance;

    /**
     * @var string
     */
    private string $sort;

    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $this->balance = $this->resolveArg('balance', 'highest');
        $this->sort = strtolower($this->resolveArg('sort', 'desc'));

        $this->validateInputs();

        $sortOrder = SORT_DESC;
        if ($this->sort === 'asc') {
            $sortOrder = SORT_ASC;
        }

        $statement = $this->pdo->query(
            "SELECT b.location, c.balance FROM customers as c " .
            "RIGHT JOIN branches as b ON c.branch_id = b.id"
        );

        $customers = $statement->fetchAll();
        $branches = $this->getBalances($customers);

        array_multisort($branches, $sortOrder, array_keys($branches));

        var_dump($branches);
        return $this->response($branches);
    }

    protected function validateInputs()
    {
        if (!in_array($this->balance,  ['highest', 'lowest'])) {
            throw new \Exception('Wrong balance value');
        }

        if (!in_array($this->sort, ['asc', 'desc'])) {
            throw new \Exception('Wrong sorting value');
        }
    }

    private function getBalances($customers): array
    {
        $branches = [];

        foreach ($customers as $customer) {
            if (!isset($branches[$customer['location']])) {
                $balance = (float) $customer['balance'] ?? 0;
                $branches[$customer['location']] = $balance;
            } else {
                if ($this->balance ==='lowest') {
                    if ($customer['balance'] < $branches[$customer['location']]) {
                        $branches[$customer['location']] = (float) $customer['balance'];
                    }
                } else {
                    if ($customer['balance'] > $branches[$customer['location']]) {
                        $branches[$customer['location']] = (float) $customer['balance'];
                    }
                }
            }
        }

        return $branches;
    }
}
