<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/chat.php';

// Check if the session is set
include_once "../php/checkSession.php";
$session = checkSession();
if (!$session) {
    echo "Invalid session";
    return;
}

if (!isset($_GET['chatId'])) {
    echo "No chat id";
    return;
}

$chatId = $_GET['chatId'];
$userId = getUserBySession($session);
$chatUsers = getChatUsers($chatId);

if (!in_array($userId, $chatUsers)) {
    echo "You are not in this chat";
    return;
}

if (!isset($_GET['body'])) {
    echo "No message body";
    return;
}

$body = $_GET['body'];
$author = $userId;

$sql = "INSERT INTO messages (chatId, userId, messageBody) VALUES (?, ?, ?)";
$params = [$chatId, $author, $body];

$lastInsertionId = runSql($sql, $params, true);

$sql = "SELECT messageId, sendTime FROM messages WHERE messageId = ?";
$params = [$lastInsertionId];
$result = fetchSql($sql, $params);

$cleanResult = [
    "messageId" => $result['messageId'],
    "sendTime" => $result['sendTime']
];

json_encode($cleanResult); 