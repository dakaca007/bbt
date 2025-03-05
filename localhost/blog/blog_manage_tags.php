<?php
session_start();
require_once 'Database.php';

$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tag_name'])) {
    $data = ['name' => $_POST['tag_name']];
    if ($db->insert('blog_tags', $data)) {
        echo "标签添加成功！";
    } else {
        echo "标签添加失败！";
    }
}

// 获取所有标签
$tags = $db->select('blog_tags');
?>

<form method="POST">
    标签名: <input type="text" name="tag_name" required>
    <button type="submit">添加标签</button>
</form>

<h3>现有标签</h3>
<ul>
    <?php foreach ($tags as $tag): ?>
        <li><?php echo $tag['name']; ?></li>
    <?php endforeach; ?>
</ul>
