<?php
namespace App\Services\Apartments\Store;

use App\Database;
use App\Models\Apartment;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\PDOApartmentRepository;

class StoreApartmentServices {
    private ApartmentRepository $apartmentRepository;

    public function __construct() {
        $this->apartmentRepository = new PDOApartmentRepository();
    }

    public function execute(StoreApartmentRequest $request) {
        $apartment = new Apartment(
            $request->getAddress(),
            $request->getName(),
            $request->getDesc(),
            $request->getAvailableFrom(),
            $request->getPrice(),
            $request->getCreatorId()
        );
            $this->apartmentRepository->save($apartment);
    }
}