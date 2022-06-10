<?php
require_once "head.php";
?>

<body>
  <script type="module">
    import {
      html,
      render
    } from 'https://unpkg.com/lit-html@latest/lit-html.js';
    const over18only = (new URL(window.location.href)).searchParams.get('over18only') === "true";
    const data = await fetch('/api/allusers.php' + (over18only ? "?over18only=true" : "")).then(r => r.json());
    const rowTemplate = (user) => html `
          <tr>
            <td>${user.email}</td>
            <td>${user.first_name}</td>
            <td>${user.last_name}</td>
            <td>${user.age}</td>
            <td>
              <button class="btn btn-primary" @click="${(e) => console.log({ e, ...user })}">ConsoleLog</button>
            </td>
          </tr>
        `;
    const tableTemplate = (users) => html `
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Email</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Age</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              ${users.map(rowTemplate)}
            </tbody>
          </table>
        `;
    const root = document.getElementById("content");
    root.innerHTML = "";
    render(tableTemplate(data), root);
  </script>
  <script>
    function handleGoBack() {
      window.location.href = '/';
    }
    const over18only = (new URL(window.location.href)).searchParams.get('over18only') === "true";
  </script>
  <div>
    <div style="float: right;">
      <?php
      if (isset($_GET['over18only']) && $_GET['over18only'] === "true") {
        echo "
          <button id=\"over18only\" class=\"btn btn-success\" onclick=\"window.location.href = window.location.href.split(`?`)[0];\">Over 18 only</button>
        ";
      } else {
        echo "
          <button id=\"over18only\" class=\"btn btn-secondary\" onclick=\"window.location.href += `?over18only=true`;\">Over 18 only</button>
        ";
      }
      ?>
    </div>
    <div id="content">Loading...</div>
    <button type="button" class="btn btn-secondary " onclick="handleGoBack();">Back</button>
  </div>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
</body>

</html>