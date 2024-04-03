<?php
$requestMethod = "POST";
$requestKeys = ['chatId', 'messages'];
include_once "../php/apiHeader.php";


$chatId = $_POST['chatId'];

$chatUsers = getChatUsers($chatId);
if (!in_array($userId, $chatUsers)) {
    echo "You are not in this chat";
    return;
}


$messages = $_POST['messages'];

$results = [];

foreach ($messages as $message) {
    $message = json_decode($message, true);
    $messageBody = $message['messageBody'];
    
    $sql = "INSERT INTO messages (chatId, userId, messageBody) VALUES (?, ?, ?)";
    $params = [$chatId, $userId, $messageBody];

    $lastInsertionId = runSql($sql, $params, true);

    $sql = "SELECT messageId, sendTime FROM messages WHERE messageId = ?";
    $params = [$lastInsertionId];
    $result = fetchSql($sql, $params);

    $cleanResult = [
        "messageId" => $result['messageId'],
        "sendTime" => strtotime($result['sendTime']) - 3600
    ];

    $results[] = $cleanResult;
}

echo json_encode($results);
