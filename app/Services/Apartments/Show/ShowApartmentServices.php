<?php
namespace App\Services\Apartments\Show;

use App\Database;
use App\Models\Apartment;
use App\Services\Apartments\Show\ShowApartmentResponse;
use PDO;

class ShowApartmentServices {

    public function execute(): ShowApartmentResponse {
        $query = Database::connection()->prepare('SELECT * FROM apartments');
        $query->execute();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $apartments[] = new Apartment(
                $row['address'],
                $row['name'],
                $row['description'],
                $row['available_from'],
                $row['price'],
                $row['creator_id'],
                $row['id']
            );
        }

        $query = Database::connection()->prepare('SELECT rating FROM apartment_reviews WHERE apartment_id = ?');
        foreach ($apartments as $one) {
            $o = $one->getID();
            $query->execute([$o]);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $ratings[$o][] = $row['rating'];
            }
            $ratingsAvg[$o][] = array_sum($ratings[$o]) / count($ratings[$o]);
        }

        return new ShowApartmentResponse(
            $apartments,
            $ratingsAvg
        );
    }
}