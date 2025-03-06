<?php
require_once 'init.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: blog_login.php");
    exit();
}
$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // 开启事务
        $conn->beginTransaction();

        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $category_id = intval($_POST['category_id']);
        $user_id = $_SESSION['user_id'];
        $data = [
            'user_id' => $user_id,
            'category_id' => $category_id,
            'title' => $title,
            'content' => $content
        ];
        $post_id = $db->insert('blog_posts', $data);
        if ($post_id) {
            if (isset($_POST['tags']) && is_array($_POST['tags'])) {
                foreach ($_POST['tags'] as $tag_id) {
                    $tag_data = [
                        'post_id' => $post_id,
                        'tag_id' => intval($tag_id)
                    ];
                    $db->insert('blog_post_tags', $tag_data);
                }
            }
            $conn->commit();
            header("Location: blog_view_post.php?id=" . $post_id);
            exit();
        } else {
            $conn->rollBack();
            $error = "发布失败！";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Error posting article: " . $e->getMessage());
        $error = "发布失败，请稍后重试！";
    }
}

// 查询所有分类与标签
$categories = $db->select('blog_categories');
$tags = $db->select('blog_tags');

include 'header.php';
?>
<div class="container">
    <header>
        <h2>发布新文章</h2>
    </header>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="POST">
        <label for="title">标题</label>
        <input type="text" id="title" name="title" required>
        
        <label for="content">内容</label>
        <textarea id="content" name="content" required rows="10"></textarea>
        
        <label for="category_id">分类</label>
        <select id="category_id" name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['id']) ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label>标签</label>
        <?php foreach ($tags as $tag): ?>
            <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag['id']) ?>"> 
            <?= htmlspecialchars($tag['name']) ?><br>
        <?php endforeach; ?>
        
        <button type="submit">发布文章</button>
    </form>
</div>
<?php include 'footer.php'; ?>
