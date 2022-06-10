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
      "email" => $user["email"]
    );
  } else {
    return null;
  }
}
