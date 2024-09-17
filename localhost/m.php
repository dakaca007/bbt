<?php
// 引入 Database 类
require_once 'Database.php';

// 实例化 Database 类
$db = new Database();

// 连接到数据库
$conn = $db->connect();
// 表名
$tableName = 'users';

// 删除表
$dropSql = "DROP TABLE IF EXISTS $tableName";
$conn->exec($dropSql);
echo "原有表 $tableName 已删除。\n";

// 创建新表
$createSql = "
CREATE TABLE $tableName (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$conn->exec($createSql);
echo "新表 $tableName 已创建。\n";
// 插入数据示例
$userData = [
    'username' => 'john_doe',
    'email' => 'john@example.com',
    'password' => 'secret123'
];

$insertId = $db->insert('users', $userData);
if ($insertId) {
    echo "新用户插入成功，用户 ID: " . $insertId;
} else {
    echo "插入用户失败";
}

// 查询数据示例
$users = $db->select('users');
print_r($users);

// 更新数据示例
$updateData = [
    'email' => 'john.doe@example.com'
];
$updateConditions = ['id = ' . $insertId]; // 假设有一个 id 字段
if ($db->update('users', $updateData, $updateConditions)) {
    echo "用户信息更新成功";
} else {
    echo "更新失败";
}

// 删除数据示例
$deleteConditions = ['id = ' . $insertId]; // 假设有一个 id 字段
if ($db->delete('users', $deleteConditions)) {
    echo "用户删除成功";
} else {
    echo "删除失败";
}

?>
