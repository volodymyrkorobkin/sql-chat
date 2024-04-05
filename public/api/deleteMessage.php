<?php
$requestMethod = "POST";
$requestKeys = ['messageId'];
include_once "../php/apiHeader.php";



$sql = "UPDATE messages SET isDeleted=0 WHERE messageId= ?";
$params = [$messageId,];
runSql($sql, $params);


$sql = "insert into messageUpdate (chatId, messageId) valeus (? , ?)";
$sql = "SELECT chatId FROM Messages";

