<?php

include_once 'sql_connect.php';
include_once 'sql_utils.php';

function isUserExists($username) {
    $sql = "SELECT * FROM users WHERE username = ?";
    $params = [$username];
    $result = fetchSql($sql, $params);

    return $result != false;
}