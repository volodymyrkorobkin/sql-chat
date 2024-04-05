<?php
$requestMethod = "GET";
$requestKeys = ['invite'];
include_once "../php/apiHeader.php";


$invite = $_GET['invite'];

$chatId = getChatIdByInvite($invite);
if ($chatId == null) {
    echo "Invalid invite";
    return;
}

$userId = getUserBySession($session);
$chatUsers = getChatUsers($chatId);

if (!in_array($userId, $chatUsers)) {
    addUserToChat(getUserBySession($session), $chatId);
}
header("Location: ../pages/chat.php?chatId=$chatId");