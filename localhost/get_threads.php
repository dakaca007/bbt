// get_threads.php
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 20;
$offset = ($page - 1) * $perPage;

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("
    SELECT 
        t.*, 
        u.username,
        c.name AS category_name,
        COUNT(p.id) AS post_count
    FROM forum_threads t
    LEFT JOIN forum_users u ON t.user_id = u.id
    LEFT JOIN forum_categories c ON t.category_id = c.id
    LEFT JOIN forum_posts p ON t.id = p.thread_id
    GROUP BY t.id
    ORDER BY t.created_at DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$threads = $stmt->fetchAll();
