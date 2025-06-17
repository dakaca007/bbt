<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/src/game.php';
session_start();

$db = new Database();
$conn = $db->connect();

// 检查用户是否已登录
$user = $_SESSION['user'] ?? null;
if (!$user) {
    echo json_encode(['code'=>401, 'msg'=>'请先登录']);
    exit;
}

$action = $_GET['action'] ?? '';
$result = null;
$msg = '';

switch ($action) {
    case 'deal':
        $result = jinhua_info();
        break;
    case 'bet':
        $amount = intval($_GET['amount'] ?? 0);
        $msg = bet($conn, $user['id'], $amount);
        break;
    case 'settle':
        $win = isset($_GET['win']);
        $amount = intval($_GET['amount'] ?? 0);
        $msg = settle($conn, $user['id'], $win, $amount);
        break;
    case 'set_banker':
        $deposit = intval($_GET['deposit'] ?? 0);
        $msg = set_banker($conn, $user['id'], $deposit);
        break;
    case 'quit_banker':
        $msg = quit_banker($conn, $user['id']);
        break;
    default:
        $msg = '';
}

echo json_encode([
    'code' => 0,
    'msg' => $msg,
    'result' => $result,
    'user' => $_SESSION['user']
]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>纯PHP游戏接口</title>
</head>
<body>
    <h2>纯PHP游戏接口测试</h2>
    <p>当前用户：<?php echo htmlspecialchars($user['username']); ?> | 金币：<?php echo $_SESSION['coin']; ?></p>
    <form method="get">
        <button name="action" value="deal">炸金花发牌</button>
    </form>
    <form method="get">
        下注金额：<input type="number" name="amount" value="100" min="1">
        <button name="action" value="bet">下注</button>
    </form>
    <form method="get">
        结算金额：<input type="number" name="amount" value="200" min="0">
        <label><input type="checkbox" name="win" value="1">中奖</label>
        <button name="action" value="settle">结算</button>
    </form>
    <form method="get">
        上庄押金：<input type="number" name="deposit" value="500" min="1">
        <button name="action" value="set_banker">上庄</button>
    </form>
    <form method="get">
        <button name="action" value="quit_banker">下庄</button>
    </form>
    <?php if ($msg): ?>
        <p style="color:blue;"><?php echo $msg; ?></p>
    <?php endif; ?>
    <?php if ($result): ?>
        <h3>发牌结果：</h3>
        <pre><?php print_r($result); ?></pre>
    <?php endif; ?>
</body>
</html>