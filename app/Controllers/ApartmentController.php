<?php

namespace App\Controllers;

use App\Database;
use App\Models\Apartment;
use App\Models\ApartmentReview;
use App\Redirect;
use App\Validation\Errors;
use App\View;
use Carbon\CarbonPeriod;
use PDO;

class ApartmentController {

    public function index(array $vars) {
        $query = Database::connection()->prepare('SELECT * FROM apartments where id = ?');
        $query->execute([$vars['id']]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $apartment = new Apartment(
                $row['address'],
                $row['name'],
                $row['description'],
                $row['available_from'],
                $row['price'],
                $row['creator_id'],
                $row['id']
            );
        }

        $query = Database::connection()->prepare('SELECT * FROM apartment_reviews where apartment_id = ?');
        $query->execute([$vars['id']]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $reviews[] = new ApartmentReview(
                $row['rating'],
                $row['user_id'],
                $row['user_name'],
                $row['apartment_id'],
                $row['text'],
                $row['created_at'],
                $row['id']
            );
        }

        $query = Database::connection()->prepare('SELECT rating FROM apartment_reviews WHERE apartment_id = ?');
        $query->execute([$vars['id']]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $ratings[] = $row['rating'];
        }

        $ratingAvg = array_sum($ratings) / count($ratings);

        $query = Database::connection()->prepare('SELECT  reserved_from, reserved_till FROM apartment_reservations
        WHERE apartment_id = ? ORDER BY reserved_from ASC');
        $query->execute([$vars['id']]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = $row;
        }

        $dates = [];
        foreach ($reservations as $one) {
            $startDate = $one['reserved_from'];
            $endDate = $one['reserved_till'];
            $period = CarbonPeriod::create($startDate, $endDate);
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        return new View('Apartments/index.html', [
            'apartment' => $apartment,
            'reviews' => $reviews,
            'rating' => $ratingAvg,
            'disabledDates' => $dates
        ]);
    }

    public function show(): View {
        $query = Database::connection()->prepare('SELECT * FROM apartments');
        $query->execute();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $apartments[] = new Apartment(
                $row['address'],
                $row['name'],
                $row['description'],
                $row['available_from'],
                $row['price'],
                $row['creator_id'],
                $row['id']
            );
        }

        $query = Database::connection()->prepare('SELECT rating FROM apartment_reviews WHERE apartment_id = ?');
        foreach ($apartments as $one) {
            $o = $one->getID();
            $query->execute([$o]);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $ratings[$o][] = $row['rating'];
            }
            $ratingsAvg[$o][] = array_sum($ratings[$o]) / count($ratings[$o]);
        }

        return new View('Apartments/show.html', [
            'apartments' => $apartments,
            'ratings' => $ratingsAvg
        ]);
    }

    public function create(): View {
        if ($_SESSION['user_id'] == "") {
            return new View('Users/login.html');
        }
        return new View('Apartments/create.html');
    }

    public function store(): Redirect {
        $address = $_POST['address'];
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $availableFrom = $_POST['available_from'];
        $price = $_POST['price'];
        $creatorID = $_SESSION['user_id'];

        $new = Database::connection()->prepare('INSERT INTO apartments (address, name, description, available_from,
                        price, creator_id) VALUES (?, ? ,? ,?, ?, ?)');
        $new->execute([$address, $name, $desc, $availableFrom, $price, $creatorID]);

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

        $check = Database::connection()->prepare('SELECT * FROM apartment_reservations WHERE reserved_from BETWEEN ? AND ? 
        && apartment_id = ?');
        $check->execute([$reserveFrom, $reserveTill, $apartmentID]);
        while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }

        if (!empty($res)) {
            $_SESSION['errors'][] = "Apartment already reserved during this [$reserveFrom to $reserveTill] time period. ";
            return new Redirect('/apartment/' . $apartmentID);
        }

        $period = CarbonPeriod::create($reserveFrom, $reserveTill);
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        $check = Database::connection()->prepare('SELECT price FROM apartments WHERE id = ? ');
        $check->execute([$apartmentID]);
        while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
            $price = $row['price'];
        }
        $totalPrice = (count($dates) - 1) * $price;

        $new = Database::connection()->prepare('INSERT INTO apartment_reservations (apartment_id, reserver_id, reserved_from,
                          reserved_till, total_price) VALUES (?, ? ,? ,?, ?)');
        $new->execute([$apartmentID, $userID, $reserveFrom, $reserveTill, $totalPrice]);

        return new Redirect('/apartment/' . $apartmentID);
    }

    public function remove($vars): Redirect {
        $new = Database::connection()->prepare('DELETE FROM apartment_reservations WHERE id = ?');
        $new->execute([$vars['reservation_id']]);

        return new Redirect('/user/' . $_SESSION['user_id']);
    }

    public function deleteApart($vars): Redirect {
        $new = Database::connection()->prepare('DELETE FROM apartments WHERE id = ?');
        $new->execute([$vars['id']]);

        return new Redirect('/user/' . $_SESSION['user_id']);
    }

    public function edit($vars): View {
        $new = Database::connection()->prepare('SELECT * FROM apartments WHERE id = ?');
        $new->execute([$vars['id']]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $apartmentInfo = new Apartment(
                $row['address'],
                $row['name'],
                $row['description'],
                $row['available_from'],
                $row['price'],
                $row['creator_id'],
                $row['id']
            );
        }

        return new View("Apartments/edit.html", [
            'apartmentInfo' => $apartmentInfo
        ]);
    }

    public function update($vars): Redirect {
        $new = Database::connection()->prepare('UPDATE apartments SET address = ?, name = ?, description = ?, 
                      price = ? WHERE id = ?');
        $id = $vars["id"];
        $new->execute([$_POST['address'], $_POST['name'], $_POST['description'], $_POST['price'], $id]);

        return new Redirect('/user' . '/' . $_SESSION['user_id']);
    }
}