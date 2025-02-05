<?php

namespace App\Models;
use Core\Database;

class Submission extends Database {
    public function addSubmission($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $this->query("INSERT INTO submissions ($columns) VALUES ($placeholders)");
        
        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }
        
        return $this->execute();
    }
    
    public function filterSubmissions($startDate = null, $endDate = null, $userId = null) {
        $query = "SELECT * FROM submissions ";
        $conditions = [];
        $params = [];
        
        if ($startDate && $endDate) {
            $conditions[] = "entry_at BETWEEN :start AND :end";
            $params[':start'] = $startDate;
            $params[':end'] = $endDate;
        }
        
        if ($userId) {
            $conditions[] = "entry_by = :userId";
            $params[':userId'] = $userId;
        }
        
        if (count($conditions)) {
            $query .= "WHERE " . implode(" AND ", $conditions);
        }
        
        $this->query($query);
        foreach ($params as $key => $value) {
            $this->bind($key, $value);
        }

        return $this->resultSet();
    }
}
?>
