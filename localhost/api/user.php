<?php
require_once __DIR__ . '/../Database.php';
session_start();

$db = new Database();
$conn = $db->connect();

$action = $_POST['action'] ?? '';
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($action === 'register') {
    if (!$username || !$password) {
        echo json_encode(['code'=>1, 'msg'=>'用户名和密码不能为空']);
        exit;
    }
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        echo json_encode(['code'=>2, 'msg'=>'用户名已存在']);
        exit;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?,?)");
    $stmt->execute([$username, $hash]);
    echo json_encode(['code'=>0, 'msg'=>'注册成功']);
    exit;
}

if ($action === 'login') {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'coin' => $user['coin']
        ];
        echo json_encode(['code'=>0, 'msg'=>'登录成功', 'user'=>$_SESSION['user']]);
    } else {
        echo json_encode(['code'=>1, 'msg'=>'用户名或密码错误']);
    }
    exit;
}

if ($action === 'logout') {
    unset($_SESSION['user']);
    echo json_encode(['code'=>0, 'msg'=>'已退出']);
    exit;
}
?>