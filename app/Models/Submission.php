<?php

namespace App\Models;
use Core\Database;

class Submission extends Database {
    public function addSubmission($data) {
        $this->query("INSERT INTO submissions (amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, hash_key, entry_at, entry_by)
                      VALUES (:amount, :buyer, :receipt_id, :items, :buyer_email, :buyer_ip, :note, :city, :phone, :hash_key, :entry_at, :entry_by)");
        
        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }
        
        return $this->execute();
    }
    
    public function getSubmissions($startDate, $endDate, $userId) {
        $this->query("SELECT * FROM submissions WHERE entry_at BETWEEN :start AND :end AND (entry_by = :userId OR :userId IS NULL)");
        $this->bind(":start", $startDate);
        $this->bind(":end", $endDate);
        $this->bind(":userId", $userId);
        return $this->resultSet();
    }
}
?>
