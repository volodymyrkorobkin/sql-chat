<?php

if ($requestMethod === "POST") {
    foreach ($requestKeys as $key) {
        if (!isset($_POST[$key]) || $_POST[$key] === "") {
            http_response_code(400);
            echo "'No $key'";
            exit();
        }
    }
} else {
    foreach ($requestKeys as $key) {
        if (!isset($_GET[$key]) || $_GET[$key] === "") {
            http_response_code(400);
            echo "'No $key'";
            exit();
        }
    }
}
