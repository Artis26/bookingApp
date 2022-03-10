<?php
namespace App\Models;

class Apartment {
    private string $address;
    private string $name;
    private string $description;
    private string $availableFrom;
    private ?string $availableTill;
    private float $price;
    private ?int $id;

    public function __construct(string  $address, string $name, string $description, string $availableFrom,
                                ?string $availableTill, float $price, ?int $id = null) {
        $this->address = $address;
        $this->name = $name;
        $this->description = $description;
        $this->availableFrom = $availableFrom;
        $this->availableTill = $availableTill;
        $this->price = $price;
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

    public function getAvailableTill(): string {
        return $this->availableTill;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getID(): int {
        return $this->id;
    }
}
