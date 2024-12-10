<?php

namespace App\Controllers;

use App\Core\Controller;

use App\Models\Balance;
use App\Models\Event;


class HomeController extends Controller {
    public function index() {

        $balances = [];

        if ($this->isAuthenticated()) {
            $userId = $_SESSION['userId'];

            $Balance = new Balance();
            $balances = $Balance->getUserBalances($userId);

        }

        $Event = new Event();
        $events = $Event->getEventsWithRates();

        $this->renderLayout('mainLayout', 'home/index', [
            'events' => $events,
            'balances' => $balances
        ]);
    }

    public function bet() {
        $balances = [];

        if ($this->isAuthenticated()) {
            $userId = $_SESSION['userId'];

            $Balance = new Balance();
            $balances = $Balance->getUserBalances($userId);
        } else {
            $this->redirect('/login');
        }

        $eventId = $_GET['eventId'];
        $outcome = $_GET['outcome'];

        $Event = new Event();
        $event = $Event->getOneEventWithRates($eventId);

        if (!$event) {
            $this->redirect('/');
        }

        $this->renderLayout('mainLayout', 'home/bet', [
            'balances' => $balances,
            'event' => $event,
            'chosedOutcome' => $outcome
        ]);
    }
    public function login() {
        if ($this->isAuthenticated()) $this->redirect('/');
        $this->renderLayout('mainLayout', 'auth/login');
    }

    public function register() { 
        if ($this->isAuthenticated()) $this->redirect('/');
        $this->renderLayout('mainLayout', 'auth/register');
    }
}
