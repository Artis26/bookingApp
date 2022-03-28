<?php

namespace App\Controllers;

use App\Database;
use App\Models\Apartment;
use App\Redirect;
use App\Services\Apartments\Delete\DeleteApartmentRequest;
use App\Services\Apartments\Delete\DeleteApartmentServices;
use App\Services\Apartments\Edit\EditApartmentRequest;
use App\Services\Apartments\Edit\EditApartmentServices;
use App\Services\Apartments\Index\IndexApartmentRequest;
use App\Services\Apartments\Index\IndexApartmentServices;
use App\Services\Apartments\Remove\RemoveApartmentRequest;
use App\Services\Apartments\Remove\RemoveApartmentServices;
use App\Services\Apartments\Reserve\ReserveApartmentRequest;
use App\Services\Apartments\Reserve\ReserveApartmentService;
use App\Services\Apartments\Show\ShowApartmentServices;
use App\Services\Apartments\Store\StoreApartmentRequest;
use App\Services\Apartments\Store\StoreApartmentServices;
use App\Services\Apartments\Update\UpdateApartmentRequest;
use App\Services\Apartments\Update\UpdateApartmentServices;
use App\View;
use Carbon\CarbonPeriod;
use PDO;

class ApartmentController {

    public function index(array $vars): View {
        $articleId = $vars['id'];
        $service = new IndexApartmentServices();
        $response = $service->execute(new IndexApartmentRequest($articleId));

        return new View('Apartments/index.html', [
            'apartment' => $response->getApartment(),
            'reviews' => $response->getReviews(),
            'rating' => $response->getRating(),
            'disabledDates' => $response->getDates()
        ]);
    }

    public function show(): View {
        $service = new ShowApartmentServices();
        $response = $service->execute();

        return new View('Apartments/show.html', [
            'apartments' => $response->getApartments(),
            'ratings' => $response->getRatings()
        ]);
    }

    public function create(): View {
        if ($_SESSION['user_id'] == "") {
            return new View('Users/login.html');
        }
        return new View('Apartments/create.html');
    }

    public function store(): Redirect {
        $service = new StoreApartmentServices();
        $service->execute(new StoreApartmentRequest($_POST['address'], $_POST['name'], $_POST['description'], $_POST['available_from'],
            (float) $_POST['price'], $_SESSION['user_id']));

        return new Redirect('/apartments');
    }

    public function reserve(array $vars): Redirect {

        if ($_SESSION['user_id'] == "") {
            return new Redirect('/user/login');
        }

        $apartmentID = $vars['id'];
        $userID = $_SESSION['user_id'];
        $reserveFrom = $_POST['reserve_from'];
        $reserveTill = $_POST['reserve_till'];

        $service = new ReserveApartmentService();
        $reservations = $service->check(new ReserveApartmentRequest($apartmentID, $userID, $reserveFrom, $reserveTill));

        if (!empty($reservations)) {
            $_SESSION['errors'][] = "Apartment already reserved during this [$reserveFrom to $reserveTill] time period. ";
            return new Redirect('/apartment/' . $apartmentID);
        }

        $service->execute(new ReserveApartmentRequest($apartmentID, $userID, $reserveFrom, $reserveTill));

        return new Redirect('/apartment/' . $apartmentID);
    }

    public function remove($vars): Redirect {
        $service = new RemoveApartmentServices();
        $service->execute(new RemoveApartmentRequest($vars['reservation_id']));

        return new Redirect('/user/' . $_SESSION['user_id']);
    }

    public function deleteApart($vars): Redirect {
        $service = new DeleteApartmentServices();
        $service->execute(new DeleteApartmentRequest($vars['id']));

        return new Redirect('/user/' . $_SESSION['user_id']);
    }

    public function edit($vars): View {
        $apartmentId = $vars['id'];

        $service = new EditApartmentServices();
        $response = $service->execute(new EditApartmentRequest($apartmentId));

        return new View("Apartments/edit.html", [
            'apartmentInfo' => $response->getApartment()
        ]);
    }

    public function update($vars): Redirect {
        $address = $_POST['address'];
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $price = $_POST['price'];
        $id = $vars["id"];

        $service = new UpdateApartmentServices();
        $service->execute(new UpdateApartmentRequest($address, $name, $desc, (float) $price, $id));

        return new Redirect('/user' . '/' . $_SESSION['user_id']);
    }
}