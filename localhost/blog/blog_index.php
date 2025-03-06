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
        <nav>
            <ul>
                <li><a href="blog_index.php">首页</a></li>
                <li><a href="https://bbt.onrender.com/file.php">简易网盘</a></li>
                <li><a href="blog_manage_tags.php">管理标签</a></li>
                <li><a href="blog_manage_categories.php">管理目录</a></li>
                <li><a href="blog_profile.php">个人信息</a></li>
                <li><a href="blog_login.php">登录</a></li>
                <li><a href="blog_register.php">注册</a></li>
                <li><a href="blog_create_post.php">发布</a></li>
            </ul>
        </nav>
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
