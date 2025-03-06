<?php
require_once 'init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: blog_login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();
$error = '';

// 添加新标签
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tag'])) {
    $tagName = trim($_POST['name']);
    if (!empty($tagName)) {
        $data = ['name' => $tagName];
        if ($db->insert('blog_tags', $data)) {
            header("Location: blog_manage_tags.php");
            exit();
        } else {
            $error = "添加标签失败";
        }
    }
}

// 删除标签
if (isset($_GET['delete'])) {
    $tagId = $_GET['delete'];
    $db->delete('blog_tags', ['id = :id'], [':id' => $tagId]);
    header("Location: blog_manage_tags.php");
    exit();
}

// 获取所有标签
$tags = $db->select('blog_tags');

include 'header.php';
?>
<div class="container">
    <h2>管理标签</h2>
    
    <!-- 添加标签表单 -->
    <form method="post">
        <input type="text" name="name" placeholder="新标签名称" required>
        <button type="submit" name="add_tag">添加标签</button>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </form>

    <!-- 标签列表 -->
    <div class="tags-list">
        <?php foreach ($tags as $tag): ?>
            <div class="tag-item">
                <span><?= $tag['name'] ?></span>
                <a href="blog_manage_tags.php?delete=<?= $tag['id'] ?>" 
                   onclick="return confirm('确定删除吗？')">删除</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>
