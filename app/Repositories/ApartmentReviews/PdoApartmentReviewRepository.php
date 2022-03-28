<?php
namespace App\Repositories\ApartmentReviews;

use App\Database;
use App\Models\ApartmentReview;
use App\Models\ApartmentReviewFull;
use PDO;

class PdoApartmentReviewRepository implements ApartmentReviewRepository {
    public function update(int $rating, string $text, int $reviewId): void {
        $new = Database::connection()->prepare('UPDATE apartment_reviews SET rating = ?, text = ? WHERE id = ?');
        $new->execute([$rating, $text. $reviewId]);
    }

    public function store(ApartmentReview $apartmentReview): void {
        $new = Database::connection()->prepare('INSERT INTO apartment_reviews (apartment_id, user_id, 
                               rating, text) VALUES (?, ? ,?, ?)');
        $new->execute([$apartmentReview->getApartmentId(), $apartmentReview->getUserId(), $apartmentReview->getRating(), $apartmentReview->getText()]);
    }

    public function edit(int $reviewId): ApartmentReview {
        $query = Database::connection()->prepare('SELECT * FROM apartment_reviews WHERE id = ?');
        $query->execute([$reviewId]);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $review = new ApartmentReview(
                $row['rating'],
                $row['user_id'],
                $row['apartment_id'],
                $row['text'],
                $row['created_at'],
                $row['id']
            );
        }
        return $review;
    }

    public function delete(int $reviewId): void {
        $new = Database::connection()->prepare('DELETE FROM apartment_reviews WHERE id = ?');
        $new->execute([$reviewId]);
    }
}