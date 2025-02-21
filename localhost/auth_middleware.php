// auth_middleware.php
session_start();

function isAdmin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    
    $db = new Database();
    $conn = $db->connect();
    $user = $conn->prepare("SELECT role FROM forum_users WHERE id = ?");
    $user->execute([$_SESSION['user_id']]);
    $role = $user->fetchColumn();
    
    return ($role === 'admin' || $role === 'moderator');
}

// 使用示例（在管理员删除分类的页面顶部）：
if (!isAdmin()) {
    die("无权访问此页面");
}
