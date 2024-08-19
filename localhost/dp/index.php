<?php
require_once 'Database.php';
require_once 'NewsScraper.php';

$db = new Database();
$conn = $db->connect();

// 爬取新闻
$scraper = new NewsScraper('https://www.cnn.com/world');
$newsItems = $scraper->scrape();

// 存储新闻到数据库
foreach ($newsItems as $news) {
    $db->insert('news2', $news);
}

// 查询并显示存储的新闻
$storedNews = $db->select('news2');
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>热点新闻</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">热点新闻</h1>
    <ul class="list-group mt-3">
        <?php foreach ($storedNews as $news): ?>
            <li class="list-group-item">
                <a href="<?php echo $news['link']; ?>" target="_blank"><?php echo $news['title']; ?></a>
                <small class="text-muted"><?php echo $news['published_at']; ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
