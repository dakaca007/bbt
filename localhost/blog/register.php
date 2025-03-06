<?php
require_once 'init.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->connect();
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 检查用户是否存在
    $existing = $db->select('blog_users', ['username = :username'], [':username' => $username]);
    if (empty($existing)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password
        ];
        
        if ($db->insert('blog_users', $userData)) {
            header("Location: blog_login.php");
            exit();
        } else {
            $error = "注册失败，请重试";
        }
    } else {
        $error = "用户名已存在";
    }
}

include 'header.php';
?>
<div class="container">
    <h2>用户注册</h2>
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="用户名" required>
        <input type="email" name="email" placeholder="邮箱" required>
        <input type="password" name="password" placeholder="密码" required>
        <button type="submit">注册</button>
    </form>
</div>
<?php include 'footer.php'; ?>
