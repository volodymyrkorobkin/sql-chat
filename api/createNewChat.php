<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/session.php';
include_once '../php/chat.php';

if (!isset($_POST['new-chat-name'])) {
    echo "No chat name";
    return;
}

if (!isset($_POST['session'])) {
    echo "No session";
    return;
}

if (!isValidSession($_POST['session'])) {
    echo "Invalid session";
    return;
}


$chatName = $_POST['new-chat-name'];
$session = $_POST['session'];




$chatId = createNewChat($chatName);
addUserToChat(getUserBySession($session), $chatId);

