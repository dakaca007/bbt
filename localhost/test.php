<?php
// 引入数据库类
include_once 'Database.php';

// 创建数据库对象并连接
$db = new Database();
$conn = $db->connect();

$message = '';  // 用于存储消息
$new_code = ''; // 用于存储代码内容
$code_id = '';  // 用于存储代码ID

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_code = $_POST['code'] ?? '';
    $action = $_POST['action'] ?? '';
    $code_id = $_POST['id'] ?? '';

    // 插入新代码
    if ($action === 'insert') {
        $insert_data = [
            'code' => $new_code,
            'description' => 'PHP code'
        ];
        $insert_id = $db->insert('p_code_storage', $insert_data);
        $message = $insert_id ? "Inserted new code with ID: $insert_id" : "Failed to insert code.";
    }

    // 更新代码
    if ($action === 'update') {
        $update_data = [
            'code' => $new_code,
            'description' => 'Updated Sample PHP code'
        ];
        $update_conditions = ["id = $code_id"];
        $message = $db->update('p_code_storage', $update_data, $update_conditions) ? "Code updated successfully." : "Failed to update code.";
    }

    // 删除代码
    if ($action === 'delete') {
        $delete_conditions = ["id = $code_id"];
        $message = $db->delete('p_code_storage', $delete_conditions) ? "Code deleted successfully." : "Failed to delete code.";
    }

    // 生成 PHP 和 HTML 文件
    if ($action === 'generate') {
        $id = $_POST['generate_id'] ?? '';
        $code = $db->select('p_code_storage', ["id = $id"]);

        if (!empty($code)) {
            $code = $code[0]['code'];
            // 生成 PHP 文件
            file_put_contents("output_${id}.php", $code);
            // 生成 HTML 文件（仅包含代码，但可以按需修改）
            file_put_contents("output_${id}.html", "<pre>" . htmlspecialchars($code) . "</pre>");
            $message = "Files generated: output_${id}.php and output_${id}.html";
        } else {
            $message = "No code found for ID: $id";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Storage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
    <style>
        .CodeMirror {
            height: auto;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Code Storage</h1>
    <form method="POST">
        <textarea id="code" name="code" style="display: none;"><?php echo htmlspecialchars($new_code); ?></textarea>
        <div id="code-editor"></div>
        <br>
        <input type="hidden" name="id" id="code-id" value="<?php echo htmlspecialchars($code_id); ?>">
        <button type="submit" name="action" value="insert">Insert Code</button>
        <button type="submit" name="action" value="update" onclick="if(!confirm('Are you sure you want to update?')) return false;">Update Code</button>
    </form>

    <form method="POST" style="margin-top: 20px;">
        <label for="delete-id">Enter ID to delete:</label>
        <input type="number" id="delete-id" name="id" required>
        <button type="submit" name="action" value="delete" onclick="if(!confirm('Are you sure you want to delete this code?')) return false;">Delete Code</button>
    </form>

    <h2>Messages:</h2>
    <p><?php echo htmlspecialchars($message); ?></p>

    <h2>Codes in the database:</h2>
    <?php
    // 从 p_code_storage 表选择代码
    $conditions = [];
    $codes = $db->select('p_code_storage', $conditions);

    if (!empty($codes)) {
        echo "<ul>";
        foreach ($codes as $code) {
            echo "<li>ID: " . htmlspecialchars($code['id']) . ", Description: " . htmlspecialchars($code['description']) . "<br>" .
                 "<button onclick=\"editCode('" . addslashes(htmlspecialchars($code['code'])) . "', '" . htmlspecialchars($code['id']) . "'); return false;\">Edit</button>
                 <form method='post' style='display:inline;'>
                     <input type='hidden' name='generate_id' value='" . htmlspecialchars($code['id']) . "'>
                     <button type='submit' name='action' value='generate'>Generate Files</button>
                 </form>
                 </li>";
        }
        echo "</ul>";
    } else {
        echo "No codes found in the database.";
    }
    ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/clike/clike.min.js"></script>
    <script>
        // 初始化 CodeMirror 编辑器
        var editor = CodeMirror(document.getElementById("code-editor"), {
            value: document.getElementById("code").value,
            lineNumbers: true,
            mode: "text/x-php",
            theme: "default",
        });

        function editCode(code, id) {
            // 设置 CodeMirror 编辑器的内容
            editor.setValue(code);
            // 设置隐藏的 ID
            document.getElementById('code-id').value = id;
        }

        // 在表单提交时将 CodeMirror 的内容存入 textarea
        document.querySelector('form').onsubmit = function() {
            document.querySelector('[name=code]').value = editor.getValue();
        };
    </script>
</body>
</html>