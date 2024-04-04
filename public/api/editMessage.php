<?php 
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/session.php';

$requestKeys = ['chat-id', 'user-id', 'message-id', 'new-message-body']; // Updated request keys
include_once "../php/checkRequestKeys.php";
include_once "../php/checkSession.php";

// Extracting variables from the session and request
$chatId = $_SESSION['chat_id'];
$userId = $_SESSION['user_id'];
$messageId = $_REQUEST['message-id'];
$newMessageBody = $_REQUEST['new-message-body'];

// Updating the message
$sql = "UPDATE messages SET messageBody = ? WHERE chatId = ? AND userId = ? AND id = ?";
$params = [$newMessageBody, $chatId, $userId, $messageId];
runSql($sql, $params);

?>
