<?php
require_once "./headers.php";

$method = $_SERVER['REQUEST_METHOD'];

$email = "";
$token = "";

if ($method == "GET" && isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
  $token = $_COOKIE['token'];
  $email = $_COOKIE['email'];
} else {
  http_response_code(405);
  exit("Invalid request method");
}

if ($token == null || $token == "" || $email == null || $email == "") {
  http_response_code(400);
  exit("Invalid request");
}

require_once "../db/mongo-auth.php";

if (!verify_token($token, $email)) {
  http_response_code(401);
  exit("Invalid session");
}

require_once "../db/mongo-userdetails.php";

$user = user_details($email);

if ($user == null) {
  http_response_code(404);
  exit("Invalid user");
}

http_response_code(200);
exit(json_encode($user));
