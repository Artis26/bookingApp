<?php
namespace App\Services\ApartmentReviews\Edit;

use App\Models\ApartmentReview;

class EditApartmentReviewsResponse {
    private ApartmentReview $apartmentReview;

    public function __construct(ApartmentReview $apartmentReview) {
        $this->apartmentReview = $apartmentReview;
    }

    public function getApartmentReview(): ApartmentReview {
        return $this->apartmentReview;
    }
}