<?php

namespace App\Services\Apartments\Index;

use App\Database;
use App\Models\Apartment;
use App\Models\ApartmentReviewFull;
use Carbon\CarbonPeriod;
use PDO;

class IndexApartmentServices {

    public function execute(IndexApartmentRequest $request): IndexApartmentResponse {
        $query = Database::connection()->prepare('SELECT * FROM apartments where id = ?');
        $query->execute([$request->getApartmentId()]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $apartment = new Apartment(
                $row['address'],
                $row['name'],
                $row['description'],
                $row['available_from'],
                $row['price'],
                $row['creator_id'],
                $row['id']
            );
        }

        $reviews=[];
        $query = Database::connection()->prepare('SELECT apartment_reviews.*, user_profiles.name FROM apartment_reviews JOIN user_profiles ON (apartment_reviews.user_id = user_profiles.user_id) WHERE apartment_id = ?');
        $query->execute([$request->getApartmentId()]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $reviews[] = new ApartmentReviewFull(
                $row['rating'],
                $row['user_id'],
                $row['name'],
                $row['apartment_id'],
                $row['text'],
                $row['created_at'],
                $row['id']
            );
        }

        $ratings=[];
        $query = Database::connection()->prepare('SELECT rating FROM apartment_reviews WHERE apartment_id = ?');
        $query->execute([$request->getApartmentId()]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $ratings[] = $row['rating'];
        }

        $query = Database::connection()->prepare('SELECT  reserved_from, reserved_till FROM apartment_reservations
        WHERE apartment_id = ? ORDER BY reserved_from ASC');
        $query->execute([$request->getApartmentId()]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = $row;
        }

        $dates = [];
        foreach ($reservations as $one) {
            $startDate = $one['reserved_from'];
            $endDate = $one['reserved_till'];
            $period = CarbonPeriod::create($startDate, $endDate);
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        return new IndexApartmentResponse(
            $apartment,
            $reviews,
            $ratings,
            $dates
        );
    }
}