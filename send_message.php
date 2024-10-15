<?php
include 'db.php';
session_start();

// 如果用户未登录，返回错误消息
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => '用户未登录']);
    exit;
}

$user_id = $_SESSION['user_id'];
$room_id = isset($_POST['room_id']) ? (int)$_POST['room_id'] : 1;  // 默认聊天室 ID 为 1

// 插入新消息到数据库
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']); // 清除多余空格

    // 防止空消息发送
    if (!empty($message)) {
        try {
            // 预处理插入语句
            $stmt = $pdo->prepare("INSERT INTO chat_messages (user_id, room_id, message, created_at) VALUES (?, ?, ?, NOW())");
            
            // 执行插入操作
            if ($stmt->execute([$user_id, $room_id, $message])) {
                echo json_encode(['status' => 'success', 'message' => '消息已发送']);
            } else {
                echo json_encode(['status' => 'error', 'message' => '消息发送失败']);
            }
        } catch (PDOException $e) {
            // 捕获数据库错误并返回 JSON 错误消息
            echo json_encode(['status' => 'error', 'message' => '数据库错误: ' . $e->getMessage()]);
        }
    } else {
        // 消息为空时返回错误
        echo json_encode(['status' => 'error', 'message' => '不能发送空消息']);
    }
} else {
    // 如果请求方式不是 POST 或没有提供消息，返回错误
    echo json_encode(['status' => 'error', 'message' => '无效的请求']);
}
?>
