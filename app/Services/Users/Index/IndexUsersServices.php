<?php
namespace App\Services\Users\Index;

use App\Database;
use App\Models\Apartment;
use App\Models\UserProfile;
use App\Repositories\Users\PdoUserRepository;
use App\Repositories\Users\UserRepository;
use PDO;

class IndexUsersServices {
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new PdoUserRepository();
    }

    public function execute(IndexUsersRequest $request) {
        $user = $this->userRepository->getProfile($request->getUserId());

       $reservations = $this->userRepository->getReservations($request->getUserId());

        $creations = $this->userRepository->getApartments($request->getUserId());

        return new IndexUsersResponse($user, $creations, $reservations);
    }
}