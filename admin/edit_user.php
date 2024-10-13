<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_GET['id'];

// 获取用户信息
$user_stmt = $pdo->prepare("SELECT * FROM chat_users WHERE id = ?");
$user_stmt->execute([$user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "用户不存在";
    exit;
}

// 处理表单提交，更新用户密码
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = trim($_POST['password']);
    $hashed_password = md5($new_password);  // 使用MD5加密密码

    // 更新用户密码
    $stmt = $pdo->prepare("UPDATE chat_users SET password = ? WHERE id = ?");
    $stmt->execute([$hashed_password, $user_id]);

    $success_message = "密码已更新。";
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑用户</title>
    <link rel="stylesheet" href="style.css"> <!-- 引入CSS文件 -->
</head>
<body>
    <div class="container">
        <h2>编辑用户：<?= htmlspecialchars($user['username']) ?></h2>

        <!-- 更新密码表单 -->
        <form method="POST">
            <label>新密码：</label>
            <input type="password" name="password" required>
            <button class="btn" type="submit">更新密码</button>
        </form>
        
        <?php if (isset($success_message)): ?>
            <p style="color: green;"><?= $success_message ?></p>
        <?php endif; ?>

        <a class="btn btn-back" href="index.php">返回用户管理</a>
    </div>
</body>
</html>
