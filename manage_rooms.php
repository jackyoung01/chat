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

// 查询用户创建的聊天室
$stmt = $pdo->prepare("SELECT * FROM chat_rooms WHERE created_by = ?");
$stmt->execute([$user_id]);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$message = '';

// 处理修改聊天室名称
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_room'])) {
    $room_id = (int)$_POST['room_id'];
    $new_room_name = trim($_POST['room_name']);

    // 更新聊天室名称
    $stmt = $pdo->prepare("UPDATE chat_rooms SET name = ? WHERE id = ? AND created_by = ?");
    if ($stmt->execute([$new_room_name, $room_id, $user_id])) {
        $message = "聊天室名称已更新。";
    } else {
        $message = "更新失败，请稍后再试。";
    }
}

// 处理删除聊天室
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_room'])) {
    $room_id = (int)$_POST['room_id'];

    // 删除聊天室的所有消息
    $stmt = $pdo->prepare("DELETE FROM chat_messages WHERE room_id = ?");
    $stmt->execute([$room_id]);

    // 删除聊天室
    $stmt = $pdo->prepare("DELETE FROM chat_rooms WHERE id = ? AND created_by = ?");
    if ($stmt->execute([$room_id, $user_id])) {
        $message = "聊天室已删除。";
    } else {
        $message = "删除失败，请稍后再试。";
    }
}

// 处理修改密码
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $room_id = (int)$_POST['room_id'];
    $new_password = trim($_POST['new_password']);

    // 将新密码加密后更新
    $hashed_password = md5($new_password);
    $stmt = $pdo->prepare("UPDATE chat_rooms SET password = ? WHERE id = ? AND created_by = ?");
    if ($stmt->execute([$hashed_password, $room_id, $user_id])) {
        $message = "密码已成功更新。";
    } else {
        $message = "密码更新失败，请稍后再试。";
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理我的聊天室</title>
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

        .room-list {
            text-align: left;
            margin-bottom: 20px;
        }

        .room-list form {
            margin-bottom: 15px;
        }

        input[type="text"], input[type="password"] {
            width: calc(100% - 100px);
            padding: 8px;
            margin-right: 10px;
        }

        button {
            padding: 8px;
            background-color: #5c6bc0;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #3949ab;
        }

        .btn-delete {
            background-color: #e53935;
            margin-left: 10px;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        .btn-password {
            background-color: #4caf50;
            margin-left: 10px;
        }

        .btn-password:hover {
            background-color: #388e3c;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #5c6bc0;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #3949ab;
        }

        .message {
            margin-bottom: 20px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>管理我的聊天室</h2>

        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <div class="room-list">
            <?php foreach ($rooms as $room): ?>
                <form method="POST">
                    <input type="hidden" name="room_id" value="<?= htmlspecialchars($room['id']) ?>">
                    <input type="text" name="room_name" value="<?= htmlspecialchars($room['name']) ?>" required>
                    <button type="submit" name="edit_room">修改名称</button>
                    <button type="submit" name="delete_room" class="btn-delete">删除</button>
                </form>

                <!-- 修改密码表单 -->
                <form method="POST">
                    <input type="hidden" name="room_id" value="<?= htmlspecialchars($room['id']) ?>">
                    <input type="password" name="new_password" placeholder="新密码" required>
                    <button type="submit" name="change_password" class="btn-password">修改密码</button>
                </form>
            <?php endforeach; ?>
        </div>

        <a href="user_panel.php">返回用户面板</a>
    </div>
</body>
</html>
