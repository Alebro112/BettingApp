<?php

namespace App\Core;

abstract class Model {

    static $db = null;
    protected $table;

    public function __construct(string $table) {
        if (static::$db === null) {
            static::$db = new Database();
            //static::$db->query('insert into journals (name, publishedYear) values (\'Journal 5\', \'2024\');');
        }

        $this->table = $table;
    }

    public function getAll() {
        $this->DB()->query("select * from $this->table");
        return $this->DB()->fetchAll();
    }

    public function getById(int $id) {   
        $this->DB()->query("select * from $this->table where id = ?", [$id]);     
        return $this->DB()->fetchOne();
    }

    public function deleteById(int $id) {
        $this->DB()->query("delete from $this->table where id = ?", [$id]);
        return $this->DB()->execute();
    }

    protected function DB() {
        return static::$db;
    }
}