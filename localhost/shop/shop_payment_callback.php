<?php
require_once 'init.php';
$db = new Database();

// 支付宝回调示例
$data = $_POST;
$sign = $data['sign'];
unset($data['sign']);

// 验证签名（需实现具体平台的签名验证）
if (!verify_alipay_sign($data, $sign)) {
    die("签名验证失败");
}

try {
    $order = $db->query("
        SELECT * FROM shop_orders 
        WHERE order_no = :order_no 
        FOR UPDATE
    ", [':order_no' => $data['out_trade_no']])[0];

    if (!$order) {
        die("订单不存在");
    }

    if ($order['status'] != 0) {
        die("订单状态异常");
    }

    // 更新订单状态
    $db->update('shop_orders', [
        'status' => 1,
        'payment_method' => 'alipay'
    ], ['id' => $order['id']]);

    // 记录支付
    $db->insert('shop_payments', [
        'order_no' => $order['order_no'],
        'amount' => $data['total_amount'],
        'platform' => 'alipay',
        'transaction_id' => $data['trade_no'],
        'status' => 1,
        'paid_at' => date('Y-m-d H:i:s')
    ]);

    // 处理优惠券状态
    if (!empty($order['coupon_id'])) {
        $db->update('shop_user_coupons', [
            'status' => 1,
            'used_time' => date('Y-m-d H:i:s')
        ], ['id' => $order['coupon_id']]);
    }

    echo "success";

} catch (Exception $e) {
    error_log("支付回调异常: " . $e->getMessage());
    die("处理失败");
}

// 支付宝签名验证函数
function verify_alipay_sign($data, $sign) {
    // 实现具体平台的签名验证逻辑
    return true; 
}
