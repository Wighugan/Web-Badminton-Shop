<?php
   class database {
    private $conn = null;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $database = 'mydb';
    private $stmt = null;
    private $result = null;
    public function __construct()
    {
    $this->connect();
    }
    private function connect(){
        $this->conn = new mysqli($this->host,$this->user,$this->pass,$this->database)
        or die('Kết nối database thất bại');
        $this-> conn ->query('SET NAMES UTF8');
    }
    public function select($sql){
        $this->connect();
        $this->result = $this->conn->query($sql);
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
    public function command($sql){
        $this->connect();
        $this->conn->query($sql);
    } 
    public function execute(){
        if($this->stmt){
            return $this->stmt->execute();
        }
        else return false;
    }

    public function select_prepare($sql, $types = '', ...$params) {
        $this->stmt = $this->conn->prepare($sql);
        if (!$this->stmt) {
            die('Lỗi prepare: ' . $this->conn->error);
        }
        // Chỉ bind_param nếu có tham số
        if (!empty($types) && !empty($params)) {
            $this->stmt->bind_param($types, ...$params);
        }
        if ($this->stmt->execute()) {
            $this->result = $this->stmt->get_result();
            return $this;
        }
        return false;
    }
    public function command_prepare($sql, $types = '', ...$params) {
        $this->stmt = $this->conn->prepare($sql);  
        if (!$this->stmt) {
            die('Lỗi prepare: ' . $this->conn->error);
        }    
        // Chỉ bind_param nếu có tham số
        if (!empty($types) && !empty($params)) {
            $this->stmt->bind_param($types, ...$params);
        }
        return $this->stmt->execute();
    }
    public function close() {
        if ($this->stmt) $this->stmt->close();
        if ($this->conn) $this->conn->close();
    }
   }
?>