<?php

declare(strict_types=1);

session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/Core/Router.php';
require_once BASE_PATH . '/app/Helpers/helpers.php';

$router = new Router();

require_once BASE_PATH . '/routes/web.php';

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);