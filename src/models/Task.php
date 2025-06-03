<?php
require_once '/var/www/html/config/database.php';

class Task {
    private $conn;
    private $table_name = "tasks";

    public $id;
    public $title;
    public $description;
    public $status;
    public $priority;
    public $due_date;
    public $user_id;
    public $category_id;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (title, description, status, priority, due_date, user_id, category_id)
                VALUES
                (:title, :description, :status, :priority, :due_date, :user_id, :category_id)";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->priority = htmlspecialchars(strip_tags($this->priority));
        
        // 空の日付はNULLとして扱う
        $due_date = !empty($this->due_date) ? $this->due_date : null;

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":priority", $this->priority);
        $stmt->bindParam(":due_date", $due_date);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_NULL);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read($user_id) {
        $query = "SELECT t.*, c.name as category_name 
                FROM " . $this->table_name . " t
                LEFT JOIN categories c ON t.category_id = c.id
                WHERE t.user_id = :user_id
                ORDER BY t.due_date ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    title = :title,
                    description = :description,
                    status = :status,
                    priority = :priority,
                    due_date = :due_date,
                    category_id = :category_id
                WHERE
                    id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->priority = htmlspecialchars(strip_tags($this->priority));
        
        // 空の日付はNULLとして扱う
        $due_date = !empty($this->due_date) ? $this->due_date : null;

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":priority", $this->priority);
        $stmt->bindParam(":due_date", $due_date);
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_NULL);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " 
                WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
} 