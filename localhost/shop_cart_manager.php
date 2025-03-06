<?php
require_once 'init.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['code' => 401, 'message' => '请先登录']));
}

$db = new Database();

switch ($_GET['action'] ?? '') {
    case 'add':
        $productId = (int)$_POST['product_id'];
        $skuId = $_POST['sku_id'] ? (int)$_POST['sku_id'] : null;
        $quantity = (int)$_POST['quantity'];

        // 检查是否已存在
        $exists = $db->query("
            SELECT * FROM shop_carts 
            WHERE user_id = :uid 
              AND product_id = :pid 
              AND sku_id " . ($skuId ? "= :sku" : "IS NULL"), 
            [
                ':uid' => $_SESSION['user_id'],
                ':pid' => $productId,
                ':sku' => $skuId
            ]);

        if ($exists) {
            $db->update('shop_carts', [
                'quantity' => $exists[0]['quantity'] + $quantity
            ], ['id' => $exists[0]['id']]);
        } else {
            $db->insert('shop_carts', [
                'user_id' => $_SESSION['user_id'],
                'product_id' => $productId,
                'sku_id' => $skuId,
                'quantity' => $quantity
            ]);
        }

        echo json_encode(['code' => 200]);
        break;

    case 'update':
        $db->update('shop_carts', [
            'quantity' => (int)$_POST['quantity'],
            'selected' => (int)$_POST['selected']
        ], [
            'id' => (int)$_POST['cart_id'],
            'user_id' => $_SESSION['user_id']
        ]);
        echo json_encode(['code' => 200]);
        break;

    case 'delete':
        $db->delete('shop_carts', [
            'id' => (int)$_POST['cart_id'],
            'user_id' => $_SESSION['user_id']
        ]);
        echo json_encode(['code' => 200]);
        break;

    default:
        $cart = $db->query("
            SELECT c.*, p.title, p.cover_image, 
                   IFNULL(s.price, p.price) as price
            FROM shop_carts c
            JOIN shop_products p ON c.product_id = p.id
            LEFT JOIN shop_product_skus s ON c.sku_id = s.id
            WHERE c.user_id = :uid
        ", [':uid' => $_SESSION['user_id']]);

        echo json_encode(['code' => 200, 'data' => $cart]);
}
