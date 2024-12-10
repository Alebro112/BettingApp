<?php

namespace App\Models;

use App\Core\Model;
use App\DTO\BalanceDTO;

class Balance extends Model {
    public function __construct() {
        parent::__construct('balances');
    }

    public function getUserBalance(int $userId, string $currency) {
        $this->DB()->query("SELECT b.* FROM balances b WHERE b.userId = ? AND b.currency = ?", [$userId, $currency]);
        return BalanceDTO::create($this->DB()->fetchOne());
    }

    public function getUserBalances(int $userId) { 
        $this->DB()->query("SELECT b.*, c.tag FROM balances b LEFT JOIN currencies c ON c.code = b.currency WHERE b.userId = ?", [$userId]);
        return BalanceDTO::createArray($this->DB()->fetchAll());
    }

    public function create(BalanceDTO $balance) {
        $this->DB()->query("INSERT INTO balances (userId, currency) VALUES (?, ?)", [$balance->userId, $balance->currency]);
        return $this->DB()->insert();
    }

    public function withdraw(BalanceDTO $balance, float $amount): bool {
        $this->DB()->query("UPDATE balances b SET amount = amount - ? WHERE b.userId = ? AND b.currency = ?", [
            $amount,
            $balance->userId,
            $balance->currency
        ]);
        return $this->DB()->execute()[0];
    }
}