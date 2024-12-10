<?php 

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\EventController;
use App\Core\Router;

use App\Controllers\HomeController;


$router = new Router();

$router->get('/', HomeController::class, 'index');

$router->get('/bet', HomeController::class,'bet');
$router->post('/bet', EventController::class,'makeBet');

$router->get('/api/events', EventController::class, 'getEvents');

$router->get('/login', HomeController::class, 'login');
$router->get('/register', HomeController::class, 'register');
$router->post('/login', AuthController::class,'login');
$router->post('/register', AuthController::class,'register');

$router->get('/logout', AuthController::class,'logout');

$router->get('/admin/users', AdminController::class, 'usersPanel');

$router->dispatch();