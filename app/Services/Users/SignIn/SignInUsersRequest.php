<?php
namespace App\Services\Users\SignIn;

class SignInUsersRequest {
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
