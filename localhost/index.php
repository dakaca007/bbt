<?php
// 手动配置外网音乐列表（示例）
$musicFiles = [
    
    [
        'name' => '流浪兄弟',
        'path' => 'https://bbt.free.nf/流浪兄弟.mp3'
    ]
];
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>外网音乐播放器</title>
    <style>
        .player-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        #audio-player {
            width: 100%;
            margin: 1.5rem 0;
            border-radius: 8px;
        }

        .playlist {
            list-style: none;
            padding: 0;
            margin-top: 1.5rem;
        }

        .playlist li {
            padding: 12px 20px;
            margin: 8px 0;
            background: #f8f9fa;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .playlist li:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        #now-playing {
            margin-top: 1rem;
            font-weight: 500;
            color: #2d3436;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="player-container">
        <h2>外网音乐播放器</h2>
        
        <!-- 音频播放器 -->
        <audio id="audio-player" controls>
            您的浏览器不支持音频播放
        </audio>

        <!-- 播放列表 -->
        <ul class="playlist">
            <?php if (!empty($musicFiles)): ?>
                <?php foreach ($musicFiles as $index => $music): ?>
                    <li onclick="playMusic('<?= htmlspecialchars(urlencode($music['path'])) ?>', '<?= htmlspecialchars($music['name']) ?>')">
                        <span style="margin-right: 15px; color: #6c757d;"><?= $index + 1 ?>.</span>
                        <span><?= htmlspecialchars($music['name']) ?></span>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li style="cursor: default; background: transparent;">暂无可播放音乐</li>
            <?php endif; ?>
        </ul>

        <div id="now-playing"></div>
    </div>

    <script>
        const player = document.getElementById('audio-player');
        let currentSong = null;

        function playMusic(encodedPath, name) {
            try {
                const decodedPath = decodeURIComponent(encodedPath);
                player.src = decodedPath;
                player.play();
                
                // 更新当前播放显示
                currentSong = name;
                document.getElementById('now-playing').textContent = `正在播放：${currentSong}`;
                
                // 更新列表项状态
                document.querySelectorAll('.playlist li').forEach(item => {
                    item.style.background = item.textContent.includes(name) ? '#e3f2fd' : '#f8f9fa';
                });
            } catch (error) {
                console.error('播放错误:', error);
                alert('无法播放该音乐，请检查文件地址');
            }
        }

        // 自动下一曲功能
        player.addEventListener('ended', () => {
            const currentIndex = [...document.querySelectorAll('.playlist li')]
                .findIndex(item => item.textContent.includes(currentSong));
            
            if (currentIndex >= 0 && currentIndex < <?= count($musicFiles) - 1 ?>) {
                document.querySelectorAll('.playlist li')[currentIndex + 1].click();
            }
        });

        // 错误处理
        player.addEventListener('error', (e) => {
            console.error('播放器错误:', e);
            document.getElementById('now-playing').textContent = '播放失败：请检查网络连接或文件地址';
        });
    </script>
</body>
</html>
