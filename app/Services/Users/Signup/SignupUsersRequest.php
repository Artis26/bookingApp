<?php
namespace App\Services\Users\Signup;

class SignupUsersRequest {
    private string $email;
    private string $pwd;

    public function __construct(string $email, string $pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPwd(): string {
        return $this->pwd;
    }
}

class CreateUserRequest {
    private int $userId;
    private string $name;
    private string $surname;
    private string $birthday;

    public function __construct(int $userId, string $name, string $surname, string $birthday) {
        $this->userId = $userId;
        $this->name = $name;
        $this->surname = $surname;
        $this->birthday = $birthday;
    }

    public function getUserId(): int {
        return $this->userId;
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
}