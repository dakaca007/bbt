<?php
require_once 'Database.php';

$db = new Database();
$conn = $db->connect();

// 示例：插入数据
$data = [
    'name' => 'John Doe',
    'email' => 'john@example.com'
];
$db->insert('test', $data);

// 示例：查询数据
$users = $db->select('test');
print_r($users);

// 示例：更新数据
$updateData = [
    'email' => 'john.doe@example.com'
];
$db->update('test', $updateData, ['id = 1']);

// 示例：删除数据
$db->delete('test', ['id = 1']);
