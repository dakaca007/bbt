<?php
require_once 'init.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['code' => 401, 'message' => '请先登录']));
}

$db = new Database();
$conn = $db->connect();

try {
    $conn->beginTransaction();

    // 获取购物车选中商品
    $cartItems = $db->query("
        SELECT c.*, p.price as product_price, 
               IFNULL(s.price, p.price) as final_price,
               IFNULL(s.stock, p.stock) as stock
        FROM shop_carts c
        LEFT JOIN shop_products p ON c.product_id = p.id
        LEFT JOIN shop_product_skus s ON c.sku_id = s.id
        WHERE c.user_id = :user_id AND c.selected = 1
    ", [':user_id' => $_SESSION['user_id']]);

    if (empty($cartItems)) {
        throw new Exception("没有选中商品");
    }

    // 校验库存
    foreach ($cartItems as $item) {
        if ($item['stock'] < $item['quantity']) {
            throw new Exception("商品 {$item['title']} 库存不足");
        }
    }

    // 创建订单
    $orderNo = date('YmdHis') . mt_rand(1000, 9999);
    $totalAmount = array_sum(array_column($cartItems, 'final_price'));

    $orderId = $db->insert('shop_orders', [
        'order_no' => $orderNo,
        'user_id' => $_SESSION['user_id'],
        'total_amount' => $totalAmount,
        'address_id' => $_POST['address_id'],
        'status' => 0
    ]);

    // 创建订单明细
    foreach ($cartItems as $item) {
        $db->insert('shop_order_items', [
            'order_id' => $orderId,
            'product_id' => $item['product_id'],
            'sku_id' => $item['sku_id'],
            'price' => $item['final_price'],
            'quantity' => $item['quantity']
        ]);

        // 扣减库存
        if ($item['sku_id']) {
            $db->query("
                UPDATE shop_product_skus 
                SET stock = stock - :qty 
                WHERE id = :sku_id
            ", [':qty' => $item['quantity'], ':sku_id' => $item['sku_id']]);
        } else {
            $db->query("
                UPDATE shop_products 
                SET stock = stock - :qty 
                WHERE id = :product_id
            ", [':qty' => $item['quantity'], ':product_id' => $item['product_id']]);
        }

        // 记录库存变更
        $db->insert('shop_inventory_logs', [
            'product_id' => $item['product_id'],
            'sku_id' => $item['sku_id'],
            'change_stock' => -$item['quantity'],
            'remark' => "订单 {$orderNo} 扣减库存"
        ]);
    }

    // 清空购物车
    $db->delete('shop_carts', [
        'user_id' => $_SESSION['user_id'],
        'selected' => 1
    ]);

    $conn->commit();
    
    echo json_encode([
        'code' => 200,
        'data' => ['order_no' => $orderNo]
    ]);

} catch (Exception $e) {
    $conn->rollBack();
    http_response_code(400);
    echo json_encode([
        'code' => 400,
        'message' => $e->getMessage()
    ]);
}
