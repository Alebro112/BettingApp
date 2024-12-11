<?php

namespace App\Models;

use App\Core\Model;

class Currency extends Model {
    public function __construct() {
        parent::__construct('currencies');
    }

    public function getCurrencys() { 
        $this->DB()->query("SELECT DISTINCT c.code FROM currencies c");
        return $this->DB()->fetchAll();
    }
}