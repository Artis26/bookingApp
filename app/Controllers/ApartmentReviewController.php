<?php

namespace App\Controllers;

use App\Database;
use App\Exceptions\ResourceNotFoundException;
use App\Redirect;
use App\View;
use PDO;

class ApartmentReviewController {

    public function store(array $vars): Redirect {
        $apartmentID = $vars['id'];
        $userID = $_SESSION['user_id'];
        $userName = $_SESSION['user_name'];
        $rating = $_POST['rating'];
        $text = $_POST['text'];
        $new = Database::connection()->prepare('INSERT INTO apartment_reviews (apartment_id, user_id, user_name, 
                               rating, text) VALUES (?, ? ,? ,?, ?)');
        $new->execute([$apartmentID, $userID, $userName, $rating, $text]);

        return new Redirect('/apartment/' . $apartmentID);
    }

    public function delete(array $vars): Redirect {
        $apartmentID = $vars['id'];
        $new = Database::connection()->prepare('DELETE FROM apartment_reviews WHERE id = ?');
        $new->execute([$vars['review_id']]);
        return new Redirect('/apartment/' . $apartmentID);
    }

    public function edit(array $vars) {
        $query = Database::connection()->prepare('SELECT * FROM apartment_reviews WHERE id = ?');
        $query->execute([$vars['review_id']]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $review = $row;
        }

        return new View('Apartments/editReview.html', [
            'review' => $review
        ]);
    }

    public function update(array $vars): Redirect {
        $new = Database::connection()->prepare('UPDATE apartment_reviews SET rating = ?, text = ? WHERE id = ?');
        $id = (int)$vars["id"];
        $new->execute([$_POST['rating'], $_POST['text'], $id]);

        return new Redirect('/apartment' . '/' . $id);
    }
}
