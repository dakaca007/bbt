<?php
session_start();
require_once 'Database.php';

$db = new Database();
$conn = $db->connect();

// 获取所有文章
$posts = $db->select('blog_posts');
?>
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

<div class="container">
    <header>
        <h1>博客文章</h1>
        <p><a href='blog_login.php'>登录</a> | <a href='blog_register.php'>注册</a> | <a href='blog_create_post.php'>发布</a> | <a href='blog_view_post.php'>查看</a></p>
    </header>

    <?php foreach ($posts as $post): ?>
        <article>
            <h2><a href='view_post.php?id=<?= $post['id'] ?>'><?= htmlspecialchars($post['title']) ?></a></h2>
            <p><?= htmlspecialchars($post['content']) ?></p>
            <small>Posted on: <?= htmlspecialchars($post['created_at']) ?></small>
        </article>
        <hr>
    <?php endforeach; ?>
</div>

</body>
</html>
