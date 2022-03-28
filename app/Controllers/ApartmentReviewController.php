<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\ApartmentReviews\Delete\DeleteApartmentReviewsRequest;
use App\Services\ApartmentReviews\Delete\DeleteApartmentReviewsServices;
use App\Services\ApartmentReviews\Edit\EditApartmentReviewsRequest;
use App\Services\ApartmentReviews\Edit\EditApartmentReviewsServices;
use App\Services\ApartmentReviews\Store\StoreApartmentReviewsRequest;
use App\Services\ApartmentReviews\Store\StoreApartmentReviewsServices;
use App\Services\ApartmentReviews\Update\UpdateApartmentReviewsRequest;
use App\Services\ApartmentReviews\Update\UpdateApartmentReviewsServices;
use App\View;

class ApartmentReviewController {

    public function store(array $vars): Redirect {
        $apartmentID = $vars['id'];
        $userID = $_SESSION['user_id'];
        $rating = $_POST['rating'];
        $text = $_POST['text'];

        if ($userID == "") {
            return new Redirect('/user/login');
        }

        $service = new StoreApartmentReviewsServices();
        $service->execute(new StoreApartmentReviewsRequest($apartmentID, $userID, $rating, $text));

        return new Redirect('/apartment/' . $apartmentID);
    }

    public function delete(array $vars): Redirect {
        $apartmentReviewId = $vars['review_id'];
        $service = new DeleteApartmentReviewsServices();
        $service->execute(new DeleteApartmentReviewsRequest($apartmentReviewId));

        return new Redirect('/apartment/' . $vars['id']);
    }

    public function edit(array $vars): View {
        $reviewId = $vars['review_id'];
        $service = new EditApartmentReviewsServices();
        $response = $service->execute(new EditApartmentReviewsRequest($reviewId));

        return new View('Apartments/editReview.html', [
            'review' => $response->getApartmentReview()
        ]);
    }

    public function update(array $vars): Redirect {
        $reviewId = (int)$vars["id"];
        $service = new UpdateApartmentReviewsServices();
        $service->execute(new UpdateApartmentReviewsRequest($_POST['rating'], $_POST['text'], $reviewId));

        return new Redirect('/apartment' . '/' . $reviewId);
    }
}
