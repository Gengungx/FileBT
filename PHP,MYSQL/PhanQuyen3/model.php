<?php
class Model {
    
    private $conn;

    public function __construct() {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'register';
        $this->conn = new mysqli($host, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function select($table, $columns = "*", $condition = "", $params = []) {
        $sql = "SELECT $columns FROM $table";
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }
    
        $stmt = $this->conn->prepare($sql);
        
        if ($params) {
            // Tạo kiểu dữ liệu cho các tham số
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Kiểm tra nếu kết quả trả về là một đối tượng mysqli_result hợp lệ
        if ($result && $result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            // Xử lý trường hợp kết quả không hợp lệ
            return false;
        }
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
     $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->conn->query($sql);

    }

    public function update($table, $data, $condition) {
        $updates = "";
        foreach ($data as $key => $value) {
            $updates .= "$key='$value', ";
        }
        $updates = rtrim($updates, ', ');
        $sql = "UPDATE $table SET $updates WHERE $condition";
        return $this->conn->query($sql);
    }

    public function delete($table, $condition) {
        $sql = "DELETE FROM $table WHERE $condition";
        return $this->conn->query($sql);
    }

    public function __destruct() {
        $this->conn->close();
    }
}


?>