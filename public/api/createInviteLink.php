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

$inviteLink = createInviteLink($chatId);

echo json_encode($inviteLink);

