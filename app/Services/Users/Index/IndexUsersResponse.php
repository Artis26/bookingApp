<?php
namespace App\Services\Users\Index;
use App\Models\User;
use App\Models\UserProfile;

class IndexUsersResponse {

    private UserProfile $user;
    private array $apartments;
    private array $reservations;

    public function __construct(UserProfile $user, array $apartments, array $reservations) {
        $this->user = $user;
        $this->apartments = $apartments;
        $this->reservations = $reservations;
    }

    public function getUser(): UserProfile {
        return $this->user;
    }

    public function getApartments(): array {
        return $this->apartments;
    }

    public function getReservations(): array {
        return $this->reservations;
    }

}