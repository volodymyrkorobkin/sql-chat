<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/chat.php';

// Check keys and session
$requestKeys = ['chatId', 'lastMessageId'];
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";


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
