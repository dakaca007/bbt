<!DOCTYPE html>
<html>
<head>
    <title>Welcome to My Page</title>
</head>
<body>
    <h1>Hello, World!</h1>
    <p>This is a simple HTML page served by the container.</p>
<?php
echo "111";
?>
<?php
// 发送GET请求到Flask服务器
$url = 'http://localhost:8080';
$response = file_get_contents($url);

// 输出Flask服务器的响应
echo $response;
?>

</body>
</html>
