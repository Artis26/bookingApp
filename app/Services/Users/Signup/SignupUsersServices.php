<?php
namespace App\Services\Users\Signup;

use App\Database;
use PDO;

class SignupUsersServices {

    public function execute(SignupUsersRequest $request): int {
        $new = Database::connection()->prepare('INSERT INTO users (email, pwd) VALUES (?, ?)');
        $pwd = password_hash($request->getPwd(), PASSWORD_DEFAULT);
        $new->execute([$request->getEmail(), $pwd]);

        $new = Database::connection()->prepare('SELECT id FROM users WHERE email = ?');
        $new->execute([$request->getEmail()]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $val = $row;
        }
        return $val['id'];
    }

    public function createUserProfile(CreateUserRequest $createUserRequest): string {
        $new = Database::connection()->prepare('INSERT INTO user_profiles (user_id, name, surname, birthday) 
VALUES (?, ?, ?, ?)');
        $new->execute([$createUserRequest->getUserId(), $createUserRequest->getName(), $createUserRequest->getSurname(), $createUserRequest->getBirthday()]);

        return $createUserRequest->getName();
    }
}