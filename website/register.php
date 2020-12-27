<?php
require "sessionManager.php";

if (isUserLogged()) {
  header('location: index.php');
}

?>
<!doctype html>
<html lang="en">

<head>
  <?php include 'commonHeader.php'; ?>
  <link href="assets/dist/css/generalCentralForm.css" rel="stylesheet">

  <title>Pisazon Registration</title>

  <!-- Custom styles for this template -->
  <link href="assets/dist/css/registration-validation.css" rel="stylesheet">
</head>

<body class="text-center">
  <header>
    <?php include 'navBar.php'; ?>
  </header>



  <main class="central-form">
    <form class="needs-validation" method="post" action="registerManager.php">
      <h4 class="mb-3">Insert required data</h4>
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" name="username" id="username" placeholder="username" value="" required>

      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" value="" required>

      <hr class="my-4">

      <button class="w-100 btn btn-dark btn-lg" type="submit">Register</button>
    </form>
    <?php printErrorSessionMessage(); ?>
  </main>
</body>

</html>