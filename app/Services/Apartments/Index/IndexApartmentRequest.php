<?php

namespace App\Services\Apartments\Index;

class IndexApartmentRequest {

    private int $apartmentId;

    public function __construct(int $apartmentId) {
        $this->apartmentId = $apartmentId;
    }

    public function getApartmentId(): int {
        return $this->apartmentId;
    }
}