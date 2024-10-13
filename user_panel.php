<?php
include 'db.php';
session_start();

// 检查用户是否登录
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];  // 获取用户名
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['join_room'])) {
        // 获取输入的聊天室名称和密码
        $room_name = trim($_POST['room_name']);
        $password = md5(trim($_POST['password'])); // 使用MD5加密密码

        // 检查聊天室是否存在
        $stmt = $pdo->prepare("SELECT id, password FROM chat_rooms WHERE name = ?");
        $stmt->execute([$room_name]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($room) {
            // 验证MD5加密的密码是否匹配
            if ($password === $room['password']) {
                // 跳转到该聊天室
                header("Location: chatroom.php?room_id=" . $room['id']);
                exit;
            } else {
                $message = '密码错误，请重试。';
            }
        } else {
            $message = '聊天室不存在，请检查名称。';
        }
    } elseif (isset($_POST['create_room'])) {
        // 创建新的聊天室
        $room_name = trim($_POST['room_name']);
        $password = md5(trim($_POST['password'])); // 使用MD5加密密码

        // 检查聊天室名称是否已存在
        $stmt = $pdo->prepare("SELECT id FROM chat_rooms WHERE name = ?");
        $stmt->execute([$room_name]);
        if ($stmt->rowCount() > 0) {
            $message = '该聊天室名称已存在，请选择其他名称。';
        } else {
            // 插入新的聊天室
            $stmt = $pdo->prepare("INSERT INTO chat_rooms (name, created_by, password) VALUES (?, ?, ?)");
            $stmt->execute([$room_name, $user_id, $password]);
            $new_room_id = $pdo->lastInsertId();

            // 跳转到新创建的聊天室
            header("Location: chatroom.php?room_id=$new_room_id");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户面板</title>
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
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5c6bc0;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        button:hover {
            background-color: #3949ab;
        }

        .btn-create {
            background-color: #4caf50;
        }

        .btn-create:hover {
            background-color: #388e3c;
        }

        .btn-manage {
            display: inline-block;
            padding: 12px 20px;
            background-color: #4caf50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-manage:hover {
            background-color: #388e3c;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        a.logout {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: white;
            background-color: #e53935;
            padding: 10px;
            border-radius: 4px;
        }

        a.logout:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>欢迎，<?= htmlspecialchars($username) ?>！</h2>

        <!-- 加入聊天室表单 -->
        <form method="POST">
            <input type="text" name="room_name" placeholder="输入聊天室名称" required>
            <input type="password" name="password" placeholder="输入密码" required>
            <button type="submit" name="join_room">加入聊天室</button>
        </form>

        <!-- 创建聊天室表单 -->
        <form method="POST">
            <input type="text" name="room_name" placeholder="输入聊天室名称" required>
            <input type="password" name="password" placeholder="设置密码" required>
            <button type="submit" name="create_room" class="btn-create">创建新聊天室</button>
        </form>

        <!-- 管理聊天室按钮 -->
        <a href="manage_rooms.php" class="btn-manage">管理我的聊天室</a>

        <!-- 退出登录按钮 -->
        <a href="logout.php" class="logout">退出登录</a>

        <!-- 显示提示信息 -->
        <?php if ($message): ?>
            <p style="color: red;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
