<?php
$requestMethod = "GET";
//TODO: use POST
$requestKeys = ['chatId'];
include_once "../php/apiHeader.php";


include_once '../php/chat.php';
$chatId = $_GET['chatId'];

removeUserFromChat($userId, $chatId);

header("Location: ../pages/chat.php");
