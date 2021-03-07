<?php
declare(strict_types=1);

namespace App\Application\Actions\Branch;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class GetBranchesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $statement = $this->pdo->query(
            "SELECT b.* FROM customers as c " .
            "RIGHT JOIN branches as b ON c.branch_id = b.id"
        );

        return $this->response($statement->fetchAll());
    }
}