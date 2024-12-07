<?php

namespace App\Models;

use App\Core\Model;

class Journal extends Model {
    public function __construct() {
        parent::__construct('journals');
    }
}