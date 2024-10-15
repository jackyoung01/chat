<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $response = [];

    // 检查用户名和密码是否为空
    if (empty($username) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = '用户名和密码不能为空。';
    } else {
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
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #3949ab;
        }

        #message {
            margin-top: 15px;
            color: #f44336; /* 初始设为错误颜色，成功后修改颜色 */
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
        <form id="registerForm">
            <input type="text" name="username" id="username" placeholder="用户名" required>
            <input type="password" name="password" id="password" placeholder="密码" required>
            <button type="submit">注册</button>
        </form>
        <div id="message"></div> <!-- 用于显示注册的提示信息 -->
        <a href="login.php">已经有账户？登录</a>
    </div>

    <script>
        // 获取表单和消息元素
        const registerForm = document.getElementById('registerForm');
        const messageBox = document.getElementById('message');

        // 监听表单提交事件
        registerForm.addEventListener('submit', function(event) {
            event.preventDefault();  // 阻止默认的表单提交

            // 获取用户名和密码的值
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            // 清空之前的消息
            messageBox.textContent = '';

            // 简单的前端验证
            if (username === '' || password === '') {
                messageBox.textContent = '用户名和密码不能为空。';
                return;
            }

            // 使用 fetch API 发送表单数据到服务器
            fetch('register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                // 根据服务器返回的状态显示消息
                if (data.status === 'success') {
                    messageBox.style.color = 'green'; // 成功时显示绿色消息
                } else {
                    messageBox.style.color = 'red'; // 错误时显示红色消息
                }
                messageBox.textContent = data.message;
            })
            .catch(error => {
                messageBox.style.color = 'red';
                messageBox.textContent = '请求失败，请稍后重试。';
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
