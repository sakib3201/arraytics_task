<?php
namespace Core;
use PDO;
use PDOException;

class Database {
    private $host = getenv('DB_HOST') ?: 'localhost';
    private $user = getenv('DB_USER') ?: 'root';
    private $pass = getenv('DB_PASS') ?: '';
    private $dbname = getenv('DB_NAME') ?: 'arraytics_task';
    private $dbh;
    private $stmt;

    /**
     * Database constructor.
     *
     * Initializes a new PDO database connection using the provided
     * host, database name, user, and password. Sets the error mode
     * to exception for error handling.
     *
     * If the connection fails, it terminates the script and outputs
     * an error message.
     */
    public function __construct() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
            $this->dbh = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
        return $this;
    }

    /**
     * Bind a value to a parameter in the prepared statement.
     *
     * Automatically determines the appropriate PDO parameter type
     * if not provided.
     *
     * @param string $param Parameter name (e.g. ":name")
     * @param mixed  $value Value to bind
     * @param int    $type  PDO parameter type (optional)
     *
     * @return $this
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value): $type = PDO::PARAM_INT; break;
                case is_bool($value): $type = PDO::PARAM_BOOL; break;
                case is_null($value): $type = PDO::PARAM_NULL; break;
                default: $type = PDO::PARAM_STR; break;
            }
        }
        $this->stmt->bindValue($param, $value, $type);

        return $this;
    }

    /**
     * Execute the prepared statement.
     *
     * This method executes the currently prepared PDO statement. It assumes
     * that the statement has been successfully prepared and any necessary
     * parameters have been bound using the `bind` method.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function execute() {
        // Execute the prepared statement
        $this->stmt->execute();

        // Return the current instance for method chaining
        return $this;
    }

    /**
     * Execute the query and return the result set as an associative array.
     *
     * @return array
     */
    public function resultSet() {
        $this->execute();

        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
