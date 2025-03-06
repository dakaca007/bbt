<?php
require_once 'init.php';

// 医生权限验证
if (!isset($_SESSION['user_id']) || !$db->exists('exam_doctors', ['user_id' => $_SESSION['user_id']])) {
    die(json_encode(['code' => 403, 'message' => '无权操作']));
}

$db = new Database();
$appointmentId = Security::validateInt($_POST['appointment_id']);

try {
    $db->beginTransaction();

    // 验证预约状态
    $appointment = $db->query("
        SELECT * FROM exam_appointments 
        WHERE id = :id AND status = 1
        FOR UPDATE
    ", [':id' => $appointmentId])[0] ?? null;

    if (!$appointment) {
        throw new Exception("无效的预约记录");
    }

    // 录入结果
    foreach ($_POST['results'] as $itemId => $result) {
        $item = $db->query("
            SELECT * FROM exam_items 
            WHERE id = :id
        ", [':id' => $itemId])[0];

        // 自动判断正常值
        $isNormal = 1;
        if ($item['is_abnormal']) {
            $isNormal = check_normal_range($item['normal_range'], $result['value']);
        }

        $db->insert('exam_results', [
            'appointment_id' => $appointmentId,
            'item_id' => $itemId,
            'result_value' => $result['value'],
            'is_normal' => $isNormal,
            'doctor_id' => $_SESSION['user_id'],
            'notes' => $result['notes'] ?? null
        ], true); // true表示存在则更新
    }

    // 更新预约状态
    $db->update('exam_appointments', [
        'status' => 2
    ], ['id' => $appointmentId]);

    $db->commit();
    echo json_encode(['code' => 200]);

} catch (Exception $e) {
    $db->rollBack();
    http_response_code(400);
    echo json_encode(['code' => 400, 'message' => $e->getMessage()]);
}

// 正常值范围检查函数
function check_normal_range($range, $value) {
    // 实现范围解析逻辑，例如：60-100
    list($min, $max) = explode('-', $range);
    return ($value >= $min && $value <= $max) ? 1 : 0;
}
