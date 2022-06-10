<?php
require_once "head.php";
?>

<body>
  <script>
    function handleLogin() {
      const email = $('#email').val();
      const password = $('#password').val();

      if (!(/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/.test(email))) {
        alert('Invalid email');
        return;
      }
      if (!email || !password) {
        alert('Please fill in all fields');
        return;
      }
      if (password.length < 8) {
        alert('Password must be at least 8 characters');
        return;
      }

      const formData = new FormData();
      formData.append('email', email);
      formData.append('password', password);
      $.ajax({
        url: '/api/auth/login.php',
        type: 'POST',
        data: formData,
        success: function(data) {
          window.location.href = '/';
        },
        error: function(data) {
          alert('Invalid email or password');
        },
        processData: false,
        contentType: false,
      });
    }

    function handleLogout() {
      $.ajax({
        url: '/api/auth/logout.php',
        type: 'POST',
        success: function(data) {
          window.location.reload();
        },
        error: function(data) {
          alert('Some error occurred');
        },
      });
    }

    function handleRegister() {
      window.location.href = '/register.php';
    }

    function handleViewDetails() {
      window.location.href = '/mydetails.php';
    }

    function handleViewAllUsers() {
      window.location.href = '/allusers.php';
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
      <form>
        <div class=\"mb-3\">
          <label for=\"email\" class=\"form-label\">Email</label>
          <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Enter email\" required>
        </div>
        <div class=\"mb-3\">
          <label for=\"password\" class=\"form-label\">Password</label>
          <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Password\" required>
        </div>
        <button type=\"button\" class=\"btn btn-primary \" onclick=\"handleLogin();\">Login</button>
        <button type=\"button\" class=\"btn btn-secondary \" onclick=\"handleRegister();\">Register</button>
      </form>
    ");
  } else {
    exit("
      <div>
        <h1>Welcome, $email</h1>
      </div>
      <button class=\"btn btn-secondary \" onclick=\"handleViewDetails();\">My Details</button>
      <button class=\"btn btn-warning \" onclick=\"handleViewAllUsers();\">All Users</button>
      <button class=\"btn btn-danger \" onclick=\"handleLogout();\">Logout</button>
    ");
  }

  ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
</body>

</html>