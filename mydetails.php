<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Basic Auth App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
  <script>
    function handleGoBack() {
      window.location.href = '/';
    }
  </script>
  <?php
  $token = "";
  $email = "";

  if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
  }
  if (isset($_COOKIE['email'])) {
    $email = $_COOKIE['email'];
  }

  if ($token == "" || $token == null || $email == "" || $email == null) {
    exit("
      <script>
        window.location.href = '/';
      </script>
    ");
  } else {
    require "db/mongo-auth.php";
    if (!verify_token($token, $email)) {
      exit("
        <script>
          window.location.href = '/';
        </script>
      ");
    }

    require "db/mongo-userdetails.php";

    $user = user_details($email);

    if ($user == null) {
      exit("
        <script>
          window.location.href = '/';
        </script>
      ");
    }
    exit("
      <div>
        <div class=\"mb-3\">
          <label for=\"first_name\" class=\"form-label\">First Name</label>
          <input type=\"text\" class=\"form-control\" id=\"first_name\" placeholder=\"First Name\" value=\"$user[first_name]\" readonly>
        </div>
        <div class=\"mb-3\">
          <label for=\"last_name\" class=\"form-label\">Last Name</label>
          <input type=\"text\" class=\"form-control\" id=\"last_name\" placeholder=\"Last Name\" value=\"$user[last_name]\" readonly>
        </div>
        <div class=\"mb-3\">
          <label for=\"email\" class=\"form-label\">Email</label>
          <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Enter email\" value=\"$user[email]\" readonly>
        </div>
        <button type=\"button\" class=\"btn btn-secondary \" onclick=\"handleGoBack();\">Back</button>
      </div>
    ");
  }

  ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
</body>

</html>