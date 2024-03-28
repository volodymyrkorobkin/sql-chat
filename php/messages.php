<?php

function getNewMessages($chatId, $lastMessageId) {
    $sql = "SELECT * FROM (
        SELECT messages.*, users.username 
        FROM messages 
        INNER JOIN users 
        ON messages.userId = users.id 
        WHERE chatId = ? and messageId > ?
        ORDER BY messageId DESC 
        LIMIT 25
    ) AS subquery 
        ORDER BY messageId ASC;";

    $params = [$chatId, $lastMessageId];
    return fetchSqlAll($sql, $params);
}