<?php
namespace App\Models;

class Apartment {
    private string $address;
    private string $name;
    private string $description;
    private string $availableFrom;
    private float $price;
    private ?int $id;
    private int $creatorID;

    public function __construct(string  $address, string $name, string $description, string $availableFrom,
                                float $price,int $creatorID, ?int $id = null) {
        $this->address = $address;
        $this->name = $name;
        $this->description = $description;
        $this->availableFrom = $availableFrom;
        $this->price = $price;
        $this->creatorID = $creatorID;
        $this->id = $id;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getAvailableFrom(): string {
        return $this->availableFrom;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getCreatorID(): int {
        return $this->creatorID;
    }

    public function getID(): ?int {
        return $this->id;
    }
}
