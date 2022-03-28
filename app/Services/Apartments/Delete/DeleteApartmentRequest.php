<?php

namespace App\Services\Apartments\Delete;

class DeleteApartmentRequest {

    private int $apartmentID;

    public function __construct(int $apartmentID) {
        $this->apartmentID = $apartmentID;
    }

    public function getApartmentID(): int {
        return $this->apartmentID;
    }

}