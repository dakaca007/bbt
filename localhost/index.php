<?php
// 设置音乐目录
$musicDir = '/';

// 获取音乐文件列表
$musicFiles = [];
if (is_dir($musicDir)) {
    $files = scandir($musicDir);
    foreach ($files as $file) {
        $path = $musicDir . $file;
        if (is_file($path) && in_array(pathinfo($path, PATHINFO_EXTENSION), ['mp3', 'wav'])) {
            $musicFiles[] = [
                'name' => pathinfo($path, PATHINFO_FILENAME),
                'path' => $path
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>PHP音乐播放器</title>
    <style>
        .player-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 10px;
            text-align: center;
        }

        #audio-player {
            width: 100%;
            margin: 20px 0;
        }

        .playlist {
            list-style: none;
            padding: 0;
        }

        .playlist li {
            padding: 10px;
            margin: 5px;
            background: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .playlist li:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="player-container">
        <h2>简单音乐播放器</h2>
        
        <!-- 音频播放器 -->
        <audio id="audio-player" controls>
            <source src="" type="audio/mpeg">
            您的浏览器不支持音频播放
        </audio>

        <!-- 播放列表 -->
        <ul class="playlist">
            <?php if (!empty($musicFiles)): ?>
                <?php foreach ($musicFiles as $index => $music): ?>
                    <li onclick="playMusic('<?= urlencode($music['path']) ?>', '<?= $music['name'] ?>')">
                        <?= $index + 1 ?>. <?= htmlspecialchars($music['name']) ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>没有找到音乐文件</li>
            <?php endif; ?>
        </ul>

        <div id="now-playing"></div>
    </div>

    <script>
        const player = document.getElementById('audio-player');
        
        function playMusic(path, name) {
            // 解码URL编码的路径
            const decodedPath = decodeURIComponent(path);
            
            // 更新音频源
            player.src = decodedPath;
            player.load();
            player.play();
            
            // 更新显示
            document.getElementById('now-playing').innerHTML = `正在播放: ${name}`;
        }

        // 自动播放下一首（可选功能）
        player.addEventListener('ended', function() {
            const currentItem = document.querySelector('.playlist li:hover');
            if (currentItem && currentItem.nextElementSibling) {
                currentItem.nextElementSibling.click();
            }
        });
    </script>
</body>
</html>
