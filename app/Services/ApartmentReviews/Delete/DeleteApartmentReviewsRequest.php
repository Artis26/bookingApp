<?php
namespace App\Services\ApartmentReviews\Delete;

class DeleteApartmentReviewsRequest {
    private int $apartmentReviewId;

    public function __construct(int $apartmentReviewId) {
        $this->apartmentReviewId = $apartmentReviewId;
    }

    public function getApartmentReviewId(): int {
        return $this->apartmentReviewId;
    }
}