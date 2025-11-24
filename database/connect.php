<?php
class Database {
    private $conn = null;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $database = 'mydb1';
    private $stmt = null;
    private $result = null;

    public function __construct() {
        $this->connect();
    }

    /** 🔗 Kết nối CSDL */
    private function connect() {
        if ($this->conn === null) {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->database);

            if ($this->conn->connect_error) {
                die("❌ Kết nối database thất bại: " . $this->conn->connect_error);
            }

            $this->conn->set_charset("utf8mb4");
        }
    }

    public function select($sql) {
        $this->result = $this->conn->query($sql);
        if (!$this->result) {
            echo "Lỗi truy vấn: " . $this->conn->error;
        }
        return $this;
    }

    public function fetch() {
        if ($this->result && $this->result->num_rows > 0) {
            return $this->result->fetch_assoc();
        }
        return null;
    }

    public function fetchAll() {
        if ($this->result && $this->result->num_rows > 0) {
            return $this->result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function numRows() {
        return $this->result ? $this->result->num_rows : 0;
    }
    public function command($sql) {
        $success = $this->conn->query($sql);
        if (!$success) {
            echo "Lỗi truy vấn: " . $this->conn->error;
        }
        return $success;
    }
    public function select_prepare($sql, $types = '', ...$params) {
        $this->stmt = $this->conn->prepare($sql);
        if (!$this->stmt) {
            die('Lỗi prepare: ' . $this->conn->error);
        }

        if (!empty($types) && !empty($params)) {
            $this->stmt->bind_param($types, ...$params);
        }

        if ($this->stmt->execute()) {
            $this->result = $this->stmt->get_result();
            return $this;
        } else {
            echo "Lỗi execute: " . $this->stmt->error;
        }
        return false;
    }

    /** ⚙️ Câu lệnh INSERT/UPDATE/DELETE có prepare */
    public function command_prepare($sql, $types = '', ...$params) {
        $this->stmt = $this->conn->prepare($sql);
        if (!$this->stmt) {
            die('Lỗi prepare: ' . $this->conn->error);
        }

        if (!empty($types) && !empty($params)) {
            $this->stmt->bind_param($types, ...$params);
        }

        return $this;
    }

    /** ✅ Thực thi prepared statement */
    public function execute() {
        if ($this->stmt) {
            $result = $this->stmt->execute();
            if (!$result) {
                echo "Lỗi execute: " . $this->stmt->error;
            }
            return $result;
        }
        return false;
    }

    /** ❎ Đóng kết nối */
    public function close() {
        if ($this->stmt) {
            $this->stmt->close();
            $this->stmt = null;
        }
        if ($this->conn) {
            $this->conn->close();
            $this->conn = null;
        }
    }
}
?>
