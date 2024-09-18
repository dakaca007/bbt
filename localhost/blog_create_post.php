<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>发布文章 - 博客</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h1>发布新文章</h1>
            <p class="lead">分享你的思想与见解</p>
        </header>

        <form method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="form-group">
                <label for="title">标题:</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="输入文章标题" required>
            </div>
            <div class="form-group">
                <label for="content">内容:</label>
                <textarea id="content" name="content" class="form-control" rows="5" placeholder="输入文章内容" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">分类:</label>
                <select name="category_id" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>标签:</label><br>
                <?php foreach ($tags as $tag): ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="tags[]" value="<?php echo $tag['id']; ?>">
                        <label class="form-check-label"><?php echo $tag['name']; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">发布文章</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
