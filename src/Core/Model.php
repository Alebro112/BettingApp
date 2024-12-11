<?php

namespace App\Core;

abstract class Model {

    static $db = null;
    protected $table;
    protected $dto;

    public function __construct(string $table) {
        if (static::$db === null) {
            static::$db = new Database();
            //static::$db->query('insert into journals (name, publishedYear) values (\'Journal 5\', \'2024\');');
        }

        $this->table = $table;
    }
    protected function DB() {
        return static::$db;
    }
}