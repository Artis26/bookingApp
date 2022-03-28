<?php
namespace App\Models;

use App\Models\ApartmentReview;

class ApartmentReviewFull extends ApartmentReview {
    private string $userName;

    public function __construct(int $rating, int $userID, string $userName, int $apartmentID, string $text, string $createdAt, ?int $id = null) {
        parent::__construct($rating, $userID, $apartmentID, $text, $createdAt, $id);
        $this->userName = $userName;
    }

    public function getUserName(): string {
        return $this->userName;
    }
}