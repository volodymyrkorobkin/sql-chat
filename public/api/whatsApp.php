<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/session.php';
include_once '../php/messages.php';
include_once '../php/chat.php';

// Check keys and session
$requestKeys = ['chatId', 'lastMessageId'];
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";

$userId = getUserBySession($session);
$chatId = $_GET['chatId'];
$lastMessageId = $_GET['lastMessageId'];
$chatUsers = getChatUsers($chatId);
if (!in_array($userId, $chatUsers)) {
    echo "You are not in this chat";
    return;
}


set_time_limit(30);

while (ob_get_level()) ob_end_clean();
header('Content-Encoding: none');
header('Cache-Control: no-cache');

$startTime = time();
while (true) {
    $newData = checkForUpdates();

    if ($newData) {
        echo json_encode($newData);
        break;
    }

    if (time() - $startTime > 25) {
        echo json_encode([]);
        break;
    }

    usleep(500000); // 0.5 seconds
}



function checkForUpdates() {
    $updates = [
        "newMessages" => [],
        "editedMessages" => [],
        "deletedMessages" => []
    ];

    global $chatId, $lastMessageId, $userId;
    $updates["newMessages"] = getNewMessages($chatId, $lastMessageId);


    if (count($updates["newMessages"]) > 0 || count($updates["editedMessages"]) > 0 || count($updates["deletedMessages"]) > 0){
        if (count($updates["newMessages"]) > 0) {
            $cleanResult = [];

            foreach ($updates["newMessages"] as $message) {
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
            $updates["newMessages"] = $cleanResult;
        }
        return $updates;
    }

    return false;
}