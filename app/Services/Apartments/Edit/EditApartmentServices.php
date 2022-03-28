<?php
namespace App\Services\Apartments\Edit;

use App\Database;
use App\Models\Apartment;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\PDOApartmentRepository;
use PDO;

class EditApartmentServices {
    private ApartmentRepository $apartmentRepository;

    public function __construct() {
        $this->apartmentRepository = new PDOApartmentRepository();
    }

    public function execute(EditApartmentRequest $request): EditApartmentResponse {
        return new EditApartmentResponse($this->apartmentRepository->edit($request->getApartmentId()));
    }
}