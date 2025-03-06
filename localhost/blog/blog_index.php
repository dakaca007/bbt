<?php
require_once 'init.php';
$db = new Database();
$conn = $db->connect();

// 分页配置
$perPage = 5; // 每页显示数量
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// 构建查询条件
$where = [];
$params = [];
if (!empty($search)) {
    $where[] = "(title LIKE :search OR content LIKE :search)";
    $params[':search'] = "%{$search}%";
}

// 获取总记录数
$countSql = "SELECT COUNT(*) as total FROM blog_posts";
if (!empty($where)) {
    $countSql .= " WHERE " . implode(" AND ", $where);
}
$totalResult = $db->query($countSql, $params);
$totalCount = $totalResult[0]['total'] ?? 0;

// 计算分页参数
$totalPages = ceil($totalCount / $perPage);
$page = max(1, min($page, $totalPages));
$offset = ($page - 1) * $perPage;

// 获取当前页数据
$sql = "SELECT * FROM blog_posts";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$params[':limit'] = $perPage;
$params[':offset'] = $offset;

// 执行查询
$posts = $db->query($sql, $params);

// 获取统计数据
$stats = [
    'posts' => $db->query("SELECT COUNT(*) as total FROM blog_posts")[0]['total'],
    'users' => $db->query("SELECT COUNT(*) as total FROM blog_users")[0]['total'],
    'comments' => $db->query("SELECT COUNT(*) as total FROM blog_comments")[0]['total'],
];

include 'header.php';
?>
<div class="container">
    <header>
        <h1>博客文章</h1>
        
        <!-- 搜索表单 -->
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="搜索文章..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit">搜索</button>
        </form>

        <!-- 统计面板 -->
        <div class="stats-panel">
            <div class="stat-item">
                <span class="stat-number"><?= $stats['posts'] ?></span>
                <span class="stat-label">文章</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $stats['users'] ?></span>
                <span class="stat-label">用户</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $stats['comments'] ?></span>
                <span class="stat-label">评论</span>
            </div>
        </div>
    </header>

    <!-- 文章列表 -->
    <?php foreach ($posts as $post): ?>
        <article>
            <h2>
                <a href="blog_view_post.php?id=<?= htmlspecialchars($post['id']) ?>">
                    <?= htmlspecialchars($post['title']) ?>
                </a>
            </h2>
            <p><?= htmlspecialchars($post['content']) ?></p>
            <small>发布于: <?= htmlspecialchars($post['created_at']) ?></small>
        </article>
        <hr>
    <?php endforeach; ?>

    <!-- 分页导航 -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <?php $prevQuery = http_build_query(['page' => $page-1, 'search' => $search]) ?>
            <a href="?<?= $prevQuery ?>">上一页</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php $query = http_build_query(['page' => $i, 'search' => $search]) ?>
            <a href="?<?= $query ?>" <?= $i === $page ? 'class="active"' : '' ?>>
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <?php $nextQuery = http_build_query(['page' => $page+1, 'search' => $search]) ?>
            <a href="?<?= $nextQuery ?>">下一页</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<style>
/* 新增样式 */
.search-form {
    margin: 20px 0;
    display: flex;
    gap: 10px;
}

.search-form input {
    flex: 1;
    padding: 8px;
}

.stats-panel {
    display: flex;
    gap: 20px;
    margin: 20px 0;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9em;
}

.pagination {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    justify-content: center;
}

.pagination a {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
}

.pagination a.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
}
</style>
