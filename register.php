<?php
require_once "head.php";
?>

<body>
  <script>
    function handleRegister() {
      const email = $('#email').val();
      const password = $('#password').val();
      const confirmPassword = $('#password-confirm').val();
      const firstName = $('#first_name').val();
      const lastName = $('#last_name').val();
      const age = parseInt($('#age').val());

      if (!(/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/.test(email))) {
        alert('Invalid email');
        return;
      }
      if (!isNaN(age) && age < 0) {
        alert('Invalid age');
        return;
      }
      if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
      }
      if (!email || !password || !firstName || !lastName) {
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
      formData.append('first_name', firstName);
      formData.append('last_name', lastName);
      formData.append('age', age);

      $.ajax({
        url: '/api/auth/register.php',
        type: 'POST',
        data: formData,
        success: function(data) {
          alert("Successfully registered. Please login to continue.");
          window.location.href = '/';
        },
        error: function(data) {
          alert('Some error occurred. ' + error);
        },
        processData: false,
        contentType: false,
      });
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

  if (!($token == "" || $token == null || $email == "" || $email == null)) {
    exit("
      <script>
        window.location.href = '/';
      </script>
    ");
  } else {
    exit("
      <form>
        <div class=\"mb-3\">
          <label for=\"first_name\" class=\"form-label\">First Name</label>
          <input type=\"text\" class=\"form-control\" id=\"first_name\" placeholder=\"First Name\" required>
        </div>
        <div class=\"mb-3\">
          <label for=\"last_name\" class=\"form-label\">Last Name</label>
          <input type=\"text\" class=\"form-control\" id=\"last_name\" placeholder=\"Last Name\" required>
        </div>
        <div class=\"mb-3\">
          <label for=\"age\" class=\"form-label\">Age</label>
          <input type=\"number\" class=\"form-control\" id=\"age\" placeholder=\"Age\" required>
        </div>
        <div class=\"mb-3\">
          <label for=\"email\" class=\"form-label\">Email</label>
          <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Enter email\" required>
        </div>
        <div class=\"mb-3\">
          <label for=\"password\" class=\"form-label\">Password</label>
          <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Password\" required>
        </div>
        <div class=\"mb-3\">
          <label for=\"password-confirm\" class=\"form-label\">Confirm Password</label>
          <input type=\"password\" class=\"form-control\" id=\"password-confirm\" placeholder=\"Confirm Password\" required>
        </div>
        <button type=\"button\" class=\"btn btn-primary \" onclick=\"handleRegister();\">Register</button>
      </form>
    ");
  }

  ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
</body>

</html>