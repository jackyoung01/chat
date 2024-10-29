<?php
session_start();
include 'db.php';

// 获取 `room_id`，默认为1（或者根据前端传来的参数）
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 1;

// 定义活动时间窗口为5分钟
$five_minutes_ago = date('Y-m-d H:i:s', strtotime('-5 minutes'));

// 查询该 `room_id` 下过去5分钟内活跃的用户
$stmt = $pdo->prepare("SELECT username FROM chat_users WHERE room_id = ? AND last_active >= ?");
$stmt->execute([$room_id, $five_minutes_ago]);
$online_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$online_count = count($online_users);

// 检查是否为 JSON 请求
$is_json_request = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;

if ($is_json_request) {
    // 返回 JSON 数据
    header('Content-Type: application/json');
    echo json_encode([
        'online_count' => $online_count,
        'online_users' => $online_users
    ]);
} else {
    // 返回 HTML 页面
    ?>
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>在线用户</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f4f4f9;
            }
            .container {
                background-color: #fff;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 400px;
                width: 100%;
            }
            h2 {
                color: #333;
                margin-bottom: 20px;
            }
            ul {
                list-style-type: none;
                padding: 0;
            }
            li {
                background-color: #e3f2fd;
                margin: 5px 0;
                padding: 10px;
                border-radius: 5px;
                color: #333;
            }
            .online-count {
                font-size: 1.2em;
                font-weight: bold;
                color: #007bff;
            }
            .back-button {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                font-size: 16px;
                color: white;
                background-color: #007bff;
                border-radius: 4px;
                text-decoration: none;
                transition: background-color 0.3s;
            }
            .back-button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>当前在线用户数：<span class="online-count"><?= $online_count ?></span></h2>
            <ul>
                <?php if ($online_count > 0): ?>
                    <?php foreach ($online_users as $user): ?>
                        <li><?= htmlspecialchars($user['username']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>暂无在线用户</li>
                <?php endif; ?>
            </ul>
            <!-- 返回聊天室按钮 -->
            <a href="chatroom.php?room_id=<?= $room_id ?>" class="back-button">返回聊天室</a>
        </div>
    </body>
    </html>
    <?php
}
?>
