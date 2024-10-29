<?php
session_start();
include 'db.php';

// 检查用户是否已登录
if (isset($_SESSION['user_id']) && isset($_POST['room_id'])) {
    $user_id = $_SESSION['user_id'];
    $room_id = (int)$_POST['room_id'];

    // 更新用户最后活跃时间和当前房间ID
    $stmt = $pdo->prepare("UPDATE chat_users SET last_active = NOW(), room_id = ? WHERE id = ?");
    $stmt->execute([$room_id, $user_id]);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => '用户未登录或未指定房间ID']);
}
?>
