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

    public function getByEventId($eventId)
    {
        $this->DB()->query(
            'select * from bets b where b.outcomeId IN (select o.id from outcomes as o WHERE o.eventId = ?)',
            [$eventId]
        );
        return $this->DB()->fetchAll();
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
}