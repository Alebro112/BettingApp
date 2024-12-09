<?php

namespace App\DTO;

use App\Core\DTO;

class BalanceDTO extends DTO
{
    public int $id;
    public string $currency;
    public int $userId;
    public float $amount;
    public string $tag;

    public function display(): string {
        return "{$this->amount} {$this->tag}";
    }
}