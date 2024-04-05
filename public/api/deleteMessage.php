<?php
$requestMethod = "POST";
$requestKeys = ['messageId'];
include_once "../php/apiHeader.php";


$messageId = $_POST['messageId'];

$sql = "SELECT chatId, userId FROM messages WHERE messageId = ?";
$params = [$messageId];
$result = fetchSql($sql, $params);
$chatId = $result['chatId'];
$ovnerId = $result['userId'];

if ($ovnerId != $userId) {
    exit("'You are not the owner of this message'");
}

$sql = "UPDATE messages SET isDeleted=1 WHERE messageId= ?";
$params = [$messageId];
runSql($sql, $params);

//Check is result not an empty
if ($result == false) {
    exit("No message with this id");
}


$sql = "INSERT INTO messageUpdates (chatId, messageId) VALUES (? , ?)";
$params = [$chatId, $messageId];
runSql($sql, $params);


echo(json_encode(true));