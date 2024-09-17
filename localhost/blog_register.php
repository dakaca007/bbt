<?php
session_start();
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->connect();

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $data = [
        'username' => $username,
        'email' => $email,
        'password' => $password
    ];

    if ($db->insert('blog_users', $data)) {
        echo "注册成功！";
    } else {
        echo "注册失败！";
    }
}
?>

<form method="POST">
    用户名: <input type="text" name="username" required><br>
    邮箱: <input type="email" name="email" required><br>
    密码: <input type="password" name="password" required><br>
    <button type="submit">注册</button>
</form>
