<?php

declare(strict_types=1);

session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/Core/Autoloader.php';

use App\Core\Autoloader;

Autoloader::register();

require_once BASE_PATH . '/app/Helpers/helpers.php';

if (
    !isset($_SESSION['user_id']) &&
    isset($_COOKIE['remember_token'])
) {

    $token = $_COOKIE['remember_token'];

    $rememberTokenModel =
        new \App\Models\RememberTokenModel();

    $rememberedUser =
        $rememberTokenModel->findValidToken($token);

    if ($rememberedUser !== null) {

        session_regenerate_id(true);

        $_SESSION['user_id'] =
            $rememberedUser['user_id'];

        $_SESSION['user_name'] =
            $rememberedUser['name'];

        $_SESSION['user_email'] =
            $rememberedUser['email'];
    }
}




require_once BASE_PATH . '/app/Core/Router.php';

$router = new Router();

require_once BASE_PATH . '/routes/web.php';

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);