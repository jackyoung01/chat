<?php
include 'db.php';
session_start();

// 如果用户未登录，重定向到登录页面
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];  // 从session获取用户名
$room_id = 1;  // 假设聊天室 ID 为 1

// 插入新消息到数据库
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);

    // 防止空消息发送
    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO chat_messages (user_id, room_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $room_id, $message]);
    }
}

// 获取聊天室中的消息
$messages = $pdo->prepare("SELECT m.message, u.username, m.created_at 
                           FROM chat_messages m 
                           JOIN chat_users u ON m.user_id = u.id 
                           WHERE m.room_id = ? 
                           ORDER BY m.created_at ASC");
$messages->execute([$room_id]);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聊天室</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        #chatbox {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 15px;
            text-align: left;
        }
        #chatbox p {
            padding: 5px;
            margin: 0;
            border-bottom: 1px solid #ddd;
        }
        #chatbox p:last-child {
            border-bottom: none;
        }
        form input[type="text"] {
            width: calc(100% - 60px);
            margin-right: 10px;
            padding: 10px;
        }
        form button {
            width: 50px;
            padding: 10px;
            background-color: #5c6bc0;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #3949ab;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>聊天室</h2>

        <div id="chatbox">
            <?php while ($row = $messages->fetch(PDO::FETCH_ASSOC)): ?>
                <p><strong><?= htmlspecialchars($row['username']) ?>:</strong> <?= htmlspecialchars($row['message']) ?> <em>(<?= $row['created_at'] ?>)</em></p>
            <?php endwhile; ?>
        </div>

        <form id="messageForm" method="POST">
            <input type="text" id="messageInput" name="message" placeholder="输入消息" required>
            <button type="submit">发送</button>
        </form>
    </div>

    <script>
        document.getElementById('messageForm').addEventListener('submit', function(event) {
            event.preventDefault();  // 阻止表单默认提交行为

            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value;

            // 检查消息内容是否为空
            if (!message.trim()) {
                console.error("不能发送空消息！");
                return;
            }

            // 使用 AJAX 发送消息
            fetch('chatroom.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'message=' + encodeURIComponent(message)
            })
            .then(response => response.text())  // 将 response 改为 text 因为我们不返回 JSON
            .then(data => {
                // 清空输入框
                messageInput.value = '';

                // 手动刷新消息列表
                fetchMessages();
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
        });

        // 自动加载最新消息
        function fetchMessages() {
            fetch('fetch_messages.php')
                .then(response => response.json())
                .then(data => {
                    const chatbox = document.getElementById('chatbox');
                    chatbox.innerHTML = '';  // 清空现有消息

                    data.forEach(message => {
                        // 仅当用户名有效时才显示消息
                        if (message.username) {
                            const p = document.createElement('p');
                            p.innerHTML = `<strong>${message.username}:</strong> ${message.message} <em>(${message.created_at})</em>`;
                            chatbox.appendChild(p);
                        }
                    });

                    // 自动滚动到底部
                    chatbox.scrollTop = chatbox.scrollHeight;
                })
                .catch(error => console.error('Error fetching messages:', error));
        }

        // 定时每2秒获取一次新消息
        setInterval(fetchMessages, 2000);

        // 初始加载消息
        fetchMessages();
    </script>
</body>
</html>
