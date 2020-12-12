<?php 
session_start();
require "sessionManager.php";
  
if(isUserLogged()){
  header('location: index.php');
}

?>
<!doctype html>
<html lang="en">

<head>
  <?php include 'commonHeader.php'; ?>

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

<title>Pisazon Registration</title>

  <!-- Custom styles for this template -->
  <link href="assets/dist/css/registration-validation.css" rel="stylesheet">
</head>

<body class="bg-light">
  <header>
    <?php include 'navBar.php'; ?>
  </header>


  <div class="container">
    <main>
      <div class="py-5 text-center">
      </div>

      <div class="row g-3">
        <h4 class="mb-3">Insert required data</h4>
        <form class="needs-validation" method="post" novalidate action="registerManager.php">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Tizio" value="" required>
              <div class="invalid-feedback">
                Please enter a valid username.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="" value="" required>
              <div class="invalid-feedback">
                Please enter a valid password.
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" value="" required>
              <div class="invalid-feedback">
                Please enter a valid email address.
              </div>
            </div>
          </div>

          <hr class="my-4">

          <button class="w-100 btn btn-dark btn-lg" type="submit">Register</button>
        </form>
      </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2020 Pisazon</p>
    </footer>
  </div>


  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

  <script src="assets/dist/js/registration-validation.js"></script>
</body>

</html>