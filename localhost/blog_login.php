<?php
session_start();
require_once 'Database.php';
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>博客</title>
    <link rel="stylesheet" href="styles.css"> <!-- 连接你的CSS文件 -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
        }
        small {
            color: #999;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        @media(max-width: 600px) {
            h2 {
                font-size: 1.5em;
            }
            p, small {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
        <?php
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
</body>
</html>
