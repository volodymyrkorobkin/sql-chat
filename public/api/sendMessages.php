<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/chat.php';

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

// Check keys and session
$requestKeys = ['chatId', 'messages'];
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";



$chatId = $_POST['chatId'];
$userId = getUserBySession($session);

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
        "sendTime" => strtotime($result['sendTime'])
    ];

    $results[] = $cleanResult;
}

echo json_encode($results);
