<?php
namespace App\Services\Users\SignIn;

use App\Database;
use PDO;

class SignInUsersServices {
    public function execute(SignInUsersRequest $request) {
        $new = Database::connection()->prepare('SELECT pwd, id FROM users WHERE email = ?');
        $new->execute([$request->getEmail()]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $val = $row;
        }
        return $val;
    }

    public function getUserName(int $id): string {
        $new = Database::connection()->prepare('SELECT name FROM user_profiles WHERE user_id = ?');
        $new->execute([$id]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $name = $row['name'];
        }
        return $name;
    }
}