<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    public $conn;

    public function __construct() {
        // Use config file if it exists, otherwise fall back to defaults
        $configFile = __DIR__ . '/../../config/database.php';
        if (file_exists($configFile)) {
            $config          = require $configFile;
            $this->host      = $config['db']['host']     ?? 'localhost';
            $this->username  = $config['db']['username']  ?? 'root';
            $this->password  = $config['db']['password']  ?? '';
            $this->database  = $config['db']['database']  ?? 'TaSS';
        } else {
            $this->host      = 'localhost';
            $this->username  = 'root';
            $this->password  = '';
            $this->database  = 'TaSS';
        }

        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    public function getConnection() {
        return $this->conn;
    }
}
