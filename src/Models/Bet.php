<?php

namespace App\Models;

use App\Core\Model;

class Bet extends Model {
    public function __construct() {
        parent::__construct('bets');
    }

    public function getByEventId($eventId) {
        $this->DB()->query(
            'select * from bets b where b.outcomeId IN (select o.id from outcomes as o WHERE o.eventId = ?)',
            [$eventId]
        );
        return $this->DB()->fetchAll();
    }
}