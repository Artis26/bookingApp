<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Models\ApartmentReview;

final class ApartmentReviewTest extends TestCase {

    public function testGetRating(): void {
        $apartment = new ApartmentReview(6, 2, 'Artis', 5, 'This is nice',
        '22/03/2022' );
        $this->assertSame(6,$apartment->getRating());
    }

    public function testGetUserID(): void {
        $apartment = new ApartmentReview(6, 2, 'Artis', 5, 'This is nice',
            '22/03/2022' );
        $this->assertSame(2,$apartment->getUserID());
    }

    public function testGetUserName(): void {
        $apartment = new ApartmentReview(6, 2, 'Artis', 5, 'This is nice',
            '22/03/2022' );
        $this->assertSame('Artis',$apartment->getUserName());
    }

    public function testGetApartmentID(): void {
        $apartment = new ApartmentReview(6, 2, 'Artis', 5, 'This is nice',
            '22/03/2022' );
        $this->assertSame(5,$apartment->getApartmentID());
    }

    public function testGetCreatedAt(): void {
        $apartment = new ApartmentReview(6, 2, 'Artis', 5, 'This is nice',
            '22/03/2022' );
        $this->assertSame('22/03/2022',$apartment->getCreatedAt());
    }

}