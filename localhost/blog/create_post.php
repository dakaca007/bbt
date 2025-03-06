<?php
require_once 'init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: blog_login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();
$error = '';

// 获取所有分类
$categories = $db->select('blog_categories');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category_id'];
    $tags = $_POST['tags'] ?? [];
    
    $postData = [
        'user_id' => $_SESSION['user_id'],
        'category_id' => $category_id,
        'title' => $title,
        'content' => $content
    ];
    
    $postId = $db->insert('blog_posts', $postData);
    
    if ($postId) {
        // 处理标签关联
        foreach ($tags as $tagId) {
            $db->insert('blog_post_tags', ['post_id' => $postId, 'tag_id' => $tagId]);
        }
        header("Location: blog_view_post.php?id=$postId");
        exit();
    } else {
        $error = "发布文章失败";
    }
}

include 'header.php';
?>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('content');</script>
<div class="container">
    <h2>发布新文章</h2>
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="title" placeholder="标题" required>
        <textarea name="content" rows="10" required></textarea>
        
        <select name="category_id" required>
            <option value="">选择分类</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
            <?php endforeach; ?>
        </select>
        
        <div>
            <h3>选择标签</h3>
            <?php 
            $tags = $db->select('blog_tags');
            foreach ($tags as $tag): ?>
                <label>
                    <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>">
                    <?= $tag['name'] ?>
                </label>
            <?php endforeach; ?>
        </div>
        
        <button type="submit">发布文章</button>
    </form>
</div>
<?php include 'footer.php'; ?>
