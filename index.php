<?php
require 'vendor/autoload.php';
session_start();
$_SESSION['today'] = date('d-m-Y');
use App\Controllers\ApartmentController;
use App\Controllers\ApartmentReviewController;
use App\Controllers\UsersController;
use App\Redirect;
use App\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [UsersController::class, 'home']);
    $r->addRoute('GET', '/user/{id:\d+}', [UsersController::class, 'index']);
    //users
    $r->addRoute('GET', '/user_data', [UsersController::class, 'userData']);
    $r->addRoute('POST', '/user_data/{id:\d+}', [UsersController::class, 'save']);

    $r->addRoute('GET', '/user/register', [UsersController::class, 'register']);
    $r->addRoute('POST', '/user/register', [UsersController::class, 'signUp']);

    $r->addRoute('GET', '/user/login', [UsersController::class, 'login']);
    $r->addRoute('POST', '/user/login', [UsersController::class, 'signIn']);

    $r->addRoute('POST', '/user/logout', [UsersController::class, 'logout']);

    //apartments
    $r->addRoute('GET', '/apartment/{id:\d+}', [ApartmentController::class, 'index']);
    $r->addRoute('GET', '/apartments', [ApartmentController::class, 'show']);

    $r->addRoute('GET', '/apartment/create', [ApartmentController::class, 'create']);
    $r->addRoute('POST', '/apartment', [ApartmentController::class, 'store']);

    $r->addRoute('POST', '/apartment/{id:\d+}/reserve', [ApartmentController::class, 'reserve']);

    $r->addRoute('POST', '/apartment/delete/{reservation_id:\d+}', [ApartmentController::class, 'delete']);

    //review
    $r->addRoute('POST', '/apartment/{id:\d+}/review', [ApartmentReviewController::class, 'store']);
    $r->addRoute('POST', '/apartment/{id:\d+}/review/{review_id:\d+}/delete', [ApartmentReviewController::class, 'delete']);

    $r->addRoute('GET', '/apartment/{id:\d+}/review/{review_id:\d+}/edit', [ApartmentReviewController::class, 'edit']);
    $r->addRoute('POST', '/apartment/{id:\d+}/review/{review_id:\d+}/update', [ApartmentReviewController::class, 'update']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:

        $handler = $routeInfo[1][0];
        $controller = $handler[0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];

        /** @var View $response */
        $response = (new $handler)->$method($vars);

        $loader = new FilesystemLoader('app/View');
        $twig = new Environment($loader);
        $twig->addGlobal('session', $_SESSION);

        if ($response instanceof View) {
            echo $twig->render($response->getPath(), $response->getVariables());
            break;
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getLocation());
            exit;
        }


        break;
}

if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}

if (isset($_SESSION['inputs'])) {
    unset($_SESSION['inputs']);
}