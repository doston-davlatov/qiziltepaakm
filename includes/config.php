<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library_db');

// Site configuration
define('SITE_NAME', 'Navoiy Akademik Kutubxona');
define('SITE_URL', 'http://localhost');
define('UPLOADS_DIR', 'uploads/');
define('BOOKS_UPLOADS_DIR', UPLOADS_DIR . 'books/');
define('EVENTS_UPLOADS_DIR', UPLOADS_DIR . 'events/');

// Security settings
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_TIMEOUT', 3600); // 1 hour

// Language settings
define('DEFAULT_LANGUAGE', 'uz');
define('AVAILABLE_LANGUAGES', ['uz', 'en', 'ru']);

// Admin settings
define('ADMIN_EMAIL', 'admin@library.uz');
define('MAX_FILE_SIZE', 2048000); // 2MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// Timezone
date_default_timezone_set('Asia/Tashkent');
class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Database connection error: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function executeQuery($sql, $params = [], $types = "") {
        $result = $this->conn->prepare($sql);
        if (!$result) {
            return "SQL error: " . $this->conn->error;
        }
        if ($params) {
            $result->bind_param($types, ...$params);
        }
        if (!$result->execute()) {
            return "Execution error: " . $result->error;
        }
        return $result;
    }

    public function select($table, $columns = "*", $condition = "", $params = [], $types = "") {
        $sql = "SELECT $columns FROM $table" . ($condition ? " WHERE $condition" : "");
        $result = $this->executeQuery($sql, $params, $types);
        if (is_string($result)) {
            return $result;
        }
        return $result->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function insert($table, $data) {
        $keys = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($keys) VALUES ($placeholders)";
        $types = str_repeat('s', count($data));
        $result = $this->executeQuery($sql, array_values($data), $types);
        if (is_string($result)) {
            return $result;
        }
        return $this->conn->insert_id;
    }

    public function update($table, $data, $condition = "", $params = [], $types = "") {
        $set = implode(", ", array_map(function ($k) {
            return "$k = ?";
        }, array_keys($data)));
        $sql = "UPDATE $table SET $set" . ($condition ? " WHERE $condition" : "");
        $types = str_repeat('s', count($data)) . $types;
        $result = $this->executeQuery($sql, array_merge(array_values($data), $params), $types);
        if (is_string($result)) {
            return $result;
        }
        return $this->conn->affected_rows;
    }

    public function delete($table, $condition = "", $params = [], $types = "") {
        $sql = "DELETE FROM $table" . ($condition ? " WHERE $condition" : "");
        $result = $this->executeQuery($sql, $params, $types);
        if (is_string($result)) {
            return $result;
        }
        return $this->conn->affected_rows;
    }

    public function getLastError() {
        return $this->conn->error;
    }
}
?>