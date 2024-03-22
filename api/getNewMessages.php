<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/chat.php';

// Check if the session is set
include_once "../php/checkSession.php";

if (!isset($_POST['chatId'])) {
    echo "No chat id";
    return;
}

if (!isset($_POST['lastMessageId'])) {
    echo "No last message id";
    return;
}

$userId = getUserBySession($session);
$chatId = $_POST['chatId'];
$lastMessageId = $_POST['lastMessageId'];

$chatUsers = getChatUsers($chatId);

if (!in_array($userId, $chatUsers)) {
    echo "You are not in this chat";
    return;
}


$sql = "SELECT * FROM messages WHERE chatId = ? AND id > ? LIMIT 25";
$params = [$chatId, $lastMessageId];
$result = fetchSqlAll($sql, $params);

echo json_encode($result);
