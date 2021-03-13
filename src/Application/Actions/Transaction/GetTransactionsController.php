<?php
declare(strict_types=1);

namespace App\Application\Actions\Transaction;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class GetTransactionsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $statement = $this->pdo->query("SELECT * FROM transactions");

        $transactions = $statement->fetchAll();
        var_dump($transactions);die;
        return $this->response($transactions);
    }
}
