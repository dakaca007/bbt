<?php
require_once 'init.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['code' => 401, 'message' => '请先登录']));
}

$db = new Database();
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'create':
            $data = [
                'package_id' => Security::validateInt($_POST['package_id']),
                'appointment_date' => $_POST['date'],
                'time_slot' => $_POST['time_slot']
            ];

            // 验证可预约数量
            $existing = $db->query("
                SELECT COUNT(*) as count 
                FROM exam_appointments 
                WHERE appointment_date = :date 
                  AND time_slot = :slot 
                  AND status IN (0,1)
            ", [
                ':date' => $data['appointment_date'],
                ':slot' => $data['time_slot']
            ])[0]['count'];

            $maxCapacity = $db->query("
                SELECT max_capacity 
                FROM exam_time_slots 
                WHERE start_time = SUBSTRING_INDEX(:slot, '-', 1)
                  AND end_time = SUBSTRING_INDEX(:slot, '-', -1)
            ", [':slot' => $data['time_slot']])[0]['max_capacity'] ?? 30;

            if ($existing >= $maxCapacity) {
                throw new Exception("该时段已约满");
            }

            $appointmentId = $db->insert('exam_appointments', array_merge($data, [
                'user_id' => $_SESSION['user_id'],
                'status' => 1
            ]));

            echo json_encode(['code' => 200, 'data' => $appointmentId]);
            break;

        case 'cancel':
            $appointmentId = Security::validateInt($_POST['id']);
            $db->update('exam_appointments', 
                ['status' => 3],
                ['id' => $appointmentId, 'user_id' => $_SESSION['user_id']]
            );
            echo json_encode(['code' => 200]);
            break;

        default:
            $appointments = $db->query("
                SELECT a.*, p.name as package_name 
                FROM exam_appointments a
                JOIN exam_packages p ON a.package_id = p.id
                WHERE a.user_id = :uid
                ORDER BY a.appointment_date DESC
            ", [':uid' => $_SESSION['user_id']]);
            echo json_encode(['code' => 200, 'data' => $appointments]);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['code' => 400, 'message' => $e->getMessage()]);
}
