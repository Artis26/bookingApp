<?php
namespace App\Services\Apartments\Index;

use App\Models\Apartment;

class IndexApartmentResponse {

    private Apartment $apartment;
    private array $reviews;
    private array $rating;
    private array $dates;

    public function __construct(Apartment $apartment, array $reviews, array $rating, array $dates) {
        $this->apartment = $apartment;
        $this->reviews = $reviews;
        $this->rating = $rating;
        $this->dates = $dates;
    }

    public function getApartment(): Apartment {
        return $this->apartment;
    }

    public function getReviews(): array {
        return $this->reviews;
    }

    public function getRating(): array {
        return $this->rating;
    }

    public function getDates(): array {
        return $this->dates;
    }


}