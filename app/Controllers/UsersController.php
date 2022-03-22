<?php

namespace App\Controllers;
use App\Database;
use App\Models\Apartment;
use App\Models\UserProfile;
use App\Redirect;
use App\View;
use PDO;

class UsersController {

        public function index(): View {

            $new = Database::connection()->prepare('SELECT * FROM user_profiles WHERE user_id = ?');
            $new->execute([$_SESSION['user_id']]);

            while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
                $user = new UserProfile(
                    $row['name'],
                    $row['surname'],
                    $row['birthday'],
                    $row['user_id']
                );
            }

            $stmt = Database::connection()->prepare('SELECT apartment_reservations.id, total_price, name, apartment_id, reserved_from, reserved_till
FROM apartment_reservations JOIN apartments ON (apartment_id = apartments.id) WHERE reserver_id = ?');
            $stmt->execute([$_SESSION['user_id']]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $reservations[] = $row;
            }

            $new = Database::connection()->prepare('SELECT * FROM apartments WHERE creator_id = ?');
            $new->execute([$_SESSION['user_id']]);

            while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
                $creations[] = new Apartment(
                        $row['address'],
                        $row['name'],
                        $row['description'],
                        $row['available_from'],
                        $row['price'],
                        $row['creator_id'],
                        $row['id']
                    );
            }

            return new View('Users/index.html', [
                'user' => $user,
                'reservations' => $reservations,
                'creations' => $creations
            ]);
        }

        public function userData(): View {
            return new View('Users/userData.html');
        }

        public function save(array $vars): Redirect {
            $userID = $_SESSION['user_id'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $birthday = $_POST['birthday'];
            $new = Database::connection()->prepare('INSERT INTO user_profiles (user_id, name, surname, birthday)
            VALUES (?, ?, ?, ?)');
            $new->execute([$userID, $name, $surname, $birthday]);

            return new Redirect('/user/login');
        }

        public function register():View {
            return new View('Users/register.html');
        }

        public function signUp(): Redirect {
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $pwdRepeat = $_POST['pwd_repeat'];

            $new = Database::connection()->prepare('INSERT INTO users (email, pwd) VALUES (?, ?)');
            if ($pwd !== $pwdRepeat) return new Redirect('articles/x');

            $pwd = password_hash($pwd, PASSWORD_DEFAULT);
            $new->execute([$email, $pwd]);

            $new = Database::connection()->prepare('SELECT id FROM users WHERE email = ?');
            $new->execute([$email]);

            while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
                $val = $row;
            }
            $id = $val['id'];
            $_SESSION['user_id'] = $id;

            $userID = $_SESSION['user_id'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $birthday = $_POST['birthday'];

            $new = Database::connection()->prepare('INSERT INTO user_profiles (user_id, name, surname, birthday) 
VALUES (?, ?, ?, ?)');
            $new->execute([$userID, $name, $surname, $birthday]);

            $_SESSION['user_name'] = $name;
            return new Redirect('/apartments');
        }

    public function login(): View {
        return new View('Users/login.html');
    }

    public function signIn(): Redirect {
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $new = Database::connection()->prepare('SELECT pwd, id FROM users WHERE email = ?');
        $new->execute([$email]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
            $val = $row;
        }
        $id = $val['id'];

        $checkPwd = password_verify($pwd, $val['pwd']);

        if ($checkPwd == false) {
            header("location: ../index.php?error=usernotfound");
            exit();
        }

        $_SESSION['user_id'] = $id;

        $new = Database::connection()->prepare('SELECT name FROM user_profiles WHERE user_id = ?');
        $new->execute([$id]);

        while ($row = $new->fetch(PDO::FETCH_ASSOC)) {
             $name = $row['name'];
        }

        $_SESSION['user_name'] = $name;
        return new Redirect('/apartments');
    }

    public function logout(): Redirect {
            session_unset();
            return new Redirect('/');
    }

    public function home(): View {
            return new View('home.html');
    }
}