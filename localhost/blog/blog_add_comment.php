<?php
require_once 'init.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: blog_index.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

$commentData = [
    'post_id' => $_POST['post_id'],
    'user_id' => $_SESSION['user_id'],
    'content' => trim($_POST['content'])
];

if ($db->insert('blog_comments', $commentData)) {
    header("Location: blog_view_post.php?id=" . $_POST['post_id']);
} else {
    die("评论提交失败");
}
?>
