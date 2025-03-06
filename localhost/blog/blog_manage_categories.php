<?php
require_once 'init.php';
$db = new Database();
$conn = $db->connect();

$db = new Database();
$conn = $db->connect();

// 虽然应该有用户验证和权限检查，我这里假设用户是管理员

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['category_name'])) {
    $data = ['name' => $_POST['category_name']];
    if ($db->insert('blog_categories', $data)) {
        echo "分类添加成功！";
    } else {
        echo "分类添加失败！";
    }
}

// 获取所有分类
$categories = $db->select('blog_categories');
?>

<form method="POST">
    分类名: <input type="text" name="category_name" required>
    <button type="submit">添加分类</button>
</form>

<h3>现有分类</h3>
<ul>
    <?php foreach ($categories as $category): ?>
        <li><?php echo $category['name']; ?></li>
    <?php endforeach; ?>
</ul>
