<?php
include 'db.php';
session_start();

// 检查用户是否登录，如果没有登录，则返回错误
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => '用户未登录']);
    exit;
}

// 获取聊天室ID，默认为1
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 1;

// 获取当前聊天室中的消息，包括 is_ai 字段
$stmt = $pdo->prepare("SELECT m.message, u.username, m.created_at, m.is_ai 
                       FROM chat_messages m 
                       JOIN chat_users u ON m.user_id = u.id 
                       WHERE m.room_id = ? 
                       ORDER BY m.created_at ASC");
$stmt->execute([$room_id]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 处理消息内容，确保包含的 <img> 标签不会被转义
foreach ($messages as &$message) {
    // 将 is_ai 转换为整数类型
    $message['is_ai'] = (int)$message['is_ai'];

    // 处理消息内容，防止 HTML 特殊字符被转义
    $message['message'] = htmlspecialchars_decode($message['message'], ENT_QUOTES);
}

// 返回 JSON 格式的响应
header('Content-Type: application/json');
echo json_encode($messages);
?>
