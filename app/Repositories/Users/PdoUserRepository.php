<?php
namespace App\Repositories\Users;

use App\Database;
use App\Models\Apartment;
use App\Models\UserProfile;
use PDO;

class PdoUserRepository implements UserRepository {
    public function getProfile(int $userId): UserProfile {
        $new = Database::connection()->prepare('SELECT * FROM user_profiles WHERE user_id = ?');
        $new->execute([$userId]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserProfile(
                $row['name'],
                $row['surname'],
                $row['birthday'],
                $row['user_id']
            );
        }
        return $user;
    }

    public function getReservations(int $userId): array {
        $reservations = [];
        $stmt = Database::connection()->prepare('SELECT apartment_reservations.id, total_price, name, apartment_id, reserved_from, reserved_till
FROM apartment_reservations JOIN apartments ON (apartment_id = apartments.id) WHERE reserver_id = ?');
        $stmt->execute([$userId]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = $row;
        }
        return $reservations;
    }

    public function getApartments(int $userId): array {
        $creations = [];
        $new = Database::connection()->prepare('SELECT * FROM apartments WHERE creator_id = ?');
        $new->execute([$userId]);

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
        return $creations;
    }
}