<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use FaaPz\PDO\Database as Pdo;

class CustomerRepository
{
    /**
     * CustomerRepository constructor.
     * @param Pdo $pdo
     */
    public function __construct(protected PDO $pdo) {}

    /**
     * @return array
     */
    public function findAll(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM customers");

        return $statement->fetchAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM customers WHERE `id` = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $customer = $statement->fetch();
        if (!$customer) {
            throw new \Exception('No customer found');
        }

        return $customer;
    }
}