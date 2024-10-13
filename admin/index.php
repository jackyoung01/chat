<?php
include '../db.php';
session_start();

// 检查管理员是否登录
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户和聊天室管理</title>
    <link rel="stylesheet" href="style.css"> <!-- 引入CSS文件 -->
</head>
<body>
    <div class="container">
        <h2>用户管理</h2>

        <!-- 用户管理列表 -->
        <h3>用户列表</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>用户名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 从数据库中获取所有用户
                $users = $pdo->query("SELECT * FROM chat_users")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($users as $user):
                ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td>
                        <!-- 编辑用户密码 -->
                        <a class="btn btn-edit" href="edit_user.php?id=<?= $user['id'] ?>">编辑</a> | 
                        <!-- 删除用户 -->
                        <a class="btn btn-delete" href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('确定要删除该用户吗？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>聊天室管理</h2>

        <!-- 聊天室管理列表 -->
        <h3>聊天室列表</h3>
        <table class="chatroom-table">
            <thead>
                <tr>
                    <th>聊天室名称</th>
                    <th>创建者</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 从数据库中获取所有聊天室
                $chatrooms = $pdo->query("SELECT c.id, c.name, c.created_at, u.username as creator 
                                          FROM chat_rooms c 
                                          JOIN chat_users u ON c.created_by = u.id")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($chatrooms as $room):
                ?>
                <tr>
                    <td><?= htmlspecialchars($room['name']) ?></td>
                    <td><?= htmlspecialchars($room['creator']) ?></td>
                    <td><?= htmlspecialchars($room['created_at']) ?></td>
                    <td>
                        <!-- 编辑聊天室名称 -->
                        <a class="btn btn-edit" href="edit_chatroom.php?id=<?= $room['id'] ?>">编辑</a> | 
                        <!-- 删除聊天室 -->
                        <a class="btn btn-delete" href="delete_chatroom.php?id=<?= $room['id'] ?>" onclick="return confirm('确定要删除该聊天室吗？删除后其所有消息也将删除。')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="change_password.php" class="btn btn-edit">修改管理员密码</a>
        <a class="btn btn-logout" href="logout.php">退出登录</a>
    </div>
</body>
</html>
