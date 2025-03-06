<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct(){
        $this->host     = DB_HOST;
        $this->db_name  = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
    }
    
    public function connect() {
        $this->conn = null;
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Connection Error: " . $e->getMessage());
            die("数据库连接失败。");
        }
        return $this->conn;
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // 优化后的查询方法，支持参数绑定
    public function select($table, $conditions = [], $params = []) {
        $sql = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $conditions, $params = []) {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ", ");
        $sql = "UPDATE $table SET $set WHERE " . implode(" AND ", $conditions);
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        return $stmt->execute();
    }
 public function query($sql, $params = []) {
    $stmt = $this->conn->prepare($sql);
    foreach ($params as $key => $value) {
        $paramType = PDO::PARAM_STR;
        if (is_int($value)) {
            $paramType = PDO::PARAM_INT;
        }
        $stmt->bindValue($key, $value, $paramType);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function delete($table, $conditions, $params = []) {
        $sql = "DELETE FROM $table WHERE " . implode(" AND ", $conditions);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
}
?>
