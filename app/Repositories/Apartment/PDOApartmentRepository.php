<?php

namespace App\Repositories\Apartment;

use App\Database;
use App\Models\Apartment;
use PDO;

class PDOApartmentRepository implements ApartmentRepository {

    public function save(Apartment $apartment): void {
        $new = Database::connection()->prepare('INSERT INTO apartments (address, name, description, available_from,
                        price, creator_id) VALUES (?, ? ,? ,?, ?, ?)');
        $new->execute([$apartment->getAddress(), $apartment->getName(), $apartment->getDescription(), $apartment->getAvailableFrom(),
            $apartment->getPrice(), $apartment->getCreatorId()]);
    }

    public function delete(int $apartmentId): void {
        $new = Database::connection()->prepare('DELETE FROM apartments WHERE id = ?');
        $new->execute([$apartmentId]);
    }

    public function remove(int $reservationId): void {
        $new = Database::connection()->prepare('DELETE FROM apartment_reservations WHERE id = ?');
        $new->execute([$reservationId]);
    }

    public function update(string $address, string $name, string $description, float $price, int $apartmentId): void {
        $new = Database::connection()->prepare('UPDATE apartments SET address = ?, name = ?, description = ?, 
                      price = ? WHERE id = ?');
        $new->execute([$address, $name, $description, $price, $apartmentId]);
    }

    public function edit(int $apartmentId): Apartment {
        $new = Database::connection()->prepare('SELECT * FROM apartments WHERE id = ?');
        $new->execute([$apartmentId]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $apartmentInfo = new Apartment(
                $row['address'],
                $row['name'],
                $row['description'],
                $row['available_from'],
                $row['price'],
                $row['creator_id'],
                $row['id']
            );
        }
        return $apartmentInfo;
    }
}
