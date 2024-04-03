<?php

if ($requestMethod === "POST") {
    foreach ($requestKeys as $key) {
        if (!key_exists($key, $_POST) || $_POST[$key] === ""){
            http_response_code(400);
            echo "'No $key'";
            echo "<br>";
            print_r($_POST);
            exit();
        }
    }
} else {
    foreach ($requestKeys as $key) {
        if (!isset($_GET[$key])) {
            http_response_code(400);
            echo "'No $key'";
            echo "lol get<br>";
            exit();
        }
    }
}
