<?php
namespace App\Services\Apartments\Edit;

use App\Models\Apartment;

class EditApartmentResponse {
    private Apartment $apartment;

    public function __construct(Apartment $apartment) {
        $this->apartment = $apartment;
    }

    public function getApartment(): Apartment {
        return $this->apartment;
    }
}