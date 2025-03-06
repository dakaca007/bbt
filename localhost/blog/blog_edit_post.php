<?php
require_once 'init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: blog_login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();
$error = '';

// 获取文章ID
$postId = isset($_GET['id']) ? Security::validateInt($_GET['id']) : 0;

// 验证文章所有权
$post = $db->select('blog_posts', ['id = :id', 'user_id = :uid'], 
    [':id' => $postId, ':uid' => $_SESSION['user_id']]);
    
if (!$post) {
    die("无权编辑此文章");
}

$post = $post[0];

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = Security::sanitizeInput($_POST['title']);
    $content = Security::sanitizeInput($_POST['content']);
    $category_id = Security::validateInt($_POST['category_id']);
    $tags = isset($_POST['tags']) ? array_map('intval', $_POST['tags']) : [];

    try {
        $conn->beginTransaction();
        
        // 更新文章
        $updateData = [
            'title' => $title,
            'content' => $content,
            'category_id' => $category_id
        ];
        $db->update('blog_posts', $updateData, ['id = :id'], [':id' => $postId]);

        // 更新标签
        $db->delete('blog_post_tags', ['post_id = :pid'], [':pid' => $postId]);
        foreach ($tags as $tagId) {
            $db->insert('blog_post_tags', [
                'post_id' => $postId,
                'tag_id' => $tagId
            ]);
        }

        $conn->commit();
        header("Location: blog_view_post.php?id=$postId");
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        $error = "更新失败: " . $e->getMessage();
    }
}

// 获取分类和标签
$categories = $db->select('blog_categories');
$tags = $db->select('blog_tags');
$selectedTags = $db->select('blog_post_tags', ['post_id = :pid'], [':pid' => $postId]);

include 'header.php';
?>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<div class="container">
    <h2>编辑文章</h2>
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
        <textarea name="content" id="editor"><?= htmlspecialchars($post['content']) ?></textarea>
        
        <select name="category_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $post['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="tags-section">
            <h3>选择标签</h3>
            <?php foreach ($tags as $tag): 
                $isSelected = in_array($tag['id'], array_column($selectedTags, 'tag_id')); ?>
                <label>
                    <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" <?= $isSelected ? 'checked' : '' ?>>
                    <?= htmlspecialchars($tag['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <button type="submit">更新文章</button>
    </form>
</div>
<script>CKEDITOR.replace('editor');</script>
<?php include 'footer.php'; ?>
