// main.go
package main

import (
	"log"
	"net/http"
	"github.com/gorilla/websocket"
)

var upgrader = websocket.Upgrader{
	CheckOrigin: func(r *http.Request) bool { return true },
}

var clients = make(map[*websocket.Conn]bool) // 存储活跃连接

func handleWebSocket(w http.ResponseWriter, r *http.Request) {
	conn, err := upgrader.Upgrade(w, r, nil)
	if err != nil {
		log.Println("WebSocket upgrade failed:", err)
		return
	}
	defer conn.Close()

	clients[conn] = true // 注册新客户端

	for {
		_, msg, err := conn.ReadMessage()
		if err != nil {
			log.Println("Client disconnected:", err)
			delete(clients, conn)
			break
		}
		// 广播消息给所有客户端
		for client := range clients {
			if err := client.WriteMessage(websocket.TextMessage, msg); err != nil {
				log.Println("Broadcast failed:", err)
			}
		}
	}
}

func main() {
	http.HandleFunc("/ws", handleWebSocket)
	log.Println("Server started on :8080")
	log.Fatal(http.ListenAndServe(":8080", nil))
}