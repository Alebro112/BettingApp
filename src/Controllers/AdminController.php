<?php

namespace App\Controllers;

use App\Core\ApiError;
use App\Core\Controller;

use App\Core\Validator;
use App\DTO\BalanceDTO;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\User;
use App\Models\Bet;
use App\Models\Event;

class AdminController extends Controller
{
    public function usersPanel()
    {
        if ($this->isAuthenticated() == false) {
            $this->redirect("/login");
        }

        $User = new User();
        $users = $User->getAll();

        $this->renderLayout("adminLayout", "admin/usersPanel", [
            "users" => $users
        ]);
    }

    public function eventsPanel()
    {
        if ($this->isAuthenticated() == false) {
            $this->redirect("/login");
        }

        $Event = new Event();
        $events = $Event->getEventsWithRates();

        $this->renderLayout("adminLayout", "admin/eventsPanel", [
            "events" => $events
        ]);
    }

    public function userInfo()
    {
        if ($this->isAuthenticated() == false) {
            $this->redirect("/login");
        }

        $User = new User();

        if (isset($_GET["userId"]) == false) {
            $this->redirect("/admin/users");
        }

        $user = $User->getById($_GET["userId"]);

        if ($user == null) {
            $this->redirect("/admin/users");
        }

        $Balance = new Balance();
        $balances = $Balance->getUserBalancesAndCurrencies($user->id);

        $this->renderLayout("adminLayout", "admin/userEdit", [
            "user" => $user,
            "userBalances" => $balances
        ]);
    }

    public function userShow() {
        if ($this->isAuthenticated() == false) {
            $this->redirect("/login");
        }

        $User = new User();

        if (isset($_GET["userId"]) == false) {
            $this->redirect("/admin/users");
        }

        $user = $User->getById($_GET["userId"]);

        if ($user == null) {
            $this->redirect("/admin/users");
        }

        $Balance = new Balance();
        $balances = $Balance->getUserBalances($user->id);

        $Bet = new Bet();
        $bets = $Bet->getByUserId($user->id);

        $this->renderLayout("adminLayout", "admin/userShow", [
            "user" => $user,
            "userBalances" => $balances,
            "bets" => $bets
        ]);
    }

    public function eventShow()
    {
        if ($this->isAuthenticated() == false) {
            $this->redirect("/login");
        }

        if (isset($_GET["eventId"]) == false) {
            $this->redirect("/admin/events");
        }

        $Event = new Event();
        $event = $Event->getOneEventWithRates($_GET["eventId"]);

        if ($event == null) {
            $this->redirect("/admin/events");
        }

        $Bet = new Bet();
        $bets = $Bet->getByEventId($event->id);

    
        /*
        echo '<pre>';
        print_r($bets);
        echo '</pre>';
        */

        $this->renderLayout("adminLayout", "admin/eventShow", [
            "event" => $event,
            "bets" => $bets
        ]);
    }

    public function userInfoUpdate()
    {
        if ($this->isAuthenticated() == false) {
            $this->redirect("/login");
        }

        $User = new User();

        if (isset($_GET["userId"]) == false) {
            $this->redirect("/admin/users");
        }

        $user = $User->getById($_GET["userId"]);

        if ($user == null) {
            $this->redirect("/admin/users");
        }

        $redirectUrl = "/admin/user/edit?userId=" . $_GET["userId"];
        $errors = Validator::validateRequiredFields(['gender', 'birthday', 'name', 'status'], $_POST);
        if ($errors != []) {
            ApiError::badRequest($errors[0], $redirectUrl);
            return;
        }

        if (Validator::validateIsStringInArray(['Male', 'Female'], $_POST['gender']) == false) {
            ApiError::badRequest('Выберите пол между Male и Female', $redirectUrl);
            return;
        }

        if (Validator::validateDate($_POST['birthday']) == false) {
            ApiError::badRequest('Дата рождения должна быть в формате YYYY-MM-DD', $redirectUrl);
            return;
        }

        if (Validator::validateAge($_POST['birthday'], 21) == false) {
            ApiError::badRequest('Вам должно быть не менее 21 лет', $redirectUrl);
            return;
        }

        if (Validator::validateIsStringInArray(['Active', 'Banned'], $_POST['status']) == false) {
            ApiError::badRequest('Выберите статус между Active и Banned', $redirectUrl);
            return;
        }

        $user->setName(trim($_POST['name']));
        $user->setGender(trim($_POST['gender']));
        $user->setBirthday($_POST['birthday']);
        $user->setStatus(trim($_POST['status']));



        $result = $User->update($user);

        if ($result) {
            $_SESSION['message'] = "Пользователь успешно обновлен";
            $this->redirect($redirectUrl);
        }
    }

    public function userBalanceUpdate()
    {
        if ($this->isAuthenticated() == false) {
            $this->redirect("/login");
        }

        $User = new User();

        if (isset($_GET["userId"]) == false) {
            $this->redirect("/admin/users");
        }

        $user = $User->getById($_GET["userId"]);

        if ($user == null) {
            $this->redirect("/admin/users");
        }

        $redirectUrl = "/admin/user/edit?userId=" . $_GET["userId"];


        $balances = [];
        foreach ($_POST as $key => $value) {
            if (preg_match("/balance-(\w+)/", $key, $matches)) {
                if (isset($matches[1])) {
                    $balances[] = BalanceDTO::create(
                        [
                            "userId" => $_GET["userId"],
                            "currency" => $matches[1],
                            "amount" => $value
                        ]
                    );

                }
            }
        }

        $Balance = new Balance();
        foreach ($balances as $balance) {
            $Balance->updateOrCreate($balance);
        }

        $_SESSION['message'] = "Пользователь успешно обновлен";
        $this->redirect($redirectUrl);
    }

}
