<?php

namespace App\Controllers;

use App\Core\Controller;

use App\Models\Currency;
use App\Models\User;
use App\Models\Bet;
use App\Models\Event;

class AdminController extends Controller
{
    public function usersPanel() {

        $this->renderLayout("mainLayout", "admin/usersPanel");
    }

}
