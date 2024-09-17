<?php
include_once 'Database.php';
// 实例化 Database 类
$db = new Database();
$conn = $db->connect();

// 创建所需的表

$tables = [
    "CREATE TABLE IF NOT EXISTS blog_users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL UNIQUE,
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS blog_posts (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED,
        category_id INT(6) UNSIGNED,
        title VARCHAR(150) NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES blog_users(id) ON DELETE CASCADE,
        FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
    )",

    "CREATE TABLE IF NOT EXISTS blog_categories (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS blog_comments (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        post_id INT(6) UNSIGNED,
        user_id INT(6) UNSIGNED,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES blog_users(id) ON DELETE CASCADE
    )",

    "CREATE TABLE IF NOT EXISTS blog_tags (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL UNIQUE
    )",

    "CREATE TABLE IF NOT EXISTS blog_post_tags (
        post_id INT(6) UNSIGNED,
        tag_id INT(6) UNSIGNED,
        PRIMARY KEY (post_id, tag_id),
        FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
        FOREIGN KEY (tag_id) REFERENCES blog_tags(id) ON DELETE CASCADE
    )"
];

foreach ($tables as $sql) {
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        echo "表创建成功！<br>";
    } catch (PDOException $e) {
        die("创建表错误: " . $e->getMessage());
    }
}
?>
