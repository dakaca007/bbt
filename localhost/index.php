<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>纯JS短视频播放器</title>
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
            position: relative;
        }

        .video-wrapper {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .video-wrapper.active {
            opacity: 1;
            z-index: 2;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #000;
        }

        .progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: var(--progress-height);
            background: rgba(255,255,255,0.3);
            z-index: 10;
        }

        .progress-inner {
            height: 100%;
            background: var(--primary-color);
            width: 0%;
            transition: width 0.1s linear;
        }

        /* 加载提示 */
        .loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div id="video-container"></div>
    <div class="loading">正在加载视频...</div>

<script>
class VideoPlayer {
    constructor() {
        this.container = document.getElementById('video-container');
        this.loading = document.querySelector('.loading');
        this.currentIndex = 0;
        this.videoQueue = [];
        this.isSwiping = false;
        this.touchStartY = 0;
        
        // 配置项
        this.config = {
            preloadCount: 2,     // 预加载视频数
            apiUrl: 'https://api.kuleu.com/api/MP4_xiaojiejie?type=json',
            fallbackVideo: 'https://example.com/fallback.mp4'
        }

        this.init();
    }

    async init() {
        // 初始加载
        await this.loadVideos(this.config.preloadCount);
        this.initEventListeners();
        this.playCurrentVideo();
    }

    async loadVideos(count = 1) {
        try {
            this.showLoading();
            const requests = Array.from({ length: count }, () => 
                fetch(this.config.apiUrl).then(res => res.json())
            );
            const newVideos = await Promise.all(requests);
            this.videoQueue.push(...newVideos);
            this.renderVideos();
            this.hideLoading();
        } catch (error) {
            console.error('视频加载失败:', error);
            this.loadFallbackVideo();
        }
    }

    renderVideos() {
        this.videoQueue.forEach((video, index) => {
            if (!document.getElementById(`video-${index}`)) {
                const wrapper = this.createVideoElement(video, index);
                this.container.appendChild(wrapper);
            }
        });
    }

    createVideoElement(videoData, index) {
        const wrapper = document.createElement('div');
        wrapper.className = `video-wrapper ${index === 0 ? 'active' : ''}`;
        wrapper.id = `video-${index}`;

        const video = document.createElement('video');
        video.muted = true;
        video.playsInline = true;
        
        const source = document.createElement('source');
        source.src = videoData.mp4_video || this.config.fallbackVideo;
        source.type = 'video/mp4';

        const progressBar = document.createElement('div');
        progressBar.className = 'progress-bar';
        progressBar.innerHTML = '<div class="progress-inner"></div>';

        video.addEventListener('loadeddata', () => {
            wrapper.style.opacity = '1';
            if (index === 0) video.play();
        });

        video.addEventListener('error', () => {
            source.src = this.config.fallbackVideo;
            video.load();
        });

        video.addEventListener('timeupdate', () => {
            const progress = (video.currentTime / video.duration) * 100;
            progressBar.querySelector('.progress-inner').style.width = `${progress}%`;
        });

        video.addEventListener('ended', () => this.playNextVideo());

        wrapper.appendChild(video);
        wrapper.appendChild(progressBar);
        video.appendChild(source);

        return wrapper;
    }

    initEventListeners() {
        let touchStartY = 0;
        const container = this.container;

        // 触摸事件处理
        container.addEventListener('touchstart', e => {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        container.addEventListener('touchend', e => {
            const deltaY = e.changedTouches[0].clientY - touchStartY;
            if (Math.abs(deltaY) > 50 && !this.isSwiping) {
                this.handleSwipe(deltaY > 0 ? 'down' : 'up');
            }
        });

        // 点击解静音
        document.addEventListener('click', () => {
            this.unmuteAllVideos();
        }, { once: true });
    }

    async handleSwipe(direction) {
        if (this.isSwiping) return;
        this.isSwiping = true;

        // 预加载新视频
        if (this.videoQueue.length <= 1) {
            await this.loadVideos(1);
        }

        const currentVideo = this.getCurrentVideo();
        const newIndex = direction === 'down' ? this.currentIndex + 1 : this.currentIndex - 1;

        if (newIndex >= 0 && newIndex < this.videoQueue.length) {
            this.playVideo(newIndex);
            this.currentIndex = newIndex;
        }

        this.isSwiping = false;
    }

    playVideo(index) {
        const currentWrapper = document.querySelector('.video-wrapper.active');
        const newWrapper = document.getElementById(`video-${index}`);
        
        if (currentWrapper) currentWrapper.classList.remove('active');
        newWrapper.classList.add('active');
        
        const video = newWrapper.querySelector('video');
        video.currentTime = 0;
        video.play();
    }

    playNextVideo() {
        const nextIndex = this.currentIndex + 1;
        if (nextIndex < this.videoQueue.length) {
            this.playVideo(nextIndex);
            this.currentIndex = nextIndex;
        } else {
            this.loadVideos(1).then(() => this.playVideo(nextIndex));
        }
    }

    getCurrentVideo() {
        return document.getElementById(`video-${this.currentIndex}`)?.querySelector('video');
    }

    unmuteAllVideos() {
        document.querySelectorAll('video').forEach(video => {
            video.muted = false;
            video.volume = 0.5;
        });
    }

    showLoading() {
        this.loading.style.display = 'block';
    }

    hideLoading() {
        this.loading.style.display = 'none';
    }

    loadFallbackVideo() {
        if (!this.videoQueue.length) {
            this.videoQueue.push({ mp4_video: this.config.fallbackVideo });
            this.renderVideos();
        }
    }
}

// 初始化播放器
const player = new VideoPlayer();

// 兼容自动播放策略
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const firstVideo = document.querySelector('video');
        if (firstVideo && firstVideo.paused) {
            firstVideo.play().catch(() => {
                const playButton = document.createElement('div');
                playButton.textContent = '点击播放';
                playButton.style.cssText = `
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    padding: 12px 24px;
                    background: #ff6b6b;
                    color: white;
                    border-radius: 24px;
                    cursor: pointer;
                    z-index: 100;
                `;
                playButton.onclick = () => {
                    document.querySelectorAll('video').forEach(v => v.play());
                    playButton.remove();
                };
                document.body.appendChild(playButton);
            });
        }
    }, 1000);
});
</script>
</body>
</html>