<?php
class Database {
    private $host = 'mysql.sqlpub.com';
    private $db_name = 'dakaca';
    private $username = 'dakaca007';
    private $password = 'Kgds63EecpSlAtYR';
    private $conn;

    // 数据库连接
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }

    // 插入数据
    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        return $stmt->execute();
    }

    // 查询数据
    public function select($table, $conditions = []) {
        $sql = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 更新数据
    public function update($table, $data, $conditions) {
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

        return $stmt->execute();
    }

    // 删除数据
    public function delete($table, $conditions) {
        $sql = "DELETE FROM $table WHERE " . implode(" AND ", $conditions);
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
}
