<?php

echo "Hello World!";


$DB_HOST = "127.0.0.1";
$DB_PORT = 9906;
$DB_USER = "test";
$DB_PASS = "test";
$DB_NAME = "test";


$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

if (!$conn) {
  die("Database connection failed" . mysqli_connect_error());
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");




$conn->close();
