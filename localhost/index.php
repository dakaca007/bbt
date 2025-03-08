<?php
// index.php 
header('Content-Type: text/html; charset=utf-8');
$api_url = "https://api.kuleu.com/api/MP4_xiaojiejie?type=json"; 

// 初始化时获取多个视频资源
function initVideos($count = 3) {
    $videos = [];
    for($i=0; $i<$count; $i++){
        $videos[] = json_decode(file_get_contents($GLOBALS['api_url']), true);
    }
    return $videos;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <style>
        #video-container {
            height: 100vh;
            overflow-y: hidden;
            scroll-snap-type: y mandatory;
        }
        .video-wrapper {
            height: 100vh;
            scroll-snap-align: start;
            position: relative;
            transition: transform 0.5s;
        }
        video {
            width: 100%; 
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div id="video-container">
        <?php foreach(initVideos(3) as $video): ?>
        <div class="video-wrapper" data-video="<?= htmlspecialchars($video['mp4_video']) ?>">
            <video controls autoplay muted playsinline>
                <source src="<?= $video['mp4_video'] ?>" type="video/mp4">
            </video>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
    // 播放状态管理
    class VideoPlayer {
        constructor() {
            this.container  = document.getElementById('video-container'); 
            this.currentIndex  = 0;
            this.isSwiping  = false;
            this.initSwipe(); 
            this.initAutoPause(); 
        }

        initSwipe() {
            let startY;
            
            this.container.addEventListener('touchstart',  e => {
                startY = e.touches[0].clientY; 
            }, { passive: true });

            this.container.addEventListener('touchend',  e => {
                const deltaY = e.changedTouches[0].clientY  - startY;
                if(Math.abs(deltaY)  > 50) {
                    this.switchVideo(deltaY  > 0 ? 'prev' : 'next');
                }
            });
        }

        async switchVideo(direction) {
            if(this.isSwiping)  return;
            this.isSwiping  = true;
            
            // 预加载下个视频
            const newVideo = await this.fetchVideo(); 
            
            // 动态插入节点
            const wrapper = this.createVideoWrapper(newVideo); 
            
            // 执行滑动动画
            this.container.style.transform  = `translateY(${direction === 'next' ? '-' : ''}100%)`;
            
            setTimeout(() => {
                // 移除旧节点
                direction === 'next' 
                    ? this.container.firstChild.remove() 
                    : this.container.lastChild.remove(); 
                
                // 重置位置
                this.container.style.transform  = '';
                this.isSwiping  = false;
            }, 500);
        }

        createVideoWrapper(videoData) {
            const wrapper = document.createElement('div'); 
            wrapper.className  = 'video-wrapper';
            wrapper.innerHTML  = `
                <video controls autoplay muted playsinline>
                    <source src="${videoData.mp4_video}"  type="video/mp4">
                </video>
            `;
            return wrapper;
        }

        async fetchVideo() {
            const res = await fetch('api_proxy.php'); 
            return res.json(); 
        }

        initAutoPause() {
            document.addEventListener('visibilitychange',  () => {
                [...this.container.querySelectorAll('video')] 
                    .forEach(v => v.pause()); 
            });
        }
    }

    // 初始化播放器
    new VideoPlayer();
    </script>
</body>
</html>
