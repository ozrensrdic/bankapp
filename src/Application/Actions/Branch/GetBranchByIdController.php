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

        return $this->response($this->branchRepository->findById($id));
    }
}
