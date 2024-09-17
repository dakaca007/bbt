<?php
require_once 'Database.php';

$db = new Database();
$conn = $db->connect();

// 插入用户
function insertUser($db, $userData) {
    return $db->insert('users', $userData);
}

// 更新用户
function updateUser($db, $id, $userData) {
    $updateConditions = ['id = ' . intval($id)];
    return $db->update('users', $userData, $updateConditions);
}

// 删除用户
function deleteUser($db, $id) {
    $deleteConditions = ['id = ' . intval($id)];
    return $db->delete('users', $deleteConditions);
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // 判断操作类型
    if ($_POST['action'] === '注册/更新') {
        if ($userId) {
            // 更新用户
            $updateData = ['username' => $username, 'email' => $email];
            if ($password) {
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            if (updateUser($db, $userId, $updateData)) {
                echo "用户信息更新成功";
            } else {
                echo "更新失败";
            }
        } else {
            // 插入用户
            $userData = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
            $insertId = insertUser($db, $userData);
            if ($insertId) {
                echo "新用户插入成功，用户 ID: " . $insertId;
            } else {
                echo "插入用户失败";
            }
        }
    } elseif ($_POST['action'] === '删除') {
        if ($userId && deleteUser($db, $userId)) {
            echo "用户删除成功";
        } else {
            echo "删除失败";
        }
    }
}
?>
