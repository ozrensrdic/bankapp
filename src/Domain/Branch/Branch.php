<?php
declare(strict_types=1);

namespace App\Domain\Branch;

use App\Domain\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Branch extends Entity
{
    public static array $hydratorMap = [
        'location' => 'location',
        'customers' => 'customers'
    ];

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private string $location = '';

    /**
     * @var string
     */
    private string $customers = '';

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
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return $this
     */
    public function setLocation(string $location): Branch
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomers(): string
    {
        return $this->customers;
    }

    /**
     * @param string $customers
     * @return $this
     */
    public function setCustomers(string $customers): Branch
    {
        $this->customers = $customers;

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
    public function setCreatedAt(string $timestamp): Branch
    {
        $this->createdAt = $timestamp;

        return $this;
    }
}
