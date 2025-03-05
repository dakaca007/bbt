<?php
include_once '../includes/Database.php';

$db = new Database();
$conn = $db->connect();

// 获取分页文章列表
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$posts = $conn->query("
    SELECT p.*, u.username, c.name AS category 
    FROM blog_posts p
    LEFT JOIN blog_users u ON p.user_id = u.id
    LEFT JOIN blog_categories c ON p.category_id = c.id
    ORDER BY p.created_at DESC
    LIMIT $limit OFFSET $offset
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- 文章列表展示 -->
<div class="posts">
    <?php foreach ($posts as $post): ?>
    <article>
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <p class="meta">
            作者：<?= $post['username'] ?> | 
            分类：<?= $post['category'] ?> | 
            <?= date('Y-m-d', strtotime($post['created_at'])) ?>
        </p>
        <div class="content">
            <?= substr(htmlspecialchars($post['content']), 0, 200) ?>...
        </div>
        <a href="post.php?id=<?= $post['id'] ?>">阅读全文</a>
    </article>
    <?php endforeach; ?>
</div>
