<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Customer\Customer;
use FaaPz\PDO\Database as Pdo;

class CustomerRepository implements BaseRepositoryInterface
{
    /**
     * CustomerRepository constructor.
     * @param Pdo $pdo
     */
    public function __construct(protected PDO $pdo) {}

    /**
     * @param Customer $customer
     * @return string|null
     */
    public function insertCustomer(Customer $customer): string|null
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO customers (`name`, `balance`) VALUES (:name, :balance)"
        );

        if (!$statement->execute($this->toRow($customer))) {
            return null;
        }

        return $this->pdo->lastInsertId();
    }

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

    /**
     * @param int $branchId
     * @param int $customerId
     * @param bool
     */
    public function setBranch(int $branchId, int $customerId): bool
    {
        $updateCustomer = $this->pdo->prepare(
            'UPDATE customers SET `branch_id` = :branchId WHERE `id` = :id'
        );

        return $updateCustomer->execute([':branchId' => $branchId, ':id' => (int) $customerId]);
    }

    /**
     * @param Customer $customer
     *
     * @return array
     */
    private function toRow(Customer $customer): array
    {
        return [
            ':name' => $customer->getName(),
            ':balance' => $customer->getBalance()
        ];
    }
}