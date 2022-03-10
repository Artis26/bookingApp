<?php
namespace App\Models;

class ApartmentReview {
    private int $rating;
    private int $userID;
    private string $userName;
    private int $apartmentID;
    private string $text;
    private string $createdAt;
    private ?int $id;

    public function __construct(int $rating, int $userID, string $userName, int $apartmentID, string $text, string $createdAt,
                                ?int $id = null) {
        $this->rating = $rating;
        $this->userID = $userID;
        $this->userName = $userName;
        $this->apartmentID = $apartmentID;
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->id = $id;
    }

    public function getRating(): int {
        return $this->rating;
    }

    public function getUserID(): int {
        return $this->userID;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getApartmentID(): int {
        return $this->apartmentID;
    }

    public function getText(): string {
        return $this->text;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function getID(): int {
        return $this->id;
    }
}