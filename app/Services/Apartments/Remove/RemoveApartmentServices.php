<?php
namespace App\Services\Apartments\Remove;

use App\Database;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\PDOApartmentRepository;

class RemoveApartmentServices {
    private ApartmentRepository $apartmentRepository;

    public function __construct() {
        $this->apartmentRepository = new PDOApartmentRepository();
    }

    public function execute(RemoveApartmentRequest $request): void {
        $this->apartmentRepository->remove($request->getApartmentId());
    }
}