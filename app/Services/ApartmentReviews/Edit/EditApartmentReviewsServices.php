<?php
namespace App\Services\ApartmentReviews\Edit;

use App\Repositories\ApartmentReviews\ApartmentReviewRepository;
use App\Repositories\ApartmentReviews\PdoApartmentReviewRepository;

class EditApartmentReviewsServices {
    private ApartmentReviewRepository $apartmentReviewRepository;

    public function __construct() {
        $this->apartmentReviewRepository = new PdoApartmentReviewRepository();
    }

    public function execute(EditApartmentReviewsRequest $request): EditApartmentReviewsResponse {
        return new EditApartmentReviewsResponse($this->apartmentReviewRepository->edit($request->getReviewId()));
    }
}