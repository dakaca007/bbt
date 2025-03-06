<?php
require_once 'init.php';

// 医生权限验证
if (!isset($_SESSION['user_id']) || !$db->exists('exam_doctors', ['user_id' => $_SESSION['user_id']])) {
    die(json_encode(['code' => 403, 'message' => '无权操作']));
}

$db = new Database();
$appointmentId = Security::validateInt($_POST['appointment_id']);

try {
    // 获取体检数据
    $data = $db->query("
        SELECT 
            u.username, u.gender, u.birthday,
            a.appointment_date,
            p.name as package_name,
            r.item_id, i.item_name, r.result_value, i.normal_range, i.unit,
            r.is_normal, r.notes
        FROM exam_appointments a
        JOIN blog_users u ON a.user_id = u.id
        JOIN exam_packages p ON a.package_id = p.id
        JOIN exam_results r ON a.id = r.appointment_id
        JOIN exam_items i ON r.item_id = i.id
        WHERE a.id = :id
    ", [':id' => $appointmentId]);

    if (empty($data)) {
        throw new Exception("未找到体检数据");
    }

    // 生成PDF报告
    $pdf = new TCPDF();
    $pdf->AddPage();
    
    // 报告头
    $pdf->SetFont('stsongstdlight', 'B', 16);
    $pdf->Cell(0, 10, '体检报告', 0, 1, 'C');
    
    // 用户信息
    $pdf->SetFont('stsongstdlight', '', 12);
    $pdf->Cell(0, 10, "姓名：{$data[0]['username']}", 0, 1);
    $pdf->Cell(0, 10, "体检日期：{$data[0]['appointment_date']}", 0, 1);
    
    // 检测结果表格
    $html = '<table border="1">
        <tr>
            <th width="25%">项目名称</th>
            <th width="15%">检测结果</th>
            <th width="15%">参考范围</th>
            <th width="10%">单位</th>
            <th width="15%">状态</th>
            <th width="20%">备注</th>
        </tr>';
    
    foreach ($data as $row) {
        $status = $row['is_normal'] ? '正常' : '异常';
        $html .= "<tr>
            <td>{$row['item_name']}</td>
            <td>{$row['result_value']}</td>
            <td>{$row['normal_range']}</td>
            <td>{$row['unit']}</td>
            <td>{$status}</td>
            <td>{$row['notes']}</td>
        </tr>";
    }
    
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // 保存文件
    $filename = "reports/report_{$appointmentId}.pdf";
    $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/'.$filename, 'F');

    // 保存报告记录
    $db->insert('exam_reports', [
        'appointment_id' => $appointmentId,
        'summary' => $_POST['summary'],
        'doctor_id' => $_SESSION['user_id'],
        'pdf_path' => $filename
    ]);

    echo json_encode(['code' => 200, 'data' => ['url' => $filename]]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['code' => 400, 'message' => $e->getMessage()]);
}
