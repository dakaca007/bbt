<?php
session_start();
require_once 'Database.php';

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $db = new Database();
    $conn = $db->connect();

    // Fetch the post
    $posts = $db->select('blog_posts', ["id = $postId"]);
    if ($posts) {
        $post = $posts[0];
        $title = htmlspecialchars($post['title']);
        $content = nl2br(htmlspecialchars($post['content']));
        $userId = htmlspecialchars($post['user_id']);
        $createdAt = htmlspecialchars($post['created_at']);
    } else {
        $title = "文章不存在！";
        $content = "";
    }

    // Fetch comments
    $comments = $db->select('blog_comments', ["post_id = $postId"]);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            
        }

        nav {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            position: relative;
            overflow: auto;
        }

        h2 {
            color: #333;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
        }

        .comment {
            background-color: #f9f9f9;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #007BFF;
        }

        small {
            display: block;
            color: #999;
        }

        @media (max-width: 600px) {
            nav {
                font-size: 14px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<nav>
    <a href="blog_index.php">首页</a>
    <a href="blog_login.php">登录</a>
    <a href="blog_register.php">注册</a>
</nav>

<div class="container">
    <h2><?php echo $title; ?></h2>
    <p><?php echo $content; ?></p>
    <small>Posted by User ID: <?php echo $userId; ?> on <?php echo $createdAt; ?></small>
    
    <h3>评论</h3>
    <?php foreach ($comments as $comment) { ?>
        <div class="comment">
            <p><?php echo htmlspecialchars($comment['content']); ?></p>
            <small>User ID: <?php echo htmlspecialchars($comment['user_id']); ?> on <?php echo htmlspecialchars($comment['created_at']); ?></small>
        </div>
    <?php } ?>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['user_id'])) {
            echo "<p>请先登录才能评论！<a href='blog_login.php'>登录</a></p>";
        } else {
            $content = htmlspecialchars($_POST['content']);
            $user_id = $_SESSION['user_id'];
            $data = [
                'post_id' => $postId,
                'user_id' => $user_id,
                'content' => $content,
            ];
            if ($db->insert('blog_comments', $data)) {
                echo "<p>评论成功！</p>";
            } else {
                echo "<p>评论失败！</p>";
            }
        }
    } ?>
    
    <form method="POST">
        <label for="content">评论:</label>
        <textarea name="content" required></textarea><br>
        <button type="submit">提交评论</button>
    </form>
</div>

 
</body>
</html>

<?php
} else {
    echo "没有提供文章 ID！";
}
?>
