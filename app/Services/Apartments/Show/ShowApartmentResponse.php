<?php
namespace App\Services\Apartments\Show;

class ShowApartmentResponse {

    private array $apartments;
    private array $ratings;

    public function __construct(array $apartments, array $ratings) {
        $this->apartments = $apartments;
        $this->ratings = $ratings;
    }

    public function getApartments(): array {
        return $this->apartments;
    }

    public function getRatings(): array {
        return $this->ratings;
    }
}