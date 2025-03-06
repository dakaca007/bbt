<?php
require_once 'init.php';
$db = new Database();
$conn = $db->connect();

// 查询所有文章（可按需求添加分页、排序等）
$posts = $db->select('blog_posts');

include 'header.php';
?>
<div class="container">
    <header>
        <h1>博客文章</h1>
        
    </header>

    <?php foreach ($posts as $post): ?>
        <article>
            <h2>
                <a href="blog_view_post.php?id=<?= htmlspecialchars($post['id']) ?>">
                    <?= htmlspecialchars($post['title']) ?>
                </a>
            </h2>
            <p><?= htmlspecialchars($post['content']) ?></p>
            <small>Posted on: <?= htmlspecialchars($post['created_at']) ?></small>
        </article>
        <hr>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>
