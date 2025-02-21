// create_thread.php
session_start();
require_once 'auth_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $category_id = (int)$_POST['category_id'];
    
    $db = new Database();
    $conn = $db->connect();
    
    // 插入数据
    $data = [
        'user_id' => $_SESSION['user_id'],
        'category_id' => $category_id,
        'title' => $title,
        'content' => $content
    ];
    
    if ($db->insert('forum_threads', $data)) {
        header("Location: thread.php?id=" . $conn->lastInsertId());
    }
}
