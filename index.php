<?php
include 'db.php';
session_start();

// 处理登录请求
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $stmt = $pdo->prepare("SELECT * FROM chat_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: user_panel.php');
        exit;
    } else {
        $loginError = "登录失败！用户名或密码错误。";
    }
}

// 处理注册请求（用于AJAX）
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'register') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $response = [];

    if (empty($username) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = '用户名和密码不能为空。';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM chat_users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $response['status'] = 'error';
            $response['message'] = '用户名已存在，请选择其他用户名。';
        } else {
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
    <title>在线聊天室</title>
    <link rel="stylesheet" href="/src/css/index.css">
</head>
<body>
    <div class="ripple-container"></div> <!-- 水波效果容器 -->

    <!-- 左上角菜单按钮 -->
    <button class="menu-button" onclick="toggleSidebar()">☰ 菜单</button>

    <!-- 侧边栏 -->
    <div class="sidebar hidden" id="sidebar">
        <ul>
            <li><button onclick="showLogin()">登录</button></li>
            <li><button onclick="showRegister()">注册</button></li>
        </ul>
    </div>

    <!-- 中心内容区 -->
    <div class="container">
        <h1>在线聊天室平台</h1>

        <!-- 登录表单 -->
        <div id="loginForm" class="form <?= isset($loginError) ? '' : 'hidden' ?>">
            <h2>登录</h2>
            <form action="" method="POST">
                <input type="hidden" name="action" value="login">
                <input type="text" name="username" placeholder="用户名" required>
                <input type="password" name="password" placeholder="密码" required>
                <button type="submit">确认登录</button>
                <?php if (isset($loginError)) echo "<p class='error'>$loginError</p>"; ?>
            </form>
        </div>

        <!-- 注册表单 -->
        <div id="registerForm" class="form hidden">
            <h2>注册</h2>
            <form id="registerFormInner" method="POST">
                <input type="hidden" name="action" value="register">
                <input type="text" name="username" placeholder="用户名" required>
                <input type="password" name="password" placeholder="密码" required>
                <button type="button" onclick="registerUser()">确认注册</button>
                <p id="registerMessage" class="error"></p>
            </form>
        </div>
    </div>
    <div class="falling-leaves"></div>
    <script src="/src/js/ripple.js"></script> <!-- 水波效果 -->
    <script src="/src/js/toggleForm.js"></script> <!-- 切换登录注册表单 -->
    <script src="/src/js/registerHandler.js"></script> <!-- 异步注册处理 -->
    <script src="/src/js/fallingLeaves.js"></script> <!-- 落叶效果 -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        }
    </script>
</body>
</html>
