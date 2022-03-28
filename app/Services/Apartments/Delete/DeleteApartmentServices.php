<?php

namespace App\Services\Apartments\Delete;

use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\PDOApartmentRepository;

class DeleteApartmentServices {
    private ApartmentRepository $apartmentRepository;

    public function __construct() {
        $this->apartmentRepository = new PDOApartmentRepository();
    }

    public function execute(DeleteApartmentRequest $request) {
        $this->apartmentRepository->delete($request->getApartmentID());
    }
}