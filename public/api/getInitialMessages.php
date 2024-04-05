<?php
$requestMethod = "GET";
$requestKeys = ['chatId'];
include_once "../php/apiHeader.php";


$chatId = $_GET['chatId'];

$chatUsers = getChatUsers($chatId);

if (!in_array($userId, $chatUsers)) {
    echo "You are not in this chat";
    return;
}

$sql = "SELECT changeId FROM messageUpdates WHERE chatId = ? ORDER BY messageId DESC LIMIT 1";
$params = [$chatId];
$changeId = fetchSql($sql, $params);

if (!$changeId) {
    $changeId = 0;
} else {
    $changeId = $changeId['changeId'];
}




$sql = "SELECT * FROM (
    SELECT messages.*, users.username 
    FROM messages 
    INNER JOIN users 
    ON messages.userId = users.id
    WHERE chatId = ? and isDeleted = 0
    ORDER BY messageId DESC 
    LIMIT 25
) AS subquery 
    ORDER BY messageId ASC;";
$params = [$chatId];
$result = fetchSqlAll($sql, $params);

$cleanResult = [];

foreach ($result as $message) {
    $cleanMessage = [
        "messageId" => $message["messageId"],
        "chatId" => $message["chatId"],
        "userId" => $message["userId"],
        "username" => $message["username"],
        "messageBody" => $message["messageBody"],
        "sendTime" => $message["sendTime"]
    ];

    $cleanResult[] = $cleanMessage;
}

echo json_encode(["changeId" => $changeId, "messages" => $cleanResult]);
