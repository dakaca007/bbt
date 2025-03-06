<?php
require_once 'init.php';

// 权限验证
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: blog_index.php");
    exit();
}

$db = new Database();
$stats = [
    'total_posts' => $db->query("SELECT COUNT(*) FROM blog_posts")[0]['COUNT(*)'],
    'total_users' => $db->query("SELECT COUNT(*) FROM blog_users")[0]['COUNT(*)'],
    'recent_posts' => $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 5")
];

include 'header.php';
?>
<div class="admin-dashboard">
    <h1>管理面板</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>总文章数</h3>
            <p><?= $stats['total_posts'] ?></p>
        </div>
        <div class="stat-card">
            <h3>注册用户</h3>
            <p><?= $stats['total_users'] ?></p>
        </div>
    </div>

    <section class="recent-posts">
        <h2>最新文章</h2>
        <table>
            <thead>
                <tr>
                    <th>标题</th>
                    <th>作者</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats['recent_posts'] as $post): ?>
                <tr>
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td><?= htmlspecialchars($post['user_id']) ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($post['created_at'])) ?></td>
                    <td>
                        <a href="blog_edit_post.php?id=<?= $post['id'] ?>">编辑</a>
                        <a href="blog_delete_post.php?id=<?= $post['id'] ?>" 
                           onclick="return confirm('确定删除？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

<style>
.admin-dashboard {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.stat-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f8f9fa;
}

tr:hover {
    background-color: #f5f5f5;
}

a {
    color: #007bff;
    margin-right: 10px;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>

<?php include 'footer.php'; ?>
