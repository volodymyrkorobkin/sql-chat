<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/session.php';
include_once '../php/chat.php';

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

// Check keys and session
$requestKeys = ['chatId'];
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";

$chatId = $_GET['chatId'];

$chatUsers = getChatUsers($chatId);
if (!in_array(getUserBySession($session), $chatUsers)) {
    echo "You are not in this chat";
    return;
}

$inviteLink = createInviteLink($chatId);

echo json_encode($inviteLink);

