<?php
class Database
{
    private $db_host;
    private $db_name;
    private $db_user;
    private $charset = 'utf8mb4';
    private $password_file_path;
    private $db_pass;
    public $conn;

    public function __construct() {
        // Initialize the database connection parameters from environment variables
        $this->db_host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'expensesdb';
        $this->db_user = getenv('DB_USER') ?: 'root';
        $this->password_file_path = getenv('PASSWORD_FILE_PATH') ?: '/path/to/password.txt';
        
        // Check if the password file exists and is readable
        if (is_readable($this->password_file_path)) {
            $this->db_pass = trim(file_get_contents($this->password_file_path));
        } else {
            throw new Exception("Password file not found or not readable");
        }
    }

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->conn = new PDO($dsn, $this->db_user, $this->db_pass, $options);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}