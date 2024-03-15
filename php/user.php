<?php

include_once 'sql_connect.php';
include_once 'sql_utils.php';

function isUserExists($username) {
    $sql = "SELECT * FROM users WHERE username = ?";
    $params = [$username];
    $result = fetchSql($sql, $params);

    return $result != false;
}


function isCredentialsCorrect($username, $password) {
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $params = [$username, $password];
    $result = fetchSql($sql, $params);

    return $result != false;
}


function getUserId($username) {
    $sql = "SELECT id FROM users WHERE username = ?";
    $params = [$username];
    $result = fetchSql($sql, $params);

    return $result['id'];
}