<?php
namespace App\Services\Apartments\Update;

class UpdateApartmentRequest {
    private string $address;
    private float $price;
    private string $desc;
    private string $name;
    private int $id;

    public function __construct(string $address,string $name, string $desc, float $price, int $id) {
        $this->address = $address;
        $this->name = $name;
        $this->desc = $desc;
        $this->price = $price;
        $this->id = $id;
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

    public function getPrice(): float {
        return $this->price;
    }

    public function getId(): int {
        return $this->id;
    }
}