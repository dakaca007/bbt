<?php
require_once 'init.php';
$db = new Database();
$conn = $db->connect();

$postId = $_GET['id'] ?? 0;

// 获取文章详情
$post = $db->select('blog_posts', ['id = :id'], [':id' => $postId]);
if (empty($post)) {
    die("文章不存在");
}
$post = $post[0];

// 获取分类信息
$category = $db->select('blog_categories', ['id = :id'], [':id' => $post['category_id']])[0] ?? [];

// 获取标签
$tags = $db->select(
    "blog_tags t JOIN blog_post_tags pt ON t.id = pt.tag_id",
    ["pt.post_id = :post_id"],
    [':post_id' => $postId]
);

// 获取评论
$comments = $db->select('blog_comments', ['post_id = :post_id'], [':post_id' => $postId]);

include 'header.php';
?>
<div class="container">
    <article>
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <small>分类：<?= $category['name'] ?? '未分类' ?></small>
        <div class="tags">
            <?php foreach ($tags as $tag): ?>
                <span class="tag"><?= $tag['name'] ?></span>
            <?php endforeach; ?>
        </div>
        <div class="content">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>
        <small>发布于：<?= $post['created_at'] ?></small>
    </article>

    <section class="comments">
        <h3>评论（<?= count($comments) ?>）</h3>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><?= htmlspecialchars($comment['content']) ?></p>
                <small><?= $comment['created_at'] ?></small>
            </div>
        <?php endforeach; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="post" action="blog_add_comment.php">
                <input type="hidden" name="post_id" value="<?= $postId ?>">
                <textarea name="content" required></textarea>
                <button type="submit">提交评论</button>
            </form>
        <?php else: ?>
            <p>登录后即可发表评论</p>
        <?php endif; ?>
    </section>
</div>
<?php include 'footer.php'; ?>
