<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use Exception;

interface BaseRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function findById(int $id): array;
}
