<?php
$requestMethod = "GET";
$requestKeys = ['chatId', 'lastMessageId', 'lastChangeId'];
include_once "../php/apiHeader.php";

include_once '../php/messages.php';

$chatId = $_GET['chatId'];
$lastMessageId = $_GET['lastMessageId'];
$lastChangeId = $_GET['lastChangeId'];
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
    if (connection_status() != CONNECTION_NORMAL) {
        break;
    }


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
        "changedMessages" => []
    ];

    global $chatId, $lastMessageId, $lastChangeId, $userId;
    $updates["newMessages"] = getNewMessages($chatId, $lastMessageId);
    $updates["changedMessages"] = getChangedMessages($chatId, $lastChangeId);


    if (count($updates["newMessages"]) > 0 || count($updates["changedMessages"]) > 0){
        // Handle new messages
        if (count($updates["newMessages"]) > 0) {
            $cleanResult = [];
            foreach ($updates["newMessages"] as $message) {
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
            $updates["newMessages"] = $cleanResult;
        }

        // Handle changed messages (deleted or edited)
        if (count($updates["changedMessages"]) > 0) {
            $cleanResult = [];
            foreach ($updates["changedMessages"] as $message) {
                $cleanMessage = [
                    "messageId" => $message["messageId"],
                    "chatId" => $message["chatId"],
                    "userId" => $message["userId"],
                    "messageBody" => $message["messageBody"],
                    "sendTime" => $message["sendTime"]
                ];

                $cleanResult[] = $cleanMessage;
                $lastChangeId = max($lastChangeId, $message["changeId"]);
            }
            $updates["changedMessages"] = $cleanResult;
            $updates["lastChangeId"] = $lastChangeId;
        }




        return $updates;
    }

    return false;
}