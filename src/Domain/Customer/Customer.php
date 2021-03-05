<?php
declare(strict_types=1);

namespace App\Domain\Customer;

class Customer
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var float
     */
    private float $balance;

    /**
     * @var int
     */
    private int $branch;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Customer
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     * @return $this
     */
    public function setBalance(float $balance): Customer
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return int
     */
    public function getBranch(): int
    {
        return $this->branch;
    }

    /**
     * @param int $branch
     * @return $this
     */
    public function setBranch(int $branch): Customer
    {
        $this->branch = $branch;
        return $this;
    }
}
