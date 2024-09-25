<?php
require dirname(__DIR__) . '/vendor/autoload.php'; // 引入 Composer 自动加载文件

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class LiveChat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage; // 存储连接客户端
    }

    public function onOpen(ConnectionInterface $conn) {
        // 存储连接
        $this->clients->attach($conn);
        echo "New connection: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Message from {$from->resourceId}: $msg\n";

        // 广播消息到所有其他连接
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // 移除连接
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new LiveChat()
        )
    ),
    8080 // 服务器监听的端口
);

$server->run();
