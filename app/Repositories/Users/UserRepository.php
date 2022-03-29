<?php
namespace App\Repositories\Users;

use App\Models\UserProfile;

interface UserRepository {
    public function getReservations(int $userId): array;
    public function getApartments(int $userId): array;
    public function getProfile(int $userId): UserProfile;
}
