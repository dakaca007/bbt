<?php
require_once 'init.php';
$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 过滤输入
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if ($email && $password) {
        $conditions = ["email = :email"];
        $params = [":email" => $email];
        $users = $db->select('blog_users', $conditions, $params);
        if ($users) {
            if (password_verify($password, $users[0]['password'])) {
                $_SESSION['user_id'] = $users[0]['id'];
                header("Location: blog_index.php");
                exit();
            } else {
                $error = "密码错误，请重试！";
            }
        } else {
            $error = "用户不存在，请注册新账号！";
        }
    } else {
        $error = "无效的输入！";
    }
}
?>

<?php include 'header.php'; ?>
<div class="container">
    <form method="POST">
        <h2>用户登录</h2>
        <?php
        if (isset($error)) {
            echo "<p class='error' style='color:red;'>$error</p>";
        }
        ?>
        <input type="email" name="email" placeholder="请输入邮箱" required>
        <input type="password" name="password" placeholder="请输入密码" required>
        <button type="submit">登录</button>
        <p>还没有账号？<a href="blog_register.php">注册</a></p>
    </form>
</div>
<?php include 'footer.php'; ?>
