<?php
include '../db.php';
session_start();

// 检查管理员是否已登录
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$admin_id = $_SESSION['admin_id'];
$message = '';

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 查询当前管理员信息
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE id = ?");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // 验证当前密码
    if ($admin && md5($current_password) === $admin['password']) {
        // 检查新密码是否匹配确认密码
        if ($new_password === $confirm_password) {
            // 更新密码
            $new_password_hashed = md5($new_password); // 使用 MD5 加密新密码
            $stmt = $pdo->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
            $stmt->execute([$new_password_hashed, $admin_id]);
            $message = '密码修改成功！';
        } else {
            $message = '新密码和确认密码不匹配。';
        }
    } else {
        $message = '当前密码错误。';
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改管理员密码</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>修改管理员密码</h2>
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="password" name="current_password" placeholder="当前密码" required>
            <input type="password" name="new_password" placeholder="新密码" required>
            <input type="password" name="confirm_password" placeholder="确认新密码" required>
            <button type="submit">修改密码</button>
        </form>

        <a href="index.php" class="btn btn-back">返回管理主页</a>
    </div>
</body>
</html>
