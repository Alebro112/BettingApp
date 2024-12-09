<?php

namespace App\Models;

use App\Core\Model;
use App\DTO\BalanceDTO;

class Balance extends Model {
    public function __construct() {
        parent::__construct('balances');
    }

    public function getUserBalances(int $userId) { 
        $this->DB()->query("SELECT b.*, c.tag FROM balances b LEFT JOIN currencies c ON c.code = b.currency WHERE b.userId = ?", [$userId]);
        return BalanceDTO::createArray($this->DB()->fetchAll());
    }

    public function create(BalanceDTO $balanceDTO) {
        $this->DB()->query("INSERT INTO balances (userId, currency) VALUES (?, ?)", [$balanceDTO->userId, $balanceDTO->currency]);
        return $this->DB()->insert();
    }
}