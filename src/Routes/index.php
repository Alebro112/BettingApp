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
$router->get('/admin/user/show', AdminController::class, 'userShow');
$router->get('/admin/user/edit', AdminController::class, 'userInfo');
$router->post('/admin/user/edit', AdminController::class, 'userInfoUpdate');
$router->post('/admin/user/balance', AdminController::class, 'userBalanceUpdate');

$router->get('/admin/events', AdminController::class, 'eventsPanel');
$router->get('/admin/event/show', AdminController::class, 'eventShow');

$router->post("/admin/bet/success", EventController::class,"successBet");
$router->post("/admin/bet/failure", EventController::class,"failureBet");
$router->post("/admin/bet/refund", EventController::class,"refundBet");

$router->post("/admin/event/calculate", EventController::class,"calculateEvent");

$router->dispatch();