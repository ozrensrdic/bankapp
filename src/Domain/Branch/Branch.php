<?php
declare(strict_types=1);

namespace App\Domain\Branch;

class Branch
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $location;

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
}
