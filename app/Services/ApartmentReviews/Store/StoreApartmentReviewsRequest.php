<?php
namespace App\Services\ApartmentReviews\Store;

class StoreApartmentReviewsRequest {

    private int $apartmentId;
    private int $userId;
    private int $rating;
    private string $text;

    public function __construct(int $apartmentId, int $userId, int $rating, string $text) {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
        $this->rating = $rating;
        $this->text = $text;
    }

    public function getApartmentId(): int {
        return $this->apartmentId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getRating(): int {
        return $this->rating;
    }

    public function getText(): string {
        return $this->text;
    }
}