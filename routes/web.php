<?php


use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\DepartmentController;
use App\Controllers\EmployeeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ProjectController;
use App\Controllers\TaskController;

$home = new HomeController();
$user = new UserController();
$department = new DepartmentController();
$employee = new EmployeeController();
$auth = new AuthController();
$dashboard = new DashboardController();
$project = new ProjectController();
$task = new TaskController();

$router->get('/', [$home, 'index']);
$router->get('/about', [$home, 'about']);
$router->get('/contact', [$home, 'contact']);
$router->get('/users', [$user, 'index']);
$router->get('/users/create', [$user, 'create']);
$router->post('/users/store', [$user, 'store']);
$router->get('/users/show', [$user, 'show']);
$router->get('/users/edit', [$user, 'edit']);
$router->post('/users/update', [$user, 'update']);
$router->post('/users/delete', [$user, 'delete']);

$router->get('/departments', [$department, 'index']);
$router->get('/departments/show', [$department, 'show']);
$router->get('/departments/create', [$department, 'create']);
$router->post('/departments/store', [$department, 'store']);
$router->get('/departments/edit', [$department, 'edit']);
$router->post('/departments/update', [$department, 'update']);
$router->post('/departments/delete', [$department, 'delete']);

$router->get('/employees', [$employee, 'index']);
$router->get('/employees/create', [$employee, 'create']);
$router->post('/employees/store', [$employee, 'store']);
$router->get('/employees/show', [$employee, 'show']);
$router->get('/employees/edit', [$employee, 'edit']);
$router->post('/employees/update', [$employee, 'update']);
$router->post('/employees/delete', [$employee, 'delete']);


$router->get('/login', [$auth, 'login']);
$router->post('/login', [$auth, 'authenticate']);
$router->post('/logout', [$auth, 'logout']);


$router->get('/dashboard', [$dashboard, 'index']);

$router->get('/projects', [$project, 'index']);
$router->get('/projects/show', [$project, 'show']);
$router->get('/projects/create', [$project, 'create']);
$router->post('/projects/store', [$project, 'store']);
$router->get('/projects/edit', [$project, 'edit']);
$router->post('/projects/update', [$project, 'update']);
$router->post('/projects/delete', [$project, 'delete']);


$router->get('/tasks', [$task, 'index']);
$router->get('/tasks/show', [$task, 'show']);
$router->get('/tasks/create', [$task, 'create']);
$router->post('/tasks/store', [$task, 'store']);
$router->get('/tasks/edit', [$task, 'edit']);
$router->post('/tasks/update', [$task, 'update']);
$router->post('/tasks/delete', [$task, 'delete']);

