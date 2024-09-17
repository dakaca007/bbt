<?php
session_start();
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->connect();

    $email = $_POST['email'];
    $password = $_POST['password'];

    // 查询用户
    $users = $db->select('blog_users', ["email = '$email'"]);
    if ($users) {
        if (password_verify($password, $users[0]['password'])) {
            $_SESSION['user_id'] = $users[0]['id'];
            echo "登录成功！";
        } else {
            echo "密码错误！";
        }
    } else {
        echo "用户不存在！";
    }
}
?>

<form method="POST">
    邮箱: <input type="email" name="email" required><br>
    密码: <input type="password" name="password" required><br>
    <button type="submit">登录</button>
</form>
