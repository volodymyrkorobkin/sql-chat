<?php

function runSql($sql, $params = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function fetchSql($sql, $params = []) {
    return runSql($sql, $params)->fetch();
}

function fetchSqlAll($sql, $params = []) {
    return runSql($sql, $params)->fetchAll();
}