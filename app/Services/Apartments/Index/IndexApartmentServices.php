<?php

namespace App\Services\Apartments\Index;

use App\Database;
use App\Models\ApartmentReviewFull;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\PDOApartmentRepository;
use Carbon\CarbonPeriod;
use PDO;

class IndexApartmentServices {
    private ApartmentRepository $apartmentRepository;

    public function __construct() {
        $this->apartmentRepository = new PDOApartmentRepository();
    }

    public function execute(IndexApartmentRequest $request): IndexApartmentResponse {
        $apartment = $this->apartmentRepository->getById($request->getApartmentId());

        $reviews = $this->apartmentRepository->getReviewsById($request->getApartmentId());

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