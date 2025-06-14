<?php
// 手动配置外网音乐列表（示例）
$musicFiles = [
    [
        'name' => 'music',
        'path' => 'https://bbt.free.nf/music.mp3'
    ]
];
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>外网音乐播放器</title>
    <style>
        /* 保持原有样式不变 */
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
                    <!-- 关键修改1: 使用 rawurlencode 代替 urlencode -->
                    <li onclick="playMusic('<?= htmlspecialchars(rawurlencode($music['path'])) ?>', '<?= htmlspecialchars($music['name']) ?>')">
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

        async function playMusic(encodedPath, name) {
            try {
                const decodedPath = decodeURIComponent(encodedPath);
                
                // 关键修改2: 带 Referer 的动态加载
                const response = await fetch(decodedPath, {
                    headers: {
                        'Referer': 'https://bbt.free.nf/' // 与主机域名一致
                    }
                });

                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                
                // 验证内容类型
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('audio/mpeg')) {
                    throw new Error('Invalid content type: ' + contentType);
                }

                const blob = await response.blob();
                const blobUrl = URL.createObjectURL(blob);
                
                player.src = blobUrl;
                player.play();

                // 更新界面状态
                currentSong = name;
                document.getElementById('now-playing').textContent = `正在播放：${currentSong}`;
                updatePlaylistHighlight(name);

            } catch (error) {
                console.error('播放错误:', error);
                handlePlaybackError(error);
            }
        }

        // 播放列表高亮更新
        function updatePlaylistHighlight(name) {
            document.querySelectorAll('.playlist li').forEach(item => {
                item.style.background = item.textContent.includes(name) ? '#e3f2fd' : '#f8f9fa';
            });
        }

        // 增强错误处理
        function handlePlaybackError(error) {
            const errorMap = {
                'Invalid content type': '服务器返回了无效的文件类型',
                'Failed to fetch': '网络连接失败，请检查网络',
                'HTTP error! status: 403': '访问被拒绝（可能触发防盗链）',
                'default': '无法播放该音乐，请检查文件地址'
            };

            const errorMsg = Object.entries(errorMap).find(([key]) => 
                error.message.includes(key)
            )?.[1] || errorMap.default;

            document.getElementById('now-playing').textContent = `播放失败：${errorMsg}`;
            alert(errorMsg);
        }

        // 自动下一曲（保持原有逻辑）
        player.addEventListener('ended', () => {
            const currentIndex = [...document.querySelectorAll('.playlist li')]
                .findIndex(item => item.textContent.includes(currentSong));
            
            if (currentIndex >= 0 && currentIndex < <?= count($musicFiles) - 1 ?>) {
                document.querySelectorAll('.playlist li')[currentIndex + 1].click();
            }
        });

        // 错误监听（补充内容类型错误处理）
        player.addEventListener('error', (e) => {
            const error = player.error;
            console.error('播放器错误:', error);
            let message = '未知错误';
            
            switch(error.code) {
                case MediaError.MEDIA_ERR_SRC_NOT_SUPPORTED:
                    message = '不支持的音频格式或内容类型错误';
                    break;
                case MediaError.MEDIA_ERR_NETWORK:
                    message = '网络错误，请检查连接';
                    break;
                case MediaError.MEDIA_ERR_DECODE:
                    message = '音频解码错误，文件可能已损坏';
                    break;
            }
            
            document.getElementById('now-playing').textContent = `播放失败：${message}`;
        });
    </script>
</body>
</html>