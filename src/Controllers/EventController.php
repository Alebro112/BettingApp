<?php

namespace App\Controllers;

use App\Core\Controller;

use App\Models\Currency;
use App\Models\User;
use App\Models\Bet;
use App\Models\Event;

class EventController extends Controller
{
    public function getEvents()
    {
        $Event = new Event();

        $events = $Event->getAll();

        $this->responseJson(200, $events);
    }

}
