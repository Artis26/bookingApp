<?php
namespace App\Services\Apartments\Store;

class StoreApartmentRequest {

    private string $address;
    private string $name;
    private string $desc;
    private string $availableFrom;
    private float $price;
    private int $creatorId;


    public function __construct(string $address, string $name, string $desc, string $availableFrom, float $price, int $creatorId) {
        $this->address = $address;
        $this->name = $name;
        $this->desc = $desc;
        $this->availableFrom = $availableFrom;
        $this->price = $price;
        $this->creatorId = $creatorId;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDesc(): string {
        return $this->desc;
    }

    public function getAvailableFrom(): string {
        return $this->availableFrom;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getCreatorId(): int {
        return $this->creatorId;
    }
}