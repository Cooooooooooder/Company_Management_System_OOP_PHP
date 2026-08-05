<?php

require_once BASE_PATH . '/app/Controllers/Controller.php';
require_once BASE_PATH . '/app/Controllers/HomeController.php';

use App\Controllers\HomeController;

$home = new HomeController();

$router->get('/', [$home, 'index']);
$router->get('/about', [$home, 'about']);
$router->get('/contact', [$home, 'contact']);