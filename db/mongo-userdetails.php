<?php
function user_details($email)
{
  require "mongo-db.php";
  $collection = $db->selectCollection("users");
  $user = $collection->findOne(array("email" => $email));
  if ($user) {
    return array(
      "first_name" => $user["first_name"],
      "last_name" => $user["last_name"],
      "email" => $user["email"],
      "age" => $user["age"]
    );
  } else {
    return null;
  }
}

function get_all_users($over18only = false)
{
  require "mongo-db.php";
  $collection = $db->selectCollection("users");
  $cursor = $collection->find();
  if ($over18only) {
    $cursor = $collection->find(['age' => ['$gt' => '18']]);
  }
  $users = array();
  foreach ($cursor as $user) {
    $users[] = array(
      "first_name" => $user["first_name"],
      "last_name" => $user["last_name"],
      "email" => $user["email"],
      "age" => $user["age"]
    );
  }
  return $users;
}
