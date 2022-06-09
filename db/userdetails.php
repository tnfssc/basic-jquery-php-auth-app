<?php
function user_details($email)
{
  require "db.php";
  $sql = "SELECT email, first_name, last_name FROM users WHERE email = '$email'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user = array(
      "email" => $row["email"],
      "first_name" => $row["first_name"],
      "last_name" => $row["last_name"]
    );
    return $user;
  } else {
    return null;
  }
}
