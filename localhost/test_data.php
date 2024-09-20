<?php
$db = new Database();
$conn = $db->connect();

// 插入
$data = ['name' => 'John', 'age' => 30];
$id = $db->insert('users', $data);

// 查询
$results = $db->select('users', ['age > 20']);

// 更新
$updateData = ['age' => 31];
$affectedRows = $db->update('users', $updateData, ['id = :id']); // 确保手动绑定参数

// 删除
//$deletedRows = $db->delete('users', ['id = :id']);
