<?php
session_start();
// 清除所有会话数据
session_unset();
session_destroy();

// 重定向到登录页面
header('Location: login.php');
exit;
?>
