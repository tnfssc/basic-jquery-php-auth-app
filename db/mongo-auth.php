<?php

function login($email, $password)
{
  require "mongo-db.php";
  $collection = $db->selectCollection("users");
  $user = $collection->findOne(array("email" => $email));
  if ($user) {
    $hashed_password = $user["hashed_password"];
    $first_name = $user["first_name"];
    $last_name = $user["last_name"];
    $age = $user["age"];
    if (password_verify($password, $hashed_password)) {
      $token = bin2hex(openssl_random_pseudo_bytes(16));
      $collection->updateOne(
        array("email" => $email),
        array(
          '$set' => array(
            "token" => $token,
            "expiry" => date("Y-m-d H:i:s", strtotime("+1 day"))
          )
        )
      );
      return array(
        "token" => $token,
        "first_name" => $first_name,
        "last_name" => $last_name,
        "age" => $age,
        "email" => $email,
        "expiry" => date("Y-m-d H:i:s", strtotime("+1 day"))
      );
    } else {
      return null;
    }
  } else {
    return null;
  }
}

function logout($token)
{
  require "mongo-db.php";
  $collection = $db->selectCollection("users");
  return $collection->updateOne(
    array("token" => $token),
    array(
      '$unset' => array(
        "token" => "",
        "expiry" => ""
      )
    )
  );
}

function register($email, $password, $first_name, $last_name, $age)
{
  require "mongo-db.php";
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $collection = $db->selectCollection("users");
  return $collection->insertOne(
    array(
      "email" => $email,
      "hashed_password" => $hashed_password,
      "first_name" => $first_name,
      "last_name" => $last_name,
      "age" => $age
    )
  );
}

function verify_token($token, $email)
{
  require "mongo-db.php";
  $collection = $db->selectCollection("users");
  $user = $collection->findOne(array("token" => $token, "email" => $email));
  if ($user) {
    $expiry = $user["expiry"];
    if (strtotime($expiry) > time()) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}
