<?php
include_once 'sql_connect.php';
include_once 'sql_utils.php';

function createNewChat($chatName) {
    $sql = "INSERT INTO chats (name) VALUES (?)";
    $params = [$chatName];

    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    
    return $conn->lastInsertId();
}

function addUserToChat($userId, $chatId) {
    $sql = "INSERT INTO chatsMembers (chatId, userId) VALUES (?, ?)";
    $params = [$chatId, $userId];

    runSql($sql, $params);
}

function getUserChats($userId) {
    $sql = "SELECT chatId FROM chatsMembers WHERE userId = ?";
    $params = [$userId];
    $result = fetchSqlAll($sql, $params);

    return $result;
}

function getChatNameById($chatId) {
    $sql = "SELECT name FROM chats WHERE chatId = ?";
    $params = [$chatId];
    $result = fetchSql($sql, $params);

    return $result['name'];
}