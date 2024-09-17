<?php
session_start();
require_once 'Database.php';

$db = new Database();
$conn = $db->connect();

// 获取所有文章
$posts = $db->select('blog_posts');

foreach ($posts as $post) {
    echo "<h2><a href='view_post.php?id={$post['id']}'>{$post['title']}</a></h2>";
    echo "<p>{$post['content']}</p>";
    echo "<small>Posted on: {$post['created_at']}</small><br><br>";
}
?>
