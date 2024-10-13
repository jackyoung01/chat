<?php
include 'db.php';
session_start();

// 检查用户是否登录，如果没有登录，重定向到登录页面
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];  // 获取用户名
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 1;  // 获取聊天室ID，默认为1

// 获取聊天室名称
$stmt = $pdo->prepare("SELECT name FROM chat_rooms WHERE id = ?");
$stmt->execute([$room_id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

// 检查是否找到聊天室
if (!$room) {
    echo "聊天室不存在！";
    exit;
}

$room_name = $room['name']; // 聊天室的名称

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
    <title><?= htmlspecialchars($room_name) ?></title> <!-- 显示聊天室名称作为页面标题 -->
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
            margin-bottom: 20px;
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

        .logout, .back-to-panel {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 16px;
            color: white;
        }

        .logout {
            background-color: #e53935;
        }

        .logout:hover {
            background-color: #d32f2f;
        }

        .back-to-panel {
            background-color: #5c6bc0;
        }

        .back-to-panel:hover {
            background-color: #3949ab;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?= htmlspecialchars($room_name) ?></h2> <!-- 显示聊天室名称 -->

        <!-- 显示聊天消息 -->
        <div id="chatbox">
            <?php while ($row = $messages->fetch(PDO::FETCH_ASSOC)): ?>
                <p><strong><?= htmlspecialchars($row['username']) ?>:</strong> <?= htmlspecialchars($row['message']) ?> <em>(<?= $row['created_at'] ?>)</em></p>
            <?php endwhile; ?>
        </div>

        <!-- 发送消息的表单 -->
        <form id="messageForm" method="POST">
            <input type="text" id="messageInput" name="message" placeholder="输入消息" required>
            <button type="submit">发送</button>
        </form>

        <!-- 返回用户面板按钮 -->
        <a href="user_panel.php" class="back-to-panel">返回用户面板</a>

        <!-- 退出登录按钮 -->
        <a href="logout.php" class="logout">退出登录</a>
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

            // 使用 AJAX 发送消息到 send_message.php
            fetch('send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'message=' + encodeURIComponent(message) + '&room_id=' + encodeURIComponent(<?= $room_id ?>)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // 清空输入框
                    messageInput.value = '';

                    // 手动刷新消息列表
                    fetchMessages();
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
        });

        // 自动加载最新消息
        function fetchMessages() {
            fetch('fetch_messages.php?room_id=<?= $room_id ?>')
                .then(response => response.json())
                .then(data => {
                    const chatbox = document.getElementById('chatbox');
                    chatbox.innerHTML = '';  // 清空现有消息

                    data.forEach(message => {
                        const p = document.createElement('p');
                        p.innerHTML = `<strong>${message.username}:</strong> ${message.message} <em>(${message.created_at})</em>`;
                        chatbox.appendChild(p);
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
