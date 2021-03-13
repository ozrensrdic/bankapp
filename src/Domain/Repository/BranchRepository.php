<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Branch\Branch;
use FaaPz\PDO\Database as Pdo;

class BranchRepository implements BaseRepositoryInterface
{
    /**
     * BranchRepository constructor.
     * @param Pdo $pdo
     */
    public function __construct(protected PDO $pdo) {}

    /**
     * @param Branch $branch
     * @return int|null
     */
    public function insertBranch(Branch $branch): string|null
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO branches (`location`) VALUES (:location,)"
        );

        if (!$statement->execute($this->toRow($branch))) {
            return null;
        }

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM branches");

        return $statement->fetchAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM branches WHERE `id` = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $branch = $statement->fetch();
        if (!$branch) {
            throw new \Exception('No branch found');
        }

        return $branch;
    }

    /**
     * @param Branch $branch
     *
     * @return array
     */
    private function toRow(Branch $branch): array
    {
        return [
            ':location' => $branch->getLocation(),
        ];
    }
}