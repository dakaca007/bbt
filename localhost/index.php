<?php
require_once __DIR__ . '/../src/game.php';

$action = $_GET['action'] ?? '';
$result = null;
$msg = '';

if ($action === 'deal') {
    $result = jinhua_info();
} elseif ($action === 'bet') {
    $amount = intval($_GET['amount'] ?? 0);
    $msg = bet($amount);
} elseif ($action === 'settle') {
    $win = isset($_GET['win']);
    $amount = intval($_GET['amount'] ?? 0);
    $msg = settle($win, $amount);
} elseif ($action === 'set_banker') {
    $deposit = intval($_GET['deposit'] ?? 0);
    $msg = set_banker($deposit);
} elseif ($action === 'quit_banker') {
    $msg = quit_banker();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>纯PHP游戏接口</title>
</head>
<body>
    <h2>纯PHP游戏接口测试</h2>
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