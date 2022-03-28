<?php
namespace App\Services\ApartmentReviews\Store;

use App\Models\ApartmentReview;
use App\Repositories\ApartmentReviews\ApartmentReviewRepository;
use App\Repositories\ApartmentReviews\PdoApartmentReviewRepository;

class StoreApartmentReviewsServices {
    private ApartmentReviewRepository $apartmentReviewRepository;

    public function __construct() {
        $this->apartmentReviewRepository = new PdoApartmentReviewRepository();
    }

    public function execute(StoreApartmentReviewsRequest $request) {
        $apartmentReview = new ApartmentReview(
            $request->getRating(),
            $request->getUserId(),
            $request->getApartmentId(),
            $request->getText()
        );
        $this->apartmentReviewRepository->store($apartmentReview);
    }
}