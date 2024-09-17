<?php
session_start();
require_once 'Database.php';

$db = new Database();
$conn = $db->connect();

// 获取所有文章
$posts = $db->select('blog_posts');
echo "<p><a href='login.php'>登录</a> | <a href='register.php'>注册</a> | <a href='blog_create_post.php'>发布</a> | <a href='blog_view_post.php'>查看</a></p>";
foreach ($posts as $post) {
    echo "<h2><a href='view_post.php?id={$post['id']}'>{$post['title']}</a></h2>";
    echo "<p>{$post['content']}</p>";
    echo "<small>Posted on: {$post['created_at']}</small><br><br>";
}
?>
