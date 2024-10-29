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
            width: 600px;
            text-align: center;
        }

        #chatbox {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            max-height: 500px;
            height: 400px;
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

        .chat-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
        }

        .input-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .message-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .emoji-button {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        .emoji-button:hover {
            color: #007bff;
        }

        .action-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .image-input {
            display: none;
        }

        .image-upload-label {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .image-upload-label:hover {
            background-color: #0056b3;
        }

        .send-button, .view-online-users {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .send-button:hover, .view-online-users:hover {
            background-color: #0056b3;
        }

        #emojiPicker {
            display: none;
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 300px;
            max-height: 200px;
            overflow-y: auto;
        }

        #emojiPicker span {
            cursor: pointer;
            font-size: 24px;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
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
        
        .online-users {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
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
        <form id="messageForm" enctype="multipart/form-data" class="chat-form">
            <div class="input-container">
                <input type="text" id="messageInput" name="message" placeholder="输入消息" required class="message-input">
                <button type="button" id="emojiButton" class="emoji-button">😀</button> <!-- Emoji 按钮 -->
                <div id="emojiPicker"></div> <!-- Emoji 选择器 -->
            </div>
            <div class="action-container">
                <input type="file" id="imageInput" name="image" accept="image/*" class="image-input">
                <label for="imageInput" class="image-upload-label">选择图片</label>
                <button type="submit" class="send-button">发送</button>
                <!-- 查看在线用户的按钮，添加 room_id 参数 -->
                <a href="online_users.php?room_id=<?= $room_id ?>" target="_blank" class="view-online-users">查看在线用户</a>

            </div>
        </form>

        <!-- 返回用户面板按钮 -->
        <a href="user_panel.php" class="back-to-panel">返回用户面板</a>

        <!-- 退出登录按钮 -->
        <a href="logout.php" class="logout">退出登录</a>
    </div>

    <!-- 使用 json_encode() 将 PHP 的 room_id 传递给 JavaScript -->
    <script>
        const roomId = <?= json_encode($room_id); ?>;

   // 获取在线用户数并更新页面
        async function updateOnlineUserCount() {
            try {
                // 向 online_users.php 发送请求，并带上 room_id 参数
                const response = await fetch(`online_users.php?room_id=${encodeURIComponent(roomId)}`);
                const data = await response.json();
                // 检查是否成功接收到数据并更新页面显示
                if (data.online_count !== undefined) {
                    document.getElementById('onlineUserCount').textContent = data.online_count;
                }
            } catch (error) {
                console.error('更新在线用户数失败:', error);
            }
        }

        // 定期发送“心跳”请求以更新用户在线状态
        async function sendHeartbeat() {
            try {
                await fetch('heartbeat.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `room_id=${encodeURIComponent(roomId)}`
                });
            } catch (error) {
                console.error('发送心跳请求失败:', error);
            }
        }

        // 页面加载时首次获取在线用户数并发送“心跳”
        updateOnlineUserCount();
        sendHeartbeat();

        // 每隔30秒更新在线用户数和发送“心跳”请求
        setInterval(() => {
            updateOnlineUserCount();
            sendHeartbeat();
        }, 30000);
    </script>

    <!-- 引入外部JS文件 -->
    <script src="src/js/chatroom.js"></script>
</body>
</html>
