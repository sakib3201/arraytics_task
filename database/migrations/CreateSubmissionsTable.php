<?php
use Core\Migration;
use Core\Database;

class CreateSubmissionsTable implements Migration {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Run the migrations.
     *
     * Creates the 'submissions' table with columns for id, amount, buyer, receipt_id, items, 
     * buyer_email, buyer_ip, note, city, phone, hash_key, entry_at, and entry_by.
     * The table has a primary key on 'id' with auto-increment.
     */
    public function up() {
        $this->db->query('
            CREATE TABLE IF NOT EXISTS submissions (
                id BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
                amount INT(10) NOT NULL,
                buyer VARCHAR(255) NOT NULL,
                receipt_id VARCHAR(20) NOT NULL,
                items VARCHAR(255) NOT NULL,
                buyer_email VARCHAR(50) NOT NULL,
                buyer_ip VARCHAR(20) NOT NULL,
                note TEXT NOT NULL,
                city VARCHAR(20) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                hash_key VARCHAR(255) NOT NULL,
                entry_at DATE NOT NULL,
                entry_by INT(10) NOT NULL
            );
        ')->execute();
    }

    public function down() {
        $this->db->query('DROP TABLE submissions')->execute();
    }
}


