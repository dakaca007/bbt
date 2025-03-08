<?php
// index.php 
header('Content-Type: text/html; charset=utf-8');
$api_url = "https://api.kuleu.com/api/MP4_xiaojiejie?type=json"; 

function getVideoData() {
    global $api_url;
    $response = file_get_contents($api_url);
    return json_decode($response, true);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>PHP短视频演示</title>
    <style>
        #video-container { height: 100vh; overflow: hidden; }
        .video-wrapper { position: relative; height: 100%; }
        video { width: 100%; height: 100%; object-fit: cover; }
    </style>
</head>
<body>
    <div id="video-container">
        <?php for($i=0; $i<5; $i++): // 模拟多视频加载 ?>
        <div class="video-wrapper">
            <video controls autoplay muted loop>
                <source src="<?= getVideoData()['mp4_video'] ?>" type="video/mp4">
            </video>
            <div class="action-btns">
                <button onclick="likeVideo(this)">❤️ 点赞</button>
            </div>
        </div>
        <?php endfor; ?>
    </div>

    <script>
    // 实现滑动切换
    let startY;
    const container = document.getElementById('video-container'); 
    
    container.addEventListener('touchstart',  e => {
        startY = e.touches[0].clientY; 
    });

    container.addEventListener('touchend',  e => {
        const endY = e.changedTouches[0].clientY; 
        if(startY - endY > 50) {
            loadNewVideo('down');
        } else if(endY - startY > 50) {
            loadNewVideo('up');
        }
    });

    async function loadNewVideo(direction) {
        // AJAX加载新视频（需另建api_proxy.php 处理跨域）
        const response = await fetch('api_proxy.php'); 
        const data = await response.json(); 
        
        const videoElement = `<video controls autoplay>
            <source src="${data.mp4_video}"  type="video/mp4">
        </video>`;
        
        if(direction === 'down') {
            container.insertAdjacentHTML('beforeend',  videoElement);
        } else {
            container.insertAdjacentHTML('afterbegin',  videoElement);
        }
    }
    </script>
</body>
</html>
