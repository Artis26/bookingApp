<?php
namespace App\Services\ApartmentReviews\Update;

class UpdateApartmentReviewsRequest {
    private string $text;
    private int $rating;
    private int $reviewId;

    public function __construct(string $text, int $rating, int $reviewId) {
        $this->text = $text;
        $this->rating = $rating;
        $this->reviewId = $reviewId;
    }

    public function getText(): string {
        return $this->text;
    }

    public function getRating(): int {
        return $this->rating;
    }

    public function getReviewId(): int {
        return $this->reviewId;
    }
}