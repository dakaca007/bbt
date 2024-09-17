<?php
session_start();
require_once 'Database.php';

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $db = new Database();
    $conn = $db->connect();

    // 获取文章
    $posts = $db->select('blog_posts', ["id = $postId"]);
    if ($posts) {
        $post = $posts[0];
        echo "<h2>{$post['title']}</h2>";
        echo "<p>{$post['content']}</p>";
        echo "<small>Posted by User ID: {$post['user_id']} on {$post['created_at']}</small><br><br>";
    } else {
        echo "文章不存在！";
    }

    // 获取评论
    $comments = $db->select('blog_comments', ["post_id = $postId"]);
    foreach ($comments as $comment) {
        echo "<p>{$comment['content']}</p>";
        echo "<small>User ID: {$comment['user_id']} on {$comment['created_at']}</small><br><br>";
    }

    // 添加评论
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['user_id'])) {
            echo "请先登录才能评论！";
        } else {
            $content = $_POST['content'];
            $user_id = $_SESSION['user_id'];

            $data = [
                'post_id' => $postId,
                'user_id' => $user_id,
                'content' => $content,
            ];

            if ($db->insert('blog_comments', $data)) {
                echo "评论成功！";
            } else {
                echo "评论失败！";
            }
        }
    }
?>
<form method="POST">
    评论: <textarea name="content" required></textarea><br>
    <button type="submit">提交评论</button>
</form>
<?php
} else {
    echo "没有提供文章 ID！";
}
?>
