<?php

namespace App\DTO;

use App\Core\DTO;

class BetDTO extends DTO
{
    public int $id;
    public int $userId;
    public int $eventId;
    public string $outcome;
    public string $currency = 'EUR';
    public float $amount = 0;
    public float $rate = 1;
    public string $status = 'Pending'; 

    
    public function setRate(float $rate): void {
        $this->rate = $rate;
    }

}