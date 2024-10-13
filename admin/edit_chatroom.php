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

// 如果表单提交，更新聊天室名称和密码
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = trim($_POST['name']);
    $new_password = trim($_POST['password']);

    // 如果密码不为空，则加密并更新
    if (!empty($new_password)) {
        $hashed_password = md5($new_password); // 使用MD5加密密码
        $stmt = $pdo->prepare("UPDATE chat_rooms SET name = ?, password = ? WHERE id = ?");
        $success = $stmt->execute([$new_name, $hashed_password, $room_id]);
    } else {
        // 如果密码为空，只更新名称
        $stmt = $pdo->prepare("UPDATE chat_rooms SET name = ? WHERE id = ?");
        $success = $stmt->execute([$new_name, $room_id]);
    }

    // 根据执行结果判断是否成功
    if ($success) {
        header('Location: index.php');  // 更新成功后重定向到管理员首页
        exit;
    } else {
        echo "更新聊天室信息失败，请稍后再试。";
    }
}

// 获取当前聊天室信息
$stmt = $pdo->prepare("SELECT name FROM chat_rooms WHERE id = ?");
$stmt->execute([$room_id]);
$chatroom = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑聊天室</title>
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
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 450px;
            text-align: center;
        }

        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #5c6bc0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #3949ab;
        }

        a.btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #5c6bc0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 16px;
        }

        a.btn:hover {
            background-color: #3949ab;
        }

        .btn-back {
            background-color: #9e9e9e;
        }

        .btn-back:hover {
            background-color: #757575;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>编辑聊天室</h2>
        <form method="POST">
            <label for="name">聊天室名称:</label>
            <input type="text" name="name" value="hello" required>

            <label for="password">新密码 (留空表示不修改):</label>
            <input type="password" name="password" placeholder="输入新密码">

            <button type="submit">保存修改</button>
        </form>

        <!-- 返回管理页面按钮 -->
        <a href="index.php" class="btn btn-back">返回管理页面</a>
    </div>
</body>
</html>

