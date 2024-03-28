<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/chat.php';

// Check keys and session
$requestKeys = ['chatId'];
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";


$userId = getUserBySession($session);
$chatId = $_GET['chatId'];
$olderThan = $_GET['olderThan'];

$chatUsers = getChatUsers($chatId);

if (!in_array($userId, $chatUsers)) {
    echo "You are not in this chat";
    return;
}


$sql = "SELECT * FROM (
    SELECT messages.*, users.username 
    FROM messages 
    INNER JOIN users 
    ON messages.userId = users.id 
    WHERE chatId = ? and messageId < ? 
    ORDER BY messageId DESC 
    LIMIT 25
) AS subquery 
    ORDER BY messageId ASC;";

$params = [$chatId, $olderThan];
$result = fetchSqlAll($sql, $params);

$cleanResult = [];

foreach ($result as $message) {
    $sendTime = strtotime($message["sendTime"]);
    $cleanMessage = [
        "messageId" => $message["messageId"],
        "chatId" => $message["chatId"],
        "userId" => $message["userId"],
        "username" => $message["username"],
        "messageBody" => $message["messageBody"],
        "sendTime" => $sendTime
    ];

    $cleanResult[] = $cleanMessage;
}

echo json_encode($cleanResult);

//const response = await fetch(`../api/getOldMessages.php?chatId=${chatId}&olderThan=${this.messages[0].messaageId}`, {
//            method: 'GET',
//        });