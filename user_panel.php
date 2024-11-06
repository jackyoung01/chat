<?php
include 'db.php';
session_start();

// 检查用户是否登录
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

// 获取用户详细信息
try {
    $stmt = $pdo->prepare("SELECT id, username, password, created_at, last_active, room_id FROM chat_users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user_data) {
        $username = $user_data['username'];
        $created_at = $user_data['created_at'];
        $last_active = $user_data['last_active'] ?? 'NULL';
        $room_id = $user_data['room_id'] ?? 'NULL';
        
        // 更新最后活动时间
        $update_stmt = $pdo->prepare("UPDATE chat_users SET last_active = NOW() WHERE id = ?");
        $update_stmt->execute([$user_id]);
    } else {
        $message = '无法获取用户信息。';
    }
    
    // 查询用户创建的聊天室
    $stmt = $pdo->prepare("SELECT * FROM chat_rooms WHERE created_by = ?");
    $stmt->execute([$user_id]);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = '数据库错误：' . $e->getMessage();
}

// 处理聊天室相关的POST请求
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['join_room'])) {
        $room_name = trim($_POST['room_name']);
        $password = md5(trim($_POST['password']));
        
        $stmt = $pdo->prepare("SELECT id, password FROM chat_rooms WHERE name = ?");
        $stmt->execute([$room_name]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($room) {
            if ($password === $room['password']) {
                $update_stmt = $pdo->prepare("UPDATE chat_users SET room_id = ? WHERE id = ?");
                $update_stmt->execute([$room['id'], $user_id]);
                header("Location: chatroom.php?room_id=" . $room['id']);
                exit;
            } else {
                $message = '密码错误，请重试。';
            }
        } else {
            $message = '聊天室不存在，请检查名称。';
        }
    } elseif (isset($_POST['create_room'])) {
        $room_name = trim($_POST['room_name']);
        $password = md5(trim($_POST['password']));
        
        $stmt = $pdo->prepare("SELECT id FROM chat_rooms WHERE name = ?");
        $stmt->execute([$room_name]);
        
        if ($stmt->rowCount() > 0) {
            $message = '该聊天室名称已存在，请选择其他名称。';
        } else {
            $stmt = $pdo->prepare("INSERT INTO chat_rooms (name, created_by, password) VALUES (?, ?, ?)");
            $stmt->execute([$room_name, $user_id, $password]);
            $new_room_id = $pdo->lastInsertId();
            
            $update_stmt = $pdo->prepare("UPDATE chat_users SET room_id = ? WHERE id = ?");
            $update_stmt->execute([$new_room_id, $user_id]);
            
            $message = '聊天室创建成功！';
        }
    } elseif (isset($_POST['edit_room'])) {
        $room_id = (int)$_POST['room_id'];
        $new_room_name = trim($_POST['room_name']);
        
        $stmt = $pdo->prepare("UPDATE chat_rooms SET name = ? WHERE id = ? AND created_by = ?");
        $stmt->execute([$new_room_name, $room_id, $user_id]);
        $message = $stmt->rowCount() ? "聊天室名称已更新。" : "更新失败，请稍后再试。";
    } elseif (isset($_POST['delete_room'])) {
        $room_id = (int)$_POST['room_id'];
        
        $stmt = $pdo->prepare("DELETE FROM chat_messages WHERE room_id = ?");
        $stmt->execute([$room_id]);
        
        $stmt = $pdo->prepare("DELETE FROM chat_rooms WHERE id = ? AND created_by = ?");
        $stmt->execute([$room_id, $user_id]);
        $message = $stmt->rowCount() ? "聊天室已删除。" : "删除失败，请稍后再试。";
    } elseif (isset($_POST['change_password'])) {
        $room_id = (int)$_POST['room_id'];
        $new_password = md5(trim($_POST['new_password']));
        
        $stmt = $pdo->prepare("UPDATE chat_rooms SET password = ? WHERE id = ? AND created_by = ?");
        $stmt->execute([$new_password, $room_id, $user_id]);
        $message = $stmt->rowCount() ? "密码已成功更新。" : "密码更新失败，请稍后再试。";
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户面板</title>
    <link rel="stylesheet" href="src/css/user_panel.css">
</head>
<body>
    <div class="layout">
        <!-- 侧边栏 -->
        <div class="sidebar" id="sidebar">
            <button class="toggle-btn" onclick="toggleSidebar()">➤</button>
            <div class="sidebar-content">
                <h2>功能菜单</h2>
                <button onclick="showPanel('profile')" id="btnProfile">个人资料</button>
                <button onclick="showPanel('join')" id="btnJoin">加入聊天室</button>
                <button onclick="showPanel('create')" id="btnCreate">创建聊天室</button>
                <button onclick="showPanel('manage')" id="btnManage">管理我的聊天室</button>
                <a href="logout.php" class="logout">退出登录</a>
            </div>
        </div>

        <!-- 主要内容区域 -->
        <div class="main-content" id="mainContent">
            <!-- 个人资料面板 -->
            <div id="profilePanel" class="content-panel active">
                <h2>个人资料</h2>
                <div class="info-item">
                    <div class="info-label">用户ID：</div>
                    <div class="info-value"><?= htmlspecialchars($user_id) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">用户名：</div>
                    <div class="info-value"><?= htmlspecialchars($username) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">创建时间：</div>
                    <div class="info-value"><?= htmlspecialchars($created_at) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">最后活动：</div>
                    <div class="info-value"><?= ($last_active != 'NULL') ? htmlspecialchars($last_active) : '暂无记录' ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">最后房间：</div>
                    <div class="info-value"><?= ($room_id != 'NULL') ? htmlspecialchars($room_id) : '未在任何房间中' ?></div>
                </div>
            </div>

            <!-- 加入聊天室面板 -->
            <div id="joinPanel" class="content-panel">
                <h2>加入聊天室</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="join_room_name">聊天室名称</label>
                        <input type="text" id="join_room_name" name="room_name" placeholder="输入想要加入的聊天室名称" required>
                    </div>
                    <div class="form-group">
                        <label for="join_password">聊天室密码</label>
                        <input type="password" id="join_password" name="password" placeholder="输入聊天室密码" required>
                    </div>
                    <button type="submit" name="join_room" class="submit-btn">加入聊天室</button>
                </form>
            </div>

            <!-- 创建聊天室面板 -->
            <div id="createPanel" class="content-panel">
                <h2>创建新聊天室</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="create_room_name">聊天室名称</label>
                        <input type="text" id="create_room_name" name="room_name" placeholder="输入新聊天室名称" required>
                    </div>
                    <div class="form-group">
                        <label for="create_password">设置密码</label>
                        <input type="password" id="create_password" name="password" placeholder="设置聊天室密码" required>
                    </div>
                    <button type="submit" name="create_room" class="submit-btn">创建聊天室</button>
                </form>
            </div>

            <!-- 管理聊天室面板 -->
            <div id="managePanel" class="content-panel">
                <h2>管理我的聊天室</h2>
                <?php if (empty($rooms)): ?>
                    <p>您还没有创建任何聊天室。</p>
                <?php else: ?>
                    <?php foreach ($rooms as $room): ?>
                        <div class="room-item">
                            <h3><?= htmlspecialchars($room['name']) ?></h3>
                            
                            <form method="POST" class="form-group">
                                <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                                <label>修改聊天室名称</label>
                                <input type="text" name="room_name" value="<?= htmlspecialchars($room['name']) ?>" required>
                                <button type="submit" name="edit_room" class="submit-btn">更新名称</button>
                            </form>

                            <form method="POST" class="form-group">
                                <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                                <label>修改密码</label>
                                <input type="password" name="new_password" placeholder="输入新密码" required>
                                <button type="submit" name="change_password" class="submit-btn">更新密码</button>
                            </form>

                            <form method="POST" class="form-group">
                                <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                                <button type="submit" name="delete_room" class="submit-btn" onclick="return confirm('确定要删除该聊天室吗？')">删除聊天室</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('full');
        }

        function showPanel(panelName) {
            document.querySelectorAll('.content-panel').forEach(panel => {
                panel.classList.remove('active');
            });
            document.getElementById(panelName + 'Panel').classList.add('active');
            document.querySelectorAll('.sidebar button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById('btn' + panelName.charAt(0).toUpperCase() + panelName.slice(1)).classList.add('active');
        }

        // 显示操作结果消息
        <?php if (!empty($message)): ?>
            alert("<?= htmlspecialchars($message) ?>");
        <?php endif; ?>

        document.getElementById('btnProfile').classList.add('active');
    </script>
</body>
</html>
