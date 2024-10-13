<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $response = [];

    // 检查用户名是否已经存在
    $stmt = $pdo->prepare("SELECT * FROM chat_users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        // 用户名已经存在
        $response['status'] = 'error';
        $response['message'] = '用户名已存在，请选择其他用户名。';
    } else {
        // 插入新用户
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO chat_users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$username, $hashedPassword])) {
            $response['status'] = 'success';
            $response['message'] = '注册成功！请登录。';
        } else {
            $response['status'] = 'error';
            $response['message'] = '注册失败，请稍后重试。';
        }
    }

    // 返回 JSON 响应
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户注册</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #5c6bc0;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%; /* 确保按钮充满整个容器，防止文字换行 */
            font-size: 16px;
            text-align: center; /* 确保文本水平居中 */
            display: inline-block; /* 让按钮保持 inline-block */
        }

        button:hover {
            background-color: #3949ab;
        }

        #message {
            margin-top: 15px;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            color: #5c6bc0;
            text-decoration: none;
        }

        a:hover {
            color: #3949ab;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>注册</h2>
        <form id="registerForm" method="POST">
            <input type="text" name="username" id="username" placeholder="用户名" required>
            <input type="password" name="password" id="password" placeholder="密码" required>
            <button type="submit">注册</button>
        </form>
        <div id="message"></div> <!-- 用于显示注册的提示信息 -->
        <a href="login.php">已经有账户？登录</a>
    </div>
</body>
</html>

