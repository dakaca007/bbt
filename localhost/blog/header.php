<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的博客</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* 基本样式 */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        nav {
            background: linear-gradient(135deg, #c0c0c0, #ffffff);
            border-radius: 15px;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav li {
            margin: 0 15px;
        }
        nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        nav a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <!-- 其他菜单项 -->
        <?php if (isset($_SESSION['username'])): ?>
            <li>欢迎，<?= $_SESSION['username'] ?></li>
            <li><a href="blog_logout.php">退出</a></li>
        <?php else: ?>
            <li><a href="login.php">登录</a></li>
            <li><a href="register.php">注册</a></li>
        <?php endif; ?>
    </ul>
</nav>
