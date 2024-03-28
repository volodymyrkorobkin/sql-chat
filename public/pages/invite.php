<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/session.php';
include_once '../php/chat.php';

// Check keys and session
$requestKeys = ['invite'];
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";

$invite = $_GET['invite'];

$chatId = getChatIdByInvite($invite);

if ($chatId == null) {
    echo "Invalid invite";
    return;
}

addUserToChat(getUserBySession($session), $chatId);