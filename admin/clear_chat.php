<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$pdo->query("DELETE FROM chat_messages");

header('Location: index.php');
exit;
?>
