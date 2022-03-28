<?php
declare(strict_types=1);

use App\Models\Apartment;
use PHPUnit\Framework\TestCase;

final class ApartmentTest extends TestCase {

    public function testGetAddress(): void {
        $apartment = new Apartment('Laimes iela 2', 'Room', 'This is nice',
        '2022/03/22', (float)'10', 1);
        $this->assertSame("Laimes iela 2",$apartment->getAddress());
    }

    public function testGetName(): void {
        $apartment = new Apartment('Laimes iela 2', 'Room', 'This is nice',
            '2022/03/22', (float)'10', 1);
        $this->assertSame("Room",$apartment->getName());
    }

    public function testGetDescription(): void {
        $apartment = new Apartment('Laimes iela 2', 'Room', 'This is nice',
            '2022/03/22', (float)'10', (int)'1');
        $this->assertSame('This is nice',$apartment->getDescription());
    }

    public function testGetAvailableFrom(): void {
        $apartment = new Apartment('Laimes iela 2', 'Room', 'This is nice',
            '2022/03/22', (float)'10', (int)'1');
        $this->assertSame('2022/03/22',$apartment->getAvailableFrom());
    }

    public function testGetPrice(): void {
        $apartment = new Apartment('Laimes iela 2', 'Room', 'This is nice',
            '2022/03/22', (float)'10', (int)'1');
        $this->assertSame((float) '10',$apartment->getPrice());
    }

    public function testGetCreatorID(): void {
        $apartment = new Apartment('Laimes iela 2', 'Room', 'This is nice',
            '2022/03/22', (float)'10', (int)'1');
        $this->assertSame((int) '1',$apartment->getCreatorID());
    }
}