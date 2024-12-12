<?php

namespace App\Controllers;

use App\Core\ApiError;
use App\Core\Controller;

use App\Core\Validator;
use App\DTO\BetDTO;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Outcome;
use App\Models\User;
use App\Models\Bet;
use App\Models\Event;

class EventController extends Controller
{
    public function getEvents()
    {
        $Event = new Event();

        $events = $Event->getEventsWithRates();

        $this->responseJson(200, $events);
    }

    public function makeBet()
    {
        if ($this->isAuthenticated() == false) {
            ApiError::unauthorized("/login");
        }

        $redirectUrl = "/bet?eventId=" . $_GET['eventId'] . "&outcome=" . $_GET['outcome'];

        $User = new User();
        $user = $User->getById($_SESSION['userId']);

        if ($user->status == 'Banned') {
            ApiError::badRequest($redirectUrl, "Пользователь заблокирован");
            return;
        }

        if (Validator::validateIsFloat($_POST['amount']) == false) {
            ApiError::badRequest($redirectUrl, "Сумма ставки должна быть числом");
            return;
        }

        $betDTO = BetDTO::create([...$_POST, ...$_GET, "userId" => $_SESSION["userId"]]);


        if ($betDTO->amount < 0 || $betDTO->amount > 500) {
            ApiError::badRequest($redirectUrl, "Сумма ставки не может быть больше 500 {$betDTO->currency} и не может быть меньше 0");
            return;
        }

        $Balance = new Balance();
        $balance = $Balance->getUserBalance($betDTO->userId, $betDTO->currency);

        if (empty($balance) || ($balance->amount - $betDTO->amount) < 0) {
            ApiError::badRequest($redirectUrl, "На счету недостаточно средств");
            return;
        }

        $Event = new Event();
        $event = $Event->getOneEventWithRates($betDTO->eventId);


        if (isset($event->outcomes[$betDTO->outcome]) == false) {
            ApiError::badRequest($redirectUrl, "Выбранный исход не существует");
            return;
        }

        $betDTO->setRate($event->outcomes[$betDTO->outcome]['rate']);

        $Bet = new Bet();

        $result = $Bet->createAndWithdraw($betDTO);

        if ($result == false) {
            ApiError::badRequest($redirectUrl, 'Произошла ошибка');
            return;
        }

        $this->redirect($redirectUrl, "GET", "Ставка успешно сделана");
    }

    public function successBet()
    {
        if ($this->isAuthenticated() == false) {
            ApiError::unauthorized("/login");
        }

        if (isset($_GET["betId"]) == false) {
            ApiError::badRequest("/admin/events");
        }

        $Bet = new Bet();
        $bet = $Bet->getOneById($_GET["betId"]);

        if ($bet == null) {
            ApiError::badRequest("/admin/events");
        }

        $redirectUrl = "/admin/event/show?eventId=" . $bet->eventId;
        $result = $Bet->success($bet);

        if ($result == false) {
            ApiError::badRequest($redirectUrl,"Произошла ошибка");
        }

        $this->redirect($redirectUrl, "GET", "Ставка успешно завершена");
    }

    public function failureBet()
    {
        if ($this->isAuthenticated() == false) {
            ApiError::unauthorized("/login");
        }

        if (isset($_GET["betId"]) == false) {
            ApiError::badRequest("/admin/events");
        }

        $Bet = new Bet();
        $bet = $Bet->getOneById($_GET["betId"]);

        if ($bet == null) {
            ApiError::badRequest("/admin/events");
        }

        $redirectUrl = "/admin/event/show?eventId=" . $bet->eventId;
        $result = $Bet->fail($bet);

        if ($result == false) {
            ApiError::badRequest($redirectUrl, "Произошла ошибка");
        }

        $this->redirect($redirectUrl, "GET", "Ставка завершена поражением");
    }

    public function refundBet()
    {
        if ($this->isAuthenticated() == false) {
            ApiError::unauthorized("/login");
        }

        if (isset($_GET["betId"]) == false) {
            ApiError::badRequest("/admin/events");
        }

        $Bet = new Bet();
        $bet = $Bet->getOneById($_GET["betId"]);

        if ($bet == null) {
            ApiError::badRequest("/admin/events");
        }

        $redirectUrl = "/admin/event/show?eventId=" . $bet->eventId;
        $result = $Bet->refund($bet);

        if ($result == false) {
            ApiError::badRequest($redirectUrl, "Произошла ошибка");
        }

        $this->redirect($redirectUrl, "GET", "Ставка возвращена");
    }

    public function calculateEvent()
    {
        if ($this->isAuthenticated() == false) {
            ApiError::unauthorized("/login");
        }

        if (isset($_GET["eventId"]) == false || $_GET["outcome"] == false) {
            ApiError::badRequest("/admin/events");
        }

        $Event = new Event();
        $event = $Event->getOneEventWithRates($_GET["eventId"]);

        if ($event == null) {
            ApiError::badRequest("/admin/events");
        }

        $Outcome = new Outcome();
        $outcome = $Outcome->getNames();

        if (Validator::validateIsStringInArray(array_map(fn($value): string => $value["name"], $outcome), $_GET["outcome"]) == false) {
            ApiError::badRequest("/admin/events");
        }

        $Bet = new Bet();
        $successBets = $Bet->failManyAndReturnSuccess($event->id, $_GET["outcome"]);

        
        foreach ($successBets as $value) {
            $Bet->success($value);
        }

        $this->redirect("/admin/event/show?eventId=" . $event->id, "GET", "Ставки успешно расчитаны");
    }
}
