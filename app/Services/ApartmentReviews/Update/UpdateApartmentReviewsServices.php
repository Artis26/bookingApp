<?php
namespace App\Services\ApartmentReviews\Update;

use App\Database;
use App\Repositories\ApartmentReviews\ApartmentReviewRepository;
use App\Repositories\ApartmentReviews\PdoApartmentReviewRepository;

class UpdateApartmentReviewsServices {

    private ApartmentReviewRepository $apartmentReviewRepository;

    public function __construct() {
        $this->apartmentReviewRepository = new PdoApartmentReviewRepository();
    }

    public function execute(UpdateApartmentReviewsRequest $request){
        $this->apartmentReviewRepository->update($request->getRating(), $request->getText(), $request->getReviewId());
    }
}