<?php
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/session.php';
include_once '../php/chat.php';

// Check keys and session
$requestKeys = ['new-chat-name'];
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";


$chatName = $_POST['new-chat-name'];
$session = $_POST['session'];


$chatId = createNewChat($chatName);
addUserToChat(getUserBySession($session), $chatId);


header("Location: ../pages/chat.php");

