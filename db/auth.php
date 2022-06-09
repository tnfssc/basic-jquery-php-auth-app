<?php

function login($email, $password)
{
  require "db.php";
  $sql = "SELECT email, hashed_password, first_name, last_name FROM users WHERE email = '$email'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row["hashed_password"];
    $first_name = $row["first_name"];
    $last_name = $row["last_name"];
    if (password_verify($password, $hashed_password)) {
      $token = bin2hex(openssl_random_pseudo_bytes(16));
      $sql = "INSERT INTO tokens (token, email, expiry) VALUES ('$token', '$email', NOW() + INTERVAL 1 DAY)";
      if ($conn->query($sql) === TRUE) {
        $conn->close();
        return array(
          "token" => $token,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "email" => $email,
          "expiry" => date("Y-m-d H:i:s", strtotime("+1 day"))
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
  require "db.php";
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
  require "db.php";
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

function verify_token($token, $email)
{
  require "db.php";
  $sql = "SELECT email, expiry FROM tokens WHERE token = '$token' AND email = '$email'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $expiry = $row["expiry"];
    if (strtotime($expiry) > time()) {
      $conn->close();
      return true;
    } else {
      $conn->close();
      return false;
    }
  } else {
    $conn->close();
    return false;
  }
}
