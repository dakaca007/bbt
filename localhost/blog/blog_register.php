<?php
require_once 'init.php';
$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($email && $password && $password === $confirm_password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'email' => $email,
            'password' => $hashedPassword
        ];
        if ($db->insert('blog_users', $data)) {
            header("Location: blog_login.php");
            exit();
        } else {
            $error = "注册失败，请重试。";
        }
    } else {
        $error = "请确保填写正确，并且两次密码一致。";
    }
}
include 'header.php';
?>
<div class="container">
    <h2>用户注册</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="请输入邮箱" required>
        <input type="password" name="password" placeholder="请输入密码" required>
        <input type="password" name="confirm_password" placeholder="确认密码" required>
        <button type="submit">注册</button>
    </form>
    <p>已有账号？<a href="blog_login.php">登录</a></p>
</div>
<?php include 'footer.php'; ?>
