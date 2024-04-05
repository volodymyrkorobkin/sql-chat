<?php

function getNewMessages($chatId, $lastMessageId) {
    $sql = "SELECT * FROM (
        SELECT messages.*, users.username 
        FROM messages 
        INNER JOIN users 
        ON messages.userId = users.id 
        WHERE chatId = ? and messageId > ? and isDeleted = 0
        ORDER BY messageId DESC 
        LIMIT 25
    ) AS subquery 
        ORDER BY messageId ASC;";

    $params = [$chatId, $lastMessageId];
    return fetchSqlAll($sql, $params);
}



function getChangedMessages($chatId, $lastChangeId) {
    $sql = "select messageUpdates.changeId, messages.* 
            from messageUpdates
            inner join messages
            on messageUpdates.messageId = messages.messageId
            where messages.chatId = ? and messageUpdates.changeId > ?
            order by messageId ASC
            limit 10;";
    $params = [$chatId, $lastChangeId];
    return fetchSqlAll($sql, $params);
}
