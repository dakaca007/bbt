<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();
$user_id = $_SESSION['user_id'];

// 获取用户信息
$user = $db->select('blog_users', ["id = $user_id"])[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
    ];
    if (!empty($_POST['password'])) {
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    // 更新用户信息
    if ($db->update('blog_users', $data, ["id = $user_id"])) {
        echo "资料更新成功！";
    } else {
        echo "更新失败！";
    }
}
?>

<form method="POST">
    用户名: <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
    邮箱: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
    密码: <input type="password" name="password" placeholder="留空则不更改"><br>
    <button type="submit">更新资料</button>
</form>
