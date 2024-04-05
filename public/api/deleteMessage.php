<?php
$requestMethod = "POST";
$requestKeys = ['messageId'];
include_once "../php/apiHeader.php";



$sql = "UPDATE messages SET isDeleted=1 WHERE messageId= ?";
$params = [$messageId];
runSql($sql, $params);

$sql = "SELECT chatId FROM messages WHERE messageId = ?";
$params = [$messageId];
if{
$result = fetchSql($sql, $params);
}
$sql = "INSERT INTO messageUpdate (chatId, messageId) VALUES (? , ?)";
runSql($sql, $params);

