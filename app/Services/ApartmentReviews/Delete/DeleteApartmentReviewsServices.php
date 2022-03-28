<?php
namespace App\Services\ApartmentReviews\Delete;

use App\Repositories\ApartmentReviews\ApartmentReviewRepository;
use App\Repositories\ApartmentReviews\PdoApartmentReviewRepository;

class DeleteApartmentReviewsServices {
    private ApartmentReviewRepository $apartmentReviewRepository;

    public function __construct() {
        $this->apartmentReviewRepository = new PdoApartmentReviewRepository();
    }

    public function execute(DeleteApartmentReviewsRequest $request): void {
        $this->apartmentReviewRepository->delete($request->getApartmentReviewId());
    }
}