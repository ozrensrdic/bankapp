<?php
declare(strict_types=1);

namespace App\Application\Actions\Branch;

use App\Application\Actions\Controller;
use Psr\Http\Message\ResponseInterface as Response;

class GetBranchController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function run(): Response
    {
        $branchId = (int) $this->resolveArg('id');

        $this->logger->info("Branch of id `${$branchId}` was viewed.");

        return $this->response("Selected branch `${$branchId}`");
    }
}
