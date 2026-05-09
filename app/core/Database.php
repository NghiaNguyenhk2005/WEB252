<?php

/**
 * Lớp xử lý kết nối cơ sở dữ liệu MySQL
 */
class Database
{
    private $host;
    private $username;
    private $password;
    private $database;
    public $conn;

    public function __construct()
    {
        // Nạp tham số kết nối từ file cấu hình
        $config = require_once __DIR__ . '/../../config/database.php';
        $this->host = $config['db']['host'];
        $this->username = $config['db']['username'];
        $this->password = $config['db']['password'];
        $this->database = $config['db']['database'];

        // Khởi tạo đối tượng mysqli
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        // Kiểm tra lỗi kết nối
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        // Thiết lập bảng mã UTF-8
        $this->conn->set_charset("utf8");
    }

    /**
     * Trả về đối tượng kết nối hiện tại
     */
    public function getConnection()
    {
        return $this->conn;
    }
}