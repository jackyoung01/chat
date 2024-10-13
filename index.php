<?php
session_start();

// 检查用户是否已经登录
if (isset($_SESSION['user_id'])) {
    header('Location: chatroom.php');  // 如果用户已登录，直接跳转到聊天室
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线聊天室</title>
    <link rel="stylesheet" href="style.css"> <!-- 引用CSS文件 -->
</head>
<body>
    <div class="container">
        <h1>欢迎来到在线聊天室</h1>
        <p>请先登录或注册后再进入聊天室。</p>
        <a href="login.php" class="btn">登录</a>
        <a href="register.php" class="btn">注册</a>
    </div>
</body>
</html>
