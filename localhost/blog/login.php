<?php
require_once 'init.php';

if (isset($_SESSION['user_id'])) {
    header("Location: blog_index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->connect();
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $users = $db->select('blog_users', ['username = :username'], [':username' => $username]);
    if (!empty($users) && password_verify($password, $users[0]['password'])) {
        $_SESSION['user_id'] = $users[0]['id'];
        $_SESSION['username'] = $users[0]['username'];
        header("Location: blog_index.php");
        exit();
    } else {
        $error = "用户名或密码错误";
    }
}

include 'header.php';
?>
<div class="container">
    <h2>用户登录</h2>
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="用户名" required>
        <input type="password" name="password" placeholder="密码" required>
        <button type="submit">登录</button>
    </form>
</div>
<?php include 'footer.php'; ?>
