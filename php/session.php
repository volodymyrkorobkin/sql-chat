<?php
include_once 'sql_connect.php';
include_once 'sql_utils.php';

function createUserSession($userId) {
    $session = bin2hex(random_bytes(128));
    $sql = "INSERT INTO sessions (session, userId) VALUES (?, ?)";
    $params = [$session, $userId];

    runSql($sql, $params);

    return $session;
}


function isValidSession($sessionId) {
    $sql = "SELECT * FROM sessions WHERE session = ?";
    $params = [$sessionId];
    $result = fetchSql($sql, $params);

    return $result != false;
}


function getUserBySession($sessionId) {
    $sql = "SELECT userId FROM sessions WHERE session = ?";
    $params = [$sessionId];
    $result = fetchSql($sql, $params);

    return $result["userId"];
}