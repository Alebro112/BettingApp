<?php

namespace App\Controllers;

use App\Core\Controller;

use App\Models\Currency;
use App\Models\User;
use App\Models\Bet;
use App\Models\Event;

class UserController extends Controller
{
    public function getBalances() {
        $userId = $_SESSION['userId'];
    }

}
