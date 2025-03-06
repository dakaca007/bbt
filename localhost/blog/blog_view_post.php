<?php
require_once 'init.php';
$db = new Database();
$conn = $db->connect();

if (isset($_GET['id'])) {
    $postId = intval($_GET['id']);
    // 获取文章详情
    $conditions = ["id = :id"];
    $params = [":id" => $postId];
    $posts = $db->select('blog_posts', $conditions, $params);
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
    // 获取评论
    $conditions = ["post_id = :post_id"];
    $params = [":post_id" => $postId];
    $comments = $db->select('blog_comments', $conditions, $params);

    // 处理评论提交（采用 PRG 模式）
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['user_id'])) {
            header("Location: blog_login.php");
            exit();
        } else {
            $commentContent = trim($_POST['content']);
            if ($commentContent !== "") {
                $commentData = [
                    'post_id' => $postId,
                    'user_id' => $_SESSION['user_id'],
                    'content' => $commentContent
                ];
                if ($db->insert('blog_comments', $commentData)) {
                    header("Location: blog_view_post.php?id=" . $postId);
                    exit();
                } else {
                    $commentError = "评论失败，请稍后重试！";
                }
            } else {
                $commentError = "评论内容不能为空！";
            }
        }
    }
} else {
    die("没有提供文章ID！");
}
include 'header.php';
?>
<div class="container">
    <nav>
        <ul>
            <li><a href="blog_index.php">首页</a></li>
            <li><a href="blog_login.php">登录</a></li>
            <li><a href="blog_register.php">注册</a></li>
        </ul>
    </nav>
    <article>
        <h2><?= $title ?></h2>
        <p><?= $content ?></p>
        <small>Posted by User ID: <?= $userId ?> on <?= $createdAt ?></small>
    </article>
    
    <section>
        <h3>评论</h3>
        <?php 
        if (isset($commentError)) {
            echo "<p style='color:red;'>$commentError</p>";
        }
        foreach ($comments as $comment): ?>
            <div class="comment" style="background-color:#f9f9f9; padding:10px; margin:10px 0; border-left: 4px solid #007BFF;">
                <p><?= htmlspecialchars($comment['content']) ?></p>
                <small>User ID: <?= htmlspecialchars($comment['user_id']) ?> on <?= htmlspecialchars($comment['created_at']) ?></small>
            </div>
        <?php endforeach; ?>
    </section>
    
    <section>
        <form method="POST">
            <label for="content">评论:</label>
            <textarea name="content" required></textarea><br>
            <button type="submit">提交评论</button>
        </form>
    </section>
</div>
<?php include 'footer.php'; ?>
