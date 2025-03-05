<?php
session_start();
require_once 'Database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = $db->connect();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $users = $db->select('blog_users', ["email = '$email'"]);
    if ($users) {
        if (password_verify($password, $users[0]['password'])) {
            $_SESSION['user_id'] = $users[0]['id'];
            header("Location: blog_index.php"); // 重定向到首页或其他页面
            exit();
        } else {
            $error = "密码错误，请重试！";
        }
    } else {
        $error = "用户不存在，请注册新账号！";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            width: 300px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        input {
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>用户登录</h2>
        <?php if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } ?>
        <input type="email" name="email" placeholder="请输入邮箱" required><br>
        <input type="password" name="password" placeholder="请输入密码" required><br>
        <button type="submit">登录</button>
        <p>还没有账号？<a href="blog_register.php">注册</a></p>
    </form>
</body>
</html>
