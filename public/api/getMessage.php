<?php
$requestMethod = "POST";
$requestKeys = ['chatId', 'messageId'];
include_once "../php/apiHeader.php";

$chatId = $_POST['chatId'];
$messageId = $_POST['messageId'];

$chatMembers = getChatUsers($chatId);
if (!in_array($userId, $chatMembers)) {
    http_response_code(403);
    exit("'You are not a member of this chat'");
}


$sql = "SELECT * FROM messages WHERE messageId = ? and LIMIT 1";
$params = [$messageId];
$message = fetchSql($sql, $params);

if ($message['chatId'] != $chatId) {
    http_response_code(403);
    exit("'Message does not belong to this chat'");
}

if (!$message || $message['isDeleted']) {
    echo json_encode([]);
    exit();
}

$cleanResult = [
    'messageId' => $message['messageId'],
    'chatId' => $message['chatId'],
    'userId' => $message['userId'],
    'sendTime' => $message['sendTime'],
    'editTime' => $message['editTime'],
    'messageBody' => $message['messageBody']
];

echo json_encode($cleanResult);