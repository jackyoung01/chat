<?php
include '../db.php';
session_start();

// 检查管理员是否登录
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// 获取聊天室ID
$room_id = (int)$_GET['id'];

// 删除该聊天室的所有消息
$stmt = $pdo->prepare("DELETE FROM chat_messages WHERE room_id = ?");
$stmt->execute([$room_id]);

// 删除该聊天室
$stmt = $pdo->prepare("DELETE FROM chat_rooms WHERE id = ?");
if ($stmt->execute([$room_id])) {
    header('Location: index.php');  // 重定向到管理员首页
    exit;
} else {
    echo "删除聊天室失败，请稍后再试。";
}
?>
