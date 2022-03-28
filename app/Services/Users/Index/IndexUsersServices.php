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
        $new = Database::connection()->prepare('SELECT * FROM user_profiles WHERE user_id = ?');
        $new->execute([$request->getUserId()]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserProfile(
                $row['name'],
                $row['surname'],
                $row['birthday'],
                $row['user_id']
            );
        }

        $reservations = [];
        $stmt = Database::connection()->prepare('SELECT apartment_reservations.id, total_price, name, apartment_id, reserved_from, reserved_till
FROM apartment_reservations JOIN apartments ON (apartment_id = apartments.id) WHERE reserver_id = ?');
        $stmt->execute([$request->getUserId()]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = $row;
        }

        $creations = [];
        $new = Database::connection()->prepare('SELECT * FROM apartments WHERE creator_id = ?');
        $new->execute([$request->getUserId()]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $creations[] = new Apartment(
                $row['address'],
                $row['name'],
                $row['description'],
                $row['available_from'],
                $row['price'],
                $row['creator_id'],
                $row['id']
            );
        }

        return new IndexUsersResponse($user, $creations, $reservations);
    }
}