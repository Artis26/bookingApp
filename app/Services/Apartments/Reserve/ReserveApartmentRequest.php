<?php
namespace App\Services\Apartments\Reserve;

class ReserveApartmentRequest {

    private int $apartmentId;
    private int $userId;
    private string $reservedFrom;
    private string $reservedTill;
    private int $price;

    public function __construct(int $apartmentId, int $userId, string $reservedFrom, string $reservedTill) {
        $this->apartmentId = $apartmentId;
        $this->userId =$userId;
        $this->reservedFrom = $reservedFrom;
        $this->reservedTill = $reservedTill;
        //$this->price = $price;
    }

    public function getApartmentId(): int {
        return $this->apartmentId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getReservedFrom(): string {
        return $this->reservedFrom;
    }

    public function getReservedTill(): string {
        return $this->reservedTill;
    }
}