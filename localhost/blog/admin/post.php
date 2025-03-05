<?php
include_once '../includes/auth.php';
include_once '../includes/Database.php';

if (!isLoggedIn()) {
    header('Location: /login.php');
    exit;
}

$db = new Database();
$conn = $db->connect();

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    
    $postData = [
        'user_id' => $_SESSION['user_id'],
        'category_id' => $category_id,
        'title' => $title,
        'content' => $content
    ];
    
    if ($postId = $db->insert('blog_posts', $postData)) {
        // 处理标签关联
        if (!empty($_POST['tags'])) {
            foreach ($_POST['tags'] as $tagId) {
                $db->insert('blog_post_tags', [
                    'post_id' => $postId,
                    'tag_id' => $tagId
                ]);
            }
        }
        header('Location: /public/post.php?id='.$postId);
    }
}

// 获取现有分类和标签
$categories = $db->select('blog_categories');
$tags = $db->select('blog_tags');
?>

<!-- 发布表单 -->
<form method="POST">
    <input type="text" name="title" required>
    <textarea name="content" required></textarea>
    <select name="category_id" required>
        <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
        <?php endforeach; ?>
    </select>
    
    <div class="tags">
        <?php foreach ($tags as $tag): ?>
        <label>
            <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>">
            <?= $tag['name'] ?>
        </label>
        <?php endforeach; ?>
    </div>
    
    <button type="submit">发布文章</button>
</form>
