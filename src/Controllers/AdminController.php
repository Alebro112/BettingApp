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
            ApiError::unauthorized("/login");
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
            ApiError::unauthorized("/login");
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
            ApiError::unauthorized("/login");
        }

        $User = new User();

        if (isset($_GET["userId"]) == false) {
            ApiError::badRequest("/admin/users");
        }

        $user = $User->getById($_GET["userId"]);

        if ($user == null) {
            ApiError::badRequest("/admin/users");
        }

        $Balance = new Balance();
        $balances = $Balance->getUserBalancesAndCurrencies($user->id);

        $this->renderLayout("adminLayout", "admin/userEdit", [
            "user" => $user,
            "userBalances" => $balances
        ]);
    }

    public function userShow()
    {
        if ($this->isAuthenticated() == false) {
            ApiError::unauthorized("/login");
        }

        $User = new User();

        if (isset($_GET["userId"]) == false) {
            ApiError::badRequest("/admin/users");
        }

        $user = $User->getById($_GET["userId"]);

        if ($user == null) {
            ApiError::badRequest("/admin/users");
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
            ApiError::unauthorized("/login");
        }

        if (isset($_GET["eventId"]) == false) {
            ApiError::badRequest("/admin/events");
        }

        $Event = new Event();
        $event = $Event->getOneEventWithRates($_GET["eventId"]);

        if ($event == null) {
            ApiError::badRequest("/admin/events");
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
            ApiError::unauthorized("/login");
        }

        $User = new User();

        if (isset($_GET["userId"]) == false) {
            ApiError::badRequest("/admin/users");
        }

        $user = $User->getById($_GET["userId"]);

        if ($user == null) {
            ApiError::badRequest("/admin/users");
        }

        $redirectUrl = "/admin/user/edit?userId=" . $_GET["userId"];
        $errors = Validator::validateRequiredFields(['gender', 'birthday', 'name', 'status'], $_POST);
        if ($errors != []) {
            ApiError::badRequest($redirectUrl, $errors[0]);
            return;
        }

        if (Validator::validateIsStringInArray(['Male', 'Female'], $_POST['gender']) == false) {
            ApiError::badRequest($redirectUrl, 'Выберите пол между Male и Female');
            return;
        }

        if (Validator::validateDate($_POST['birthday']) == false) {
            ApiError::badRequest($redirectUrl, 'Дата рождения должна быть в формате YYYY-MM-DD');
            return;
        }

        if (Validator::validateAge($_POST['birthday'], 21) == false) {
            ApiError::badRequest($redirectUrl, 'Вам должно быть не менее 21 лет');
            return;
        }

        if (Validator::validateIsStringInArray(['Active', 'Banned'], $_POST['status']) == false) {
            ApiError::badRequest($redirectUrl, 'Выберите статус между Active и Banned');
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
            ApiError::unauthorized("/login");
        }

        $User = new User();

        if (isset($_GET["userId"]) == false) {
            ApiError::badRequest("/admin/users");
        }

        $user = $User->getById($_GET["userId"]);

        if ($user == null) {
            ApiError::badRequest("/admin/users");
        }

        $redirectUrl = "/admin/user/edit?userId=" . $_GET["userId"];


        $balances = [];
        foreach ($_POST as $key => $value) {
            if (preg_match("/balance-(\w+)/", $key, $matches)) {
                if (isset($matches[1])) {
                    if (Validator::validateIsNumeric(trim($value))) {
                        ApiError::badRequest($redirectUrl, "Сумма должна быть числом");
                    }

                    $balances[] = BalanceDTO::create(
                        [
                            "userId" => $_GET["userId"],
                            "currency" => $matches[1],
                            "amount" => trim($value)
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
