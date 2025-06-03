<?php
class Database {
    private $host = 'mysql';
    private $db_name = 'task_manager';
    private $username = 'root';
    private $password = 'root';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "接続エラー: " . $e->getMessage();
        }

        return $this->conn;
    }
} 