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
       width: 600px; /* 增大容器宽度 */
       text-align: center;
    }

    #chatbox {
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 8px;
        max-height: 500px; /* 增大聊天框的最大高度 */
        height: 400px; /* 固定聊天框高度 */
        overflow-y: auto;
        margin-bottom: 15px;
        text-align: left;
    }

    form input[type="text"] {
        width: calc(100% - 100px); /* 调整输入框宽度，适应更宽的容器 */
        margin-right: 10px;
        padding: 10px;
    }

        #chatbox p {
            padding: 5px;
            margin: 0;
            border-bottom: 1px solid #ddd;
        }

        #chatbox p:last-child {
            border-bottom: none;
        }

form button {
    width: 80px; /* 调整按钮宽度 */
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

#emojiPicker {
    display: none; /* 默认隐藏 */
    position: absolute; /* 使它浮动在其他内容之上 */
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000; /* 确保它位于页面的最上层 */
    width: 300px; /* 调整 emoji 选择器的宽度 */
    max-height: 200px; /* 调整 emoji 选择器的最大高度 */
    overflow-y: auto; /* 如果表情较多，允许滚动 */
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
        <form id="messageForm">
            <input type="text" id="messageInput" name="message" placeholder="输入消息" required>
            <button type="button" id="emojiButton">😀</button> <!-- Emoji 按钮 -->
            <div id="emojiPicker"></div> <!-- 这个容器将动态加载 emoji.html -->
            <button type="submit">发送</button>
        </form>

        <!-- 返回用户面板按钮 -->
        <a href="user_panel.php" class="back-to-panel">返回用户面板</a>

        <!-- 退出登录按钮 -->
        <a href="logout.php" class="logout">退出登录</a>
    </div>

    <!-- 使用 json_encode() 将 PHP 的 room_id 传递给 JavaScript -->
    <script>
        const roomId = <?= json_encode($room_id); ?>;
    </script>

    <!-- 引入外部JS文件 -->
    <script src="src/js/chatroom.js"></script>
</body>
</html>
