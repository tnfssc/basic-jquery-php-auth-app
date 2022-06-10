<?php
require_once "../headers.php";

$method = $_SERVER['REQUEST_METHOD'];

$email = "";
$password = "";
$first_name = "";
$last_name = "";
$age = "";

if ($method == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $age = $_POST['age'];
} else {
  http_response_code(405);
  exit("Invalid request method");
}

if ($email == "" || $password == "" || $email == null || $password == null) {
  http_response_code(400);
  exit("Invalid request");
}

if ($first_name == "" || $last_name == "" || $first_name == null || $last_name == null || $age == "" || $age == null) {
  http_response_code(400);
  exit("Invalid request");
}

require_once "../../db/mongo-auth.php";

if (!register($email, $password, $first_name, $last_name, $age)) {
  http_response_code(500);
  exit("Some error occurred");
}

http_response_code(200);
exit(json_encode("Success"));
