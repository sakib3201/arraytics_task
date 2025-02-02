<?php

namespace Core;

use PDO;
use PDOException;
use Config\Config;

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        try {
            $dsn = "mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME . ";charset=utf8mb4";
            $this->db = new PDO($dsn, Config::DB_USER, Config::DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt;
    }

    public function findAll() {
        return $this->query("SELECT * FROM {$this->table}")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        return $this->query("SELECT * FROM {$this->table} WHERE id = :id", [":id" => $id])->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $keys = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $this->query("INSERT INTO {$this->table} ($keys) VALUES ($values)", $data);
        return $this->db->lastInsertId();
    }
}
