<?php

namespace App\Models;

use App\Core\Model;
use App\DTO\BalanceDTO;
use App\DTO\BetDTO;

class Bet extends Model
{

    public function __construct()
    {
        parent::__construct('bets');
    }

    public function getOneById(int $id)
    {
        $this->DB()->query("SELECT * FROM bets b WHERE b.id = ?", [$id]);
        return BetDTO::create($this->DB()->fetchOne());
    }

    public function getByEventId($eventId)
    {
        $this->DB()->query(
            "SELECT u.username, b.* FROM bets b LEFT JOIN users u ON u.id = b.userId WHERE b.eventId = ? AND b.status = 'Pending'",
            [$eventId]
        );
        return BetDTO::createArray($this->DB()->fetchAll());
    }

    public function getByUserId($userId): array {
        $this->DB()->query(
            "SELECT e.id as eventId, t1.name as teamOneName, t2.name as teamTwoName, b.* FROM bets b LEFT JOIN events e ON e.id = b.eventId LEFT JOIN teams t1 ON t1.id = e.teamOne LEFT JOIN teams t2 ON t2.id = e.teamTwo WHERE b.userId = ?",
            [$userId]
        );
        return BetDTO::createArray($this->DB()->fetchAll());
    }

    public function create(BetDTO $bet): int
    {
        $this->DB()->query("INSERT INTO bets (userId, eventId, outcome, currency, amount, rate, status) VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $bet->userId,
            $bet->eventId,
            $bet->outcome,
            $bet->currency,
            $bet->amount,
            $bet->rate,
            $bet->status
        ]);
        return $this->DB()->insert();
    }



    public function createAndWithdraw(BetDTO $bet): bool
    {
        $this->DB()->beginTransaction();
        $this->DB()->query("INSERT INTO bets (userId, eventId, outcome, currency, amount, rate, status) VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $bet->userId,
            $bet->eventId,
            $bet->outcome,
            $bet->currency,
            $bet->amount,
            $bet->rate,
            $bet->status
        ]);
        $betResult = $this->DB()->execute()[0];
        if ($betResult == false) {
            $this->DB()->rollBack();
            return false;
        }
        $Balance = new Balance();
        $balanceResult = $Balance->withdraw(BalanceDTO::create($bet->toArray()), $bet->amount);
        if ($balanceResult == false) {
            $this->DB()->rollBack();
            return false;
        }
        $balance = $Balance->getUserBalance($bet->userId, $bet->currency);
        if ($balance->amount < 0) {
            $this->DB()->rollBack();
            return false;
        }

        $this->DB()->commit();
        return true;
    }


    public function success(BetDTO $bet): bool
    {
        $this->DB()->beginTransaction();
        $this->DB()->query("UPDATE bets b SET status = 'WON' WHERE b.id = ?", [$bet->id]);
        $betResult = $this->DB()->execute()[0];
        if ($betResult == false) {
            $this->DB()->rollBack();
            return false;
        }
        $Balance = new Balance();
        $balanceResult = $Balance->deposite(BalanceDTO::create($bet->toArray()), ($bet->amount * $bet->rate));
        if ($balanceResult == false) {
            $this->DB()->rollBack();
            return false;
        }
        
        $this->DB()->commit();
        return true;
    }

    public function fail(BetDTO $bet): bool {
        $this->DB()->query("UPDATE bets b SET status = 'LOST' WHERE b.id = ?", [$bet->id]);
        return $this->DB()->execute()[0];
    }

    public function failManyAndReturnSuccess(int $eventId, string $outcome): array {
        $this->DB()->beginTransaction();
        $this->DB()->query("UPDATE bets b SET status = 'LOST' WHERE b.eventId = ? AND b.outcome <> ? AND b.status = 'Pending'", [$eventId, $outcome]);
        $unsuccessResult = $this->DB()->execute()[0];
        if ($unsuccessResult == false) {
            $this->DB()->rollBack();
            return [];
        }
        $this->DB()->commit();
        $this->DB()->query("SELECT * FROM bets b WHERE b.eventId = ? AND b.outcome = ? AND b.status = 'Pending'", [$eventId, $outcome]);
        return BetDTO::createArray($this->DB()->fetchAll());
    }

    public function refund(BetDTO $bet): bool { 
        $this->DB()->beginTransaction();

        $this->DB()->query("UPDATE bets b SET status = 'REFUNDED' WHERE b.id = ?", [$bet->id]);
        $betResult = $this->DB()->execute()[0];
        if ($betResult == false) {
            $this->DB()->rollBack();
            return false;
        }
        $Balance = new Balance();
        $balanceResult = $Balance->deposite(BalanceDTO::create($bet->toArray()), $bet->amount);
        if ($balanceResult == false) {
            $this->DB()->rollBack();
            return false;
        }

        $this->DB()->commit();
        return true;
    }
}