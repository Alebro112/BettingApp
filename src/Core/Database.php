<?php

namespace App\Core;

use mysqli;

//https://stackoverflow.com/questions/17226762/how-can-i-bind-an-array-of-strings-with-a-mysqli-prepared-statement

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $name = DB_NAME;

    private $mysqli;
    private $sql = '';
    private $values = null;

    public function __construct() {
        $this->db_connect();
    }

    private function db_connect() {
        $mysqli = new mysqli($this->host, $this->user, $this->pass, $this->name);

        $this->mysqli = $mysqli;
    }

    public function query($sql, $values = null) {
        $this->sql = $sql;
        $this->values = $values;
    }

    public function clear() {
        $this->sql = '';
        $this->values = null;
    } 

    public function execute() {
        try {
            $result = $this->mysqli->execute_query($this->sql, $this->values);
            $id = $this->mysqli->insert_id;
            $this->clear();
            return [$result, $id];
        } catch (\Throwable $th) {
            $this->clear();
            die($th->getMessage());
        }
    }

    public function fetchAll() {
        return $this->execute()[0]->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchOne() {
        return $this->execute()[0]->fetch_assoc();
    }

    public function insert(): int {
        return $this->execute()[1];
    }

    public function beginTransaction() {
        return $this->mysqli->begin_transaction();
    }

    public function commit() {
        return $this->mysqli->commit();
    }

    public function rollback() {
        return $this->mysqli->rollback();
    }
}