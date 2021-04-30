<?php

function hashPassword($password) {
    $salt = "PSAMSGROUP20";
    return md5($password.$salt);
}

function error($message) {
    header('HTTP/1.1 400 Bad request');
    $response = array("message" => $message);
    return json_encode($response);
}

function success($message, $data) {
    header('HTTP/1.1 200 Success');
    $response = array("message" => $message, "data" => $data);
    return json_encode($response);
}
