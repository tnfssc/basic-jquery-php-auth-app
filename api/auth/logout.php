<?php
require_once "../headers.php";

$method = $_SERVER['REQUEST_METHOD'];

$token = "";

if ($method == "POST") {
  $token = $_POST['token'];
} else {
  http_response_code(405);
  exit("Invalid request method");
}

if ($token == null || $token == "") {
  http_response_code(400);
  exit("Invalid request");
}

require_once "../../db/auth.php";

if (!logout($token)) {
  http_response_code(500);
  exit("Some error occurred");
}

http_response_code(200);
exit(json_encode("Success"));
