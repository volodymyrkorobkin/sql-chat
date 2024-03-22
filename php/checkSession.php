<?php

session_start();

if (!isset ($_SESSION["id"])) {
    return;
}

if (!isValidSession($_SESSION["id"])) {
    return;
}

$session = $_SESSION["id"];