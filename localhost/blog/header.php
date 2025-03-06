<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的博客</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* 新增菜单按钮样式 */
        .menu-toggle {
            display: none;
            cursor: pointer;
            padding: 10px;
            position: absolute;
            right: 20px;
            top: 20px;
            z-index: 1000;
        }

        .menu-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background: #333;
            margin: 5px 0;
            transition: 0.3s;
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            nav ul {
                display: none;
                flex-direction: column;
                width: 100%;
                position: absolute;
                top: 60px;
                left: 0;
                background: linear-gradient(135deg, #c0c0c0, #ffffff);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                border-radius: 0 0 15px 15px;
            }

            nav li {
                margin: 10px 0;
                text-align: center;
            }

            .menu-toggle {
                display: block;
            }

            nav.active ul {
                display: flex;
            }

            /* 汉堡菜单动画 */
            .menu-toggle.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }

            .menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }

            .menu-toggle.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }
        }
    </style>
</head>
<body>
<!-- 汉堡菜单按钮 -->
<div class="menu-toggle" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
</div>

<nav>
    <ul>
        <?php if (isset($_SESSION['username'])): ?>
            <li>欢迎，<?= $_SESSION['username'] ?></li>
            <li><a href="blog_logout.php">退出</a></li>
        <?php else: ?>
            <li><a href="blog_index.php">首页</a></li>
            <li><a href="https://bbt.onrender.com/file.php">简易网盘</a></li>
            <li><a href="blog_profile.php">个人信息</a></li>
            <li><a href="blog_login.php">登录</a></li>
            <li><a href="blog_register.php">注册</a></li>
        <?php endif; ?>
    </ul>
</nav>

<script>
// 菜单切换逻辑
function toggleMenu() {
    const nav = document.querySelector('nav');
    const toggle = document.querySelector('.menu-toggle');
    nav.classList.toggle('active');
    toggle.classList.toggle('active');
    
    // 点击外部区域关闭菜单
    if (nav.classList.contains('active')) {
        document.addEventListener('click', closeMenuOnClickOutside);
    } else {
        document.removeEventListener('click', closeMenuOnClickOutside);
    }
}

function closeMenuOnClickOutside(event) {
    const nav = document.querySelector('nav');
    const toggle = document.querySelector('.menu-toggle');
    
    if (!nav.contains(event.target) && !toggle.contains(event.target)) {
        nav.classList.remove('active');
        toggle.classList.remove('active');
        document.removeEventListener('click', closeMenuOnClickOutside);
    }
}
</script>
