<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';
session_start();

// 检查用户是否登录，如果没有登录，则返回错误消息
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => '用户未登录']);
    exit;
}

// 获取聊天室ID，默认为1
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 1;
$last_id = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;

try {
    // 获取当前聊天室中，ID 大于 last_id 的消息
    $stmt = $pdo->prepare("SELECT m.id, m.message, u.username, m.created_at, m.is_ai 
                           FROM chat_messages m 
                           JOIN chat_users u ON m.user_id = u.id 
                           WHERE m.room_id = ? AND m.id > ? 
                           ORDER BY m.created_at ASC");
    $stmt->execute([$room_id, $last_id]);

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 处理消息内容，确保包含的 <img> 标签不会被转义
    foreach ($messages as &$message) {
        $message['is_ai'] = (int)$message['is_ai'];
        $message['message'] = htmlspecialchars_decode($message['message'], ENT_QUOTES);
    }

    // 返回 JSON 格式的响应
    header('Content-Type: application/json');
    echo json_encode($messages);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => '数据库错误: ' . $e->getMessage()]);
    exit;
}
?>
