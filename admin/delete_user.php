<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_GET['id'];

// 删除用户
$stmt = $pdo->prepare("DELETE FROM chat_users WHERE id = ?");
$stmt->execute([$user_id]);

// 重定向回用户管理页面
header('Location: index.php');
exit;
?>
