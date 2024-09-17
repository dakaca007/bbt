<?php
// 实例化 Database 类
$db = new Database();
$db->connect();

// 定义表结构
$table = "users";
$columns = [
    "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
    "username VARCHAR(30) NOT NULL",
    "email VARCHAR(50)",
    "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
];

// 创建数据表
if ($db->createTable($table, $columns)) {
    echo "数据表 $table 创建成功！";
} else {
    echo "创建数据表失败。";
}
?>
