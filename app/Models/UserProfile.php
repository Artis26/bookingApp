<?php
namespace App\Models;

class UserProfile {
    private string $name;
    private string $surname;
    private string $birthday;
    private ?int $userID;

    public function __construct(string $name, string $surname, string $birthday, ?int $userID = null) {
        $this->name = $name;
        $this->surname = $surname;
        $this->birthday = $birthday;
        $this->userID = $userID;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSurname(): string {
        return $this->surname;
    }

    public function getBirthday(): string {
        return $this->birthday;
    }

    public function getUserID(): int {
        return $this->userID;
    }

}