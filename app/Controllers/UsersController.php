<?php

namespace App\Controllers;
use App\Database;
use App\Redirect;
use App\Services\Users\Index\IndexUsersRequest;
use App\Services\Users\Index\IndexUsersServices;
use App\Services\Users\SignIn\SignInUsersRequest;
use App\Services\Users\SignIn\SignInUsersServices;
use App\Services\Users\Signup\CreateUserRequest;
use App\Services\Users\Signup\SignupUsersRequest;
use App\Services\Users\Signup\SignupUsersServices;

use App\View;

class UsersController {

        public function index(): View {
            $service = new IndexUsersServices();
            $response = $service->execute(new IndexUsersRequest($_SESSION['user_id']));

            return new View('Users/index.html', [
                'user' => $response->getUser(),
                'reservations' => $response->getReservations(),
                'creations' => $response->getApartments()
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

            if ($pwd !== $pwdRepeat) return new Redirect('articles/x');

            $service = new SignupUsersServices();
            $_SESSION['user_id'] = $service->execute(new SignupUsersRequest($email, $pwd));

            $userID = $_SESSION['user_id'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $birthday = $_POST['birthday'];

            $_SESSION['user_name'] = $service->createUserProfile(new CreateUserRequest($userID, $name, $surname, $birthday));
            return new Redirect('/apartments');
        }

    public function login(): View {
        return new View('Users/login.html');
    }

    public function signIn(): Redirect {
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];

        $service = new SignInUsersServices();
        $userIdAndPwd = $service->execute(new SignInUsersRequest($email, $pwd));

        $id = $userIdAndPwd['id'];
        $checkPwd = password_verify($pwd, $userIdAndPwd['pwd']);

        if ($checkPwd == false) {
            header("location: ../index.php?error=usernotfound");
            exit();
        }

        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $service->getUserName($id);
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