<?php
namespace App\Repositories\ApartmentReviews;

use App\Models\ApartmentReview;
use App\Models\ApartmentReviewFull;

interface ApartmentReviewRepository {
    public function update(int $rating, string $text, int $reviewId): void;
    public function store(ApartmentReview $apartmentReview): void;
    public function edit(int $reviewId): ApartmentReview;
    public function delete(int $reviewId): void;
}