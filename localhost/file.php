<?php
// 配置文件设置
$upload_dir = __DIR__ . '/uploads/';  // 上传目录
$allowed_types = ['*']; // 允许的文件类型
$max_size = 5 * 1024 * 1024; // 5MB

// 自动创建上传目录
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
    file_put_contents($upload_dir . '.htaccess', "php_flag engine off\nDeny from all");
}

// 处理文件上传
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        
        // 基础验证
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '_' . preg_replace('/[^a-z0-9\.]/', '', $file['name']);
        $target_path = $upload_dir . $new_filename;

        // 类型和大小验证
        if (in_array($ext, $allowed_types) && 
            $file['size'] <= $max_size && 
            move_uploaded_file($file['tmp_name'], $target_path)) {
            header('Location: ?');
            exit;
        }
    }
}

// 处理文件操作
$action = $_GET['action'] ?? '';
$filename = isset($_GET['file']) ? basename($_GET['file']) : '';

if ($filename && file_exists($upload_dir . $filename)) {
    switch ($action) {
        case 'download':
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            readfile($upload_dir . $filename);
            exit;
            
        case 'edit':
            if (strpos(mime_content_type($upload_dir . $filename), 'text/') === 0) {
                $content = file_get_contents($upload_dir . $filename);
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    file_put_contents($upload_dir . $filename, $_POST['content']);
                    header('Location: ?');
                    exit;
                }
                // 显示编辑界面
                echo '<form method="post"><textarea name="content" style="width:100%;height:300px">' 
                     . htmlspecialchars($content) . '</textarea><button>保存</button></form>';
                exit;
            }
            break;
            
        case 'delete':
            unlink($upload_dir . $filename);
            header('Location: ?');
            exit;
    }
}

// 显示文件列表
$files = array_diff(scandir($upload_dir), ['.', '..', '.htaccess']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>文件管理系统</title>
    <style>
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ccc; padding:8px; }
        .preview img { max-width:200px; max-height:150px; }
    </style>
</head>
<body>
    <h2>文件管理</h2>
    
    <!-- 上传表单 -->
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">上传文件</button>
    </form>

    <!-- 文件列表 -->
    <table>
        <tr>
            <th>文件名</th>
            <th>大小</th>
            <th>上传时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ($files as $file): ?>
        <tr>
            <td>
                <div class="preview">
                    <?php if (substr(mime_content_type($upload_dir . $file), 0, 6) === 'image/'): ?>
                        <img src="?action=download&file=<?= urlencode($file) ?>">
                    <?php else: ?>
                        <?= htmlspecialchars(substr($file, 14)) // 去除前面的随机前缀 ?> 
                    <?php endif; ?>
                </div>
            </td>
            <td><?= round(filesize($upload_dir . $file)/1024) ?>KB</td>
            <td><?= date('Y-m-d H:i', filemtime($upload_dir . $file)) ?></td>
            <td>
                <a href="?action=download&file=<?= urlencode($file) ?>">下载</a>
                <?php if (strpos(mime_content_type($upload_dir . $file), 'text/') === 0): ?>
                    <a href="?action=edit&file=<?= urlencode($file) ?>">编辑</a>
                <?php endif; ?>
                <a href="?action=delete&file=<?= urlencode($file) ?>" 
                   onclick="return confirm('确认删除？')">删除</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
