<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/php/db/auth.inc.php";
$auth = new Authentication();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET") {


    if (!isset($_COOKIE["auth-token"])) {
        http_response_code(401);
        die(json_encode(array("error" => "Unauthorized access.")));
    }

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $result = $auth->get($id);
        if ($result) {
            http_response_code(200);
            die(json_encode($result));
        } else {
            http_response_code(400);
            die(json_encode(array("error" => "User not found.")));
        }
    } else if (isset($_GET["username"])) {
        $username = $_GET["username"];
        $permissions = isset($_GET["permissions"]) && $_GET["permissions"] != "" ? explode(";", $_GET["permissions"]) : array();
        $result = $auth->search($username, $permissions);
        if ($result) {
            http_response_code(200);
            die(json_encode($result));
        } else {
            http_response_code(400);
            die(json_encode(array("error" => "User not found.")));
        }
    }
    if (isset($_GET["permissions"])) {
        die(json_encode(Authentication::getPermissionMap()));
    }
    die(json_encode($auth->list()));
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["action"])) {
        switch ($_GET["action"]) {
        }
    } else {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            http_response_code(200);
            die(json_encode($auth->login($username, $password)));
        } else {
            if (isset($_COOKIE['auth-token'])) {
                http_response_code(200);
                die(json_encode($auth->loginCookies()));
            }
            http_response_code(400);
            die(json_encode(array("error" => "Missing username or password.")));
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    $body = file_get_contents("php://input");
    $body = json_decode($body, true);
    if (json_last_error() != JSON_ERROR_NONE) {
        http_response_code(400);
        die(json_encode(array("error" => "Invalid JSON.")));
    }
    if (!isset($body["username"])  || !isset($body["permissions"])) {
        http_response_code(400);
        die(json_encode(array("error" => "Missing username, or permissions.")));
    }
    $username = $body["username"];
    $password = isset($body["password"]) ? $body["password"] : "";
    $permissions = $body["permissions"];
    if (isset($body["id"])) {
        $id = $body["id"];
        die(json_encode($auth->edit($id, $username, $password, $permissions)));
    }
    if (!isset($body["password"])) {
        http_response_code(400);
        die(json_encode(array("error" => "Missing password.")));
    }
    die(json_encode($auth->add($username, $password, $permissions)));
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    if (!isset($_COOKIE["auth-token"])) {
        http_response_code(401);
        die(json_encode(array("error" => "Unauthorized access.")));
    }
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $result = $auth->remove($id);
        if ($result) {
            http_response_code(200);
            die(json_encode(array("success" => "User deleted.")));
        } else {
            http_response_code(400);
            die(json_encode(array("error" => "User not found.")));
        }
    } else {
        http_response_code(400);
        die(json_encode(array("error" => "Missing user id.")));
    }
}
