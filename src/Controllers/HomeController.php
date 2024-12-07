<?php

namespace App\Controllers;

use App\Core\Controller;

use App\Models\Currency;
use App\Models\Event;
use App\Models\User;
use App\Models\Bet;

class HomeController extends Controller {
    public function index() {
        $Currency = new Currency();
        $currencies = $Currency->getAll();

        $User = new User();
        $user = $User->getById(1);

        $Event = new Event();
        $events = $Event->getAll();


        $this->renderLayout('mainLayout', 'home/index', [
            'currencies' => $currencies, 
            'user' => $user,
            'events' => $events
        ]);
    }

    public function admin() {
        $this->renderLayout('mainLayout', 'admin/index');
    }

    public function login() {
        $this->renderLayout('mainLayout', 'auth/login');
    }

    public function register() { 
        $this->renderLayout('mainLayout', 'auth/register');
    }
}
