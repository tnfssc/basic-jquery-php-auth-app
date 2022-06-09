<?php

function login($email, $password)
{
  require "../../db/index.php";
  $sql = "SELECT email, hashed_password, first_name, last_name FROM users WHERE email = '$email'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row["hashed_password"];
    $first_name = $row["first_name"];
    $last_name = $row["last_name"];
    if (password_verify($password, $hashed_password)) {
      $token = bin2hex(openssl_random_pseudo_bytes(16));
      $sql = "INSERT INTO tokens (token, email) VALUES ('$token', '$email')";
      if ($conn->query($sql) === TRUE) {
        $conn->close();
        return array(
          "token" => $token,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "email" => $email
        );
      } else {
        $conn->close();
        return null;
      }
    } else {
      $conn->close();
      return null;
    }
  } else {
    $conn->close();
    return null;
  }
}

function logout($token)
{
  require "../../db/index.php";
  $sql = "DELETE FROM tokens WHERE token = '$token'";
  if ($conn->query($sql) === TRUE) {
    $conn->close();
    return true;
  } else {
    $conn->close();
    return false;
  }
}

function register($email, $password, $first_name, $last_name)
{
  require "../../db/index.php";
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO users (email, hashed_password, first_name, last_name) VALUES ('$email', '$hashed_password', '$first_name', '$last_name')";
  if ($conn->query($sql) === TRUE) {
    $conn->close();
    return true;
  } else {
    $conn->close();
    return false;
  }
}
