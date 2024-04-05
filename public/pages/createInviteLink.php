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
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
echo $protocol . $host . "/pages/invite.php?invite=" . $inviteLink;