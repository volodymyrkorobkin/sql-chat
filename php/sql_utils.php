<?php

function runSql($sql, $params = [], $returnLastInsertedId = false) {
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    if ($returnLastInsertedId) {
        return $conn->lastInsertId();
    }

    return $stmt;
}


function fetchSql($sql, $params = []) {
    return runSql($sql, $params)->fetch();
}

function fetchSqlAll($sql, $params = []) {
    return runSql($sql, $params)->fetchAll();
}