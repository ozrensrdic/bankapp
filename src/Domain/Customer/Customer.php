<?php
declare(strict_types=1);

namespace App\Domain\Customer;

use App\Domain\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Customer extends Entity
{
    public static array $hydratorMap = [
        'name' => 'name',
        'balance' => 'balance'
    ];

    /**
     * @var int
     */
    private int $id;

    /**
     * @var ?string
     * @Assert\NotBlank
     */
    private ?string $name;

    /**
     * @var string|float
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private string|float $balance;

    /**
     * @var int
     */
    private int $branch;

    /**
     * @var string
     */
    private string $createdAt;

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
        return (float) $this->balance;
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

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $timestamp;
     * @return $this
     */
    public function setCreatedAt(string $timestamp): Customer
    {
        $this->createdAt = $timestamp;

        return $this;
    }
}
