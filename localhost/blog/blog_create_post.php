<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: blog_login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 将文章信息插入
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $user_id = $_SESSION['user_id'];
    
    $data = [
        'user_id' => $user_id,
        'category_id' => $category_id,
        'title' => $title,
        'content' => $content
    ];

    if ($db->insert('blog_posts', $data)) {
        $post_id = $conn->lastInsertId();

        // 将标签插入并链接到文章
        if (isset($_POST['tags'])) {
            foreach ($_POST['tags'] as $tag_id) {
                $tag_data = [
                    'post_id' => $post_id,
                    'tag_id' => $tag_id
                ];
                $db->insert('blog_post_tags', $tag_data);
            }
        }
        echo "文章发布成功！";
    } else {
        echo "发布失败！";
    }
}

// 获取所有分类
$categories = $db->select('blog_categories');

// 获取所有标签
$tags = $db->select('blog_tags');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>博客</title>
    <link rel="stylesheet" href="styles.css"> <!-- 连接你的CSS文件 -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            font-size: 1.8em;
            margin-bottom: 10px;
        }
        p {
            color: #555;
        }
        small {
            color: #999;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], 
        textarea, 
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, 
        textarea:focus, 
        select:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        @media(max-width: 600px) {
            h2 {
                font-size: 1.5em;
            }
            p, small {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h2>发布新文章</h2>
    </header>
    <form method="POST">
        <label for="title">标题</label>
        <input type="text" id="title" name="title" required>
        
        <label for="content">内容</label>
        <textarea id="content" name="content" required rows="10"></textarea>
        
        <label for="category_id">分类</label>
        <select id="category_id" name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <label>标签</label>
        <?php foreach ($tags as $tag): ?>
            <input type="checkbox" name="tags[]" value="<?php echo $tag['id']; ?>"> 
            <?php echo $tag['name']; ?><br>
        <?php endforeach; ?>
        
        <button type="submit">发布文章</button>
    </form>
</div>
</body>
</html>
