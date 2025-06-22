<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>PHP+Go 实时聊天</title>
    <script>
        const ws = new WebSocket("ws://localhost:8080/ws");
        
        ws.onmessage = (event) => {
            document.getElementById("chat").innerHTML += `<p>${event.data}</p>`;
        };

        function sendMessage() {
            const input = document.getElementById("message");
            ws.send(input.value);
            input.value = "";
        }
    </script>
</head>
<body>
    <div id="chat" style="height: 300px; overflow-y: scroll;"></div>
    <input type="text" id="message" placeholder="输入消息">
    <button onclick="sendMessage()">发送</button>
</body>
</html>