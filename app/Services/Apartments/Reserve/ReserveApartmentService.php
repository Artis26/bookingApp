<?php
namespace App\Services\Apartments\Reserve;

use App\Database;
use Carbon\CarbonPeriod;
use PDO;

class ReserveApartmentService {

    public function execute(ReserveApartmentRequest $request) {

        $period = CarbonPeriod::create($request->getReservedFrom(), $request->getReservedTill());
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        $check = Database::connection()->prepare('SELECT price FROM apartments WHERE id = ? ');
        $check->execute([$request->getApartmentId()]);
        while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
            $price = $row['price'];
        }

        $totalPrice = (count($dates) - 1) * $price;

        $new = Database::connection()->prepare('INSERT INTO apartment_reservations (apartment_id, reserver_id, reserved_from,
                          reserved_till, total_price) VALUES (?, ? ,? ,?, ?)');
        $new->execute([$request->getApartmentId(), $request->getUserId(), $request->getReservedFrom(), $request->getReservedTill(),
            $totalPrice]);
    }

    public function check(ReserveApartmentRequest $request): ?array {

        $check = Database::connection()->prepare('SELECT * FROM apartment_reservations WHERE reserved_from BETWEEN ? AND ? 
        && apartment_id = ?');
        $check->execute([$request->getReservedFrom(), $request->getReservedTill(), $request->getApartmentId()]);
        while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = $row;
        }

        return $reservations;
    }
}