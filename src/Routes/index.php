<?php 

use App\Controllers\AuthController;
use App\Controllers\EventController;
use App\Core\Router;

use App\Controllers\HomeController;


$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/admin', HomeController::class, 'admin');



$router->get('/api/events', EventController::class, 'getEvents');


$router->get('/login', HomeController::class, 'login');
$router->get('/register', HomeController::class, 'register');

$router->post('/api/login', AuthController::class,'login');
$router->post('/api/register', AuthController::class,'register');

$router->dispatch();