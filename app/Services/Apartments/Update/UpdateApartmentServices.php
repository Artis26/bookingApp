<?php
namespace App\Services\Apartments\Update;

use App\Database;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\PDOApartmentRepository;

class UpdateApartmentServices {
    private ApartmentRepository $apartmentRepository;
    public function __construct() {
        $this->apartmentRepository = new PDOApartmentRepository();
    }

    public function execute(UpdateApartmentRequest $request): void {
        $this->apartmentRepository->update($request->getAddress(), $request->getName(), $request->getDesc(), $request->getPrice(), $request->getId());
    }
}
