// user_register.php
session_start();
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    
    // 防暴力注册：检查时间间隔
    if (isset($_SESSION['last_reg']) && (time() - $_SESSION['last_reg']) < 10) {
        die("操作过于频繁，请稍后再试");
    }
    
    $db = new Database();
    $conn = $db->connect();
    
    // 检查用户名和邮箱是否重复
    $userExists = $conn->prepare("SELECT id FROM forum_users WHERE username = ? OR email = ?");
    $userExists->execute([$username, $email]);
    if ($userExists->rowCount() > 0) {
        die("用户名或邮箱已被注册");
    }
    
    // 密码强度要求
    if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/\d/", $password)) {
        die("密码需至少8位且包含大写字母和数字");
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // 插入用户数据
    $data = [
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword
    ];
    
    if ($db->insert('forum_users', $data)) {
        $_SESSION['user_id'] = $conn->lastInsertId();
        $_SESSION['last_reg'] = time();
        header("Location: index.php"); // 注册成功跳转
    }
}
