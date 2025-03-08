<?php 
// index.php  (兼容PHP8.0+)
header('Content-Type: text/html; charset=utf-8');
header('X-Accel-Buffering: no'); // 禁用缓冲提升流媒体性能 
 
$api_url = "https://api.kuleu.com/api/MP4_xiaojiejie?type=json"; 
 
class VideoAPI {
    private static $cache = [];
 
    public static function getVideo($count = 3) {
        if(empty(self::$cache)) {
            for($i=0; $i<$count; $i++){
                $response = file_get_contents(self::$api_url);
                self::$cache[] = json_decode($response, true);
            }
        }
        return array_shift(self::$cache);
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- 安卓音频策略优化 -->
    <meta name="mobile-web-app-capable" content="yes">
    <title>短视频播放器-2025优化版</title>
    <style>
        :root {
            --primary-color: #ff6b6b;
            --progress-height: 3px;
        }
        #video-container {
            height: 100vh;
            overflow: hidden;
            scroll-snap-type: y mandatory;
            background: #000;
        }
        .video-wrapper {
            height: 100vh;
            position: relative;
            opacity: 0;
            transition: opacity 0.5s, transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02); /* 消除边框间隙 */
        }
        .progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: var(--progress-height);
            background: rgba(255,107,107,0.3);
            width: 100%;
            z-index: 10;
        }
        .progress-bar::after {
            content: '';
            display: block;
            width: var(--progress);
            height: 100%;
            background: var(--primary-color);
            transition: width 0.3s linear;
        }
    </style>
</head>
<body>
    <div id="video-container">
        <?php for($i=0; $i<2; $i++): // 预加载两个视频 ?>
        <div class="video-wrapper" data-state="<?= $i === 0 ? 'active' : 'pending' ?>">
            <video <?= $i === 0 ? 'autoplay' : '' ?> muted playsinline>
                <source src="<?= VideoAPI::getVideo()['mp4_video'] ?>" type="video/mp4">
            </video>
            <div class="progress-bar"></div>
        </div>
        <?php endfor; ?>
    </div>
 
    <script>
    class VideoPlayer {
        constructor() {
            this.container  = document.getElementById('video-container'); 
            this.currentIndex  = 0;
            this.isSwiping  = false;
            this.touchStartY  = 0;
            this.initEventListeners(); 
            this.audioContext  = new (window.AudioContext || window.webkitAudioContext)(); 
            this.initAudioAnalyser(); 
        }
 
        initEventListeners() {
            // 触摸事件 
            this.container.addEventListener('touchstart',  e => {
                this.touchStartY  = e.touches[0].clientY; 
            }, { passive: true });
 
            this.container.addEventListener('touchend',  e => {
                const deltaY = e.changedTouches[0].clientY  - this.touchStartY; 
                if(Math.abs(deltaY)  > 50 && !this.isSwiping)  {
                    this.handleSwipe(deltaY  > 0 ? 'down' : 'up');
                }
            });
 
            // 视频事件 
            document.querySelectorAll('video').forEach(video  => {
                video.addEventListener('ended',  () => this.loadNextVideo()); 
                video.addEventListener('timeupdate',  e => this.updateProgressBar(e.target)); 
            });
 
            // 音频交互解锁 
            document.addEventListener('click',  () => {
                this.unmuteAllVideos(); 
            }, { once: true });
        }
 
        async handleSwipe(direction) {
            this.isSwiping  = true;
            const currentVideo = this.getCurrentVideo(); 
            
            // 滑动动画 
            this.container.style.transform  = `translateY(${direction === 'down' ? '100%' : '-100%'})`;
            await new Promise(resolve => setTimeout(resolve, 500));
            
            // 加载新视频 
            const newVideo = await this.fetchNewVideo(); 
            this.insertVideoElement(newVideo,  direction);
            
            // 重置布局 
            this.container.style.transform  = '';
            this.isSwiping  = false;
            currentVideo.remove(); 
        }
 
        async fetchNewVideo() {
            const res = await fetch('api_proxy.php?_t='  + Date.now()); 
            return res.json(); 
        }
 
        insertVideoElement(videoData, direction) {
            const wrapper = document.createElement('div'); 
            wrapper.className  = 'video-wrapper';
            wrapper.innerHTML  = `
                <video autoplay muted playsinline>
                    <source src="${videoData.mp4_video}"  type="video/mp4">
                </video>
                <div class="progress-bar"></div>
            `;
            direction === 'down' 
                ? this.container.prepend(wrapper)  
                : this.container.append(wrapper); 
            
            setTimeout(() => wrapper.style.opacity  = '1', 50);
        }
 
        updateProgressBar(video) {
            const progress = (video.currentTime  / video.duration)  * 100;
            video.parentElement.querySelector('.progress-bar').style.setProperty('--progress',  `${progress}%`);
        }
 
        unmuteAllVideos() {
            document.querySelectorAll('video').forEach(v  => {
                v.muted  = false;
                v.volume  = 0.5;
            });
        }
 
        initAudioAnalyser() {
            // 音频可视化扩展接口 
            const analyser = this.audioContext.createAnalyser(); 
            analyser.fftSize  = 256;
            // ...可扩展音频可视化逻辑 
        }
    }
 
    // 初始化播放器 
    const player = new VideoPlayer();
 
    // 移动端陀螺仪增强（可选）
    if(window.DeviceOrientationEvent) {
        window.addEventListener('deviceorientation',  e => {
            player.container.style.transform  = `rotate(${e.gamma  * 0.3}deg)`;
        }, true);
    }
    </script>
</body>
</html>
