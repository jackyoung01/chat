<?php
$host = 'localhost';
$db = '';//替换成实际的账号
$user = '';//替换成实际的账号
$pass = '';  // 替换成实际的密码

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}
?>
