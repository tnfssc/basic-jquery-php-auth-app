<?php
require_once "head.php";
?>

<body>
  <script>
    function handleGoBack() {
      window.location.href = '/';
    }
    $.ajax({
      url: "api/mydetails.php",
      type: "GET",
      success: function(_data) {
        const data = JSON.parse(_data);
        $("#first_name").val(data.first_name);
        $("#last_name").val(data.last_name);
        $("#email").val(data.email);
        $("#age").val(data.age);
      },
      error: function(data) {
        alert("Error: " + JSON.stringify(data));
      }
    });
  </script>
  <div>
    <div class="mb-3">
      <label for="first_name" class="form-label">First Name</label>
      <input type="text" class="form-control" id="first_name" placeholder="First Name" value="Loading" readonly>
    </div>
    <div class="mb-3">
      <label for="last_name" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="last_name" placeholder="Last Name" value="Loading" readonly>
    </div>
    <div class="mb-3">
      <label for="age" class="form-label">Age</label>
      <input type="number" class="form-control" id="age" placeholder="Age" value="Loading" readonly>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" value="Loading" readonly>
    </div>
    <button type="button" class="btn btn-secondary " onclick="handleGoBack();">Back</button>
  </div>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
</body>

</html>