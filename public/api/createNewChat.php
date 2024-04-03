<?php
$requestMethod = "POST";
$requestKeys = ['new-chat-name'];
include_once "../php/apiHeader.php";



$chatName = $_POST['new-chat-name'];


$chatId = createNewChat($chatName);
addUserToChat($userId, $chatId);


header("Location: ../pages/chat.php?chatId=$chatId");

