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
        return $this->response("Branch added");
    }
}
