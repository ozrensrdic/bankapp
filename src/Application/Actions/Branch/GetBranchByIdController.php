<?php
declare(strict_types=1);

namespace App\Application\Actions\Branch;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class GetBranchByIdController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $id = (int) $this->resolveArg('id');
        $statement = $this->pdo->prepare("SELECT * FROM branches WHERE `id` = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $branch = $statement->fetch();
        return $this->response($branch);
    }
}
