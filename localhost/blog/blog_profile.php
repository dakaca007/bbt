<?php
require_once 'init.php';
$db = new Database();
$conn = $db->connect();

// 如果用户未登录，重定向到登录页面
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();
$user_id = $_SESSION['user_id'];

// 使用参数绑定获取用户信息
$userResults = $db->select('blog_users', ["id = :id"], [':id' => $user_id]);
if (!$userResults) {
    die("未找到对应用户信息。");
}
$user = $userResults[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 对输入的数据进行处理
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $email    = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $password = trim($_POST['password']);

    // 如果 email 格式错误，则直接退出
    if (!$email) {
        echo "邮箱格式不正确，请重新输入。";
        exit();
    }

    // 准备更新数据
    $data = [
        'username' => $username,
        'email'    => $email,
    ];
    if (!empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    // 使用参数绑定更新用户信息（注意：此处的 update 方法要求传入 where 子句和绑定参数）
    $updateResult = $db->update('blog_users', $data, ["id = :id"], [':id' => $user_id]);
    if ($updateResult) {
        echo "资料更新成功！";
        // 重新获取用户数据，保证显示最新信息
        $userResults = $db->select('blog_users', ["id = :id"], [':id' => $user_id]);
        $user = $userResults[0];
    } else {
        echo "更新失败！";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新资料</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST">
        <label>用户名:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <label>邮箱:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <label>密码:</label>
        <input type="password" name="password" placeholder="留空则不更改">
        <button type="submit">更新资料</button>
    </form>
</body>
</html>
