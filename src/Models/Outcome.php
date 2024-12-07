<?php

namespace App\Models;

use App\Core\Model;

class Outcome extends Model {
    public function __construct() {
        parent::__construct('outcomes');
    }
    
    public function getNames() {
        $this->DB()->query('SELECT DISTINCT name, label FROM outcometypes ORDER BY id');
        return $this->DB()->fetchAll();
    }
}