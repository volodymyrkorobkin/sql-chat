<?php
$requestMethod = "GET";
$requestKeys = ['messageId', "messageBody"];
include_once "../php/apiHeader.php";

$messageBody = $_GET['messageBody'];
$messageId = $_GET['messageId'];

$sql = "SELECT chatId, userId FROM messages WHERE messageId = ?";
$params = [$messageId];
$result = fetchSql($sql, $params);
$chatId = $result['chatId'];
$ovnerId = $result['userId'];

if ($ovnerId != $userId) {
    exit("'You are not the owner of this message'");
}

//Check is result not an empty
if ($result == false) {
    exit("'No message with this id'");
}


$sql = "UPDATE messages SET messageBody = ? WHERE messageId = ?";
$params = [$messageBody, $messageId];
runSql($sql, $params);

$sql = "INSERT INTO messageUpdates (chatId, messageId) VALUES (? , ?)";
$params = [$chatId, $messageId];
runSql($sql, $params);


echo(json_encode(true));