<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->connect();

    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $data = [
        'user_id' => $user_id,
        'title' => $title,
        'content' => $content
    ];

    if ($db->insert('blog_posts', $data)) {
        echo "文章发布成功！";
    } else {
        echo "发布失败！";
    }
}
?>

<form method="POST">
    标题: <input type="text" name="title" required><br>
    内容: <textarea name="content" required></textarea><br>
    <button type="submit">发布文章</button>
</form>
