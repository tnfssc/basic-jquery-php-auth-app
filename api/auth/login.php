<?php
require_once "../headers.php";

$method = $_SERVER['REQUEST_METHOD'];

$email = "";
$password = "";

if ($method == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
} else {
  http_response_code(405);
  exit("Invalid request method");
}

if ($email == "" || $password == "" || $email == null || $password == null) {
  http_response_code(400);
  exit("Invalid request");
}

require_once "../../db/auth.php";

$user = login($email, $password);

if ($user == null) {
  http_response_code(401);
  exit("Invalid credentials");
}

setcookie("token", $user['token'], time() + 86400, "/");
setcookie("email", $user['email'], time() + 86400, "/");

http_response_code(200);
exit(json_encode($user));
