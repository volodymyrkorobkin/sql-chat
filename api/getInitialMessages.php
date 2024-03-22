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

$userId = getUserBySession($session);
$chatId = $_GET['chatId'];

$chatUsers = getChatUsers($chatId);

if (!in_array($userId, $chatUsers)) {
    echo "You are not in this chat";
    return;
}


$sql = "SELECT * FROM (SELECT * FROM messages WHERE chatId = ? ORDER BY messageId DESC LIMIT 25) AS subquery ORDER BY messageId ASC;";
$params = [$chatId];
$result = fetchSqlAll($sql, $params);

echo json_encode($result);
