<?php
include_once 'Database.php';

$db = new Database();
$conn = $db->connect();

$conditions = []; // 根据需要添加条件
$codes = $db->select('p_code_storage', $conditions);

if (!empty($codes)) {
    echo "Executing codes from the database:\n";
    foreach ($codes as $code) {
        echo "Executing code ID: " . $code['id'] . "\n";

        // 提取代码
        $codeToExecute = $code['code'];

         

        try {
            // 将代码和 PHP 标签结合
            eval('?>' . $codeToExecute);
        } catch (Throwable $e) {
            echo "Error executing code: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "No codes found in the database.\n";
}
?>