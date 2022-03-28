<?php
namespace App\Repositories\Apartment;

use App\Models\Apartment;

interface ApartmentRepository {
    public function save(Apartment $apartment): void;
    public function delete(int $apartmentId): void;
    public function remove(int $reservationId): void;
    public function update(string $address, string $name, string $description, float $price, int $apartmentId): void;
    public function edit(int $apartmentId): Apartment;
}