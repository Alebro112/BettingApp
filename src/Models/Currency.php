<?php

namespace App\Models;

use App\Core\Model;

class Currency extends Model {
    public function __construct() {
        parent::__construct('currencies');
    }

    
}