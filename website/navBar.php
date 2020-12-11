<?php ?>
<!-- Fixed navbar -->
<nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-dark">
  <div class="container-fluid">
    <a href="index.php" class="pull-left me-2"><img src="assets/images/logo-white.png" style="height: 30px;" /></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="me-auto"></div>
      <form class="d-flex me-auto col-md-4">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn btn-outline-light" type="submit">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
          </svg>
        </button>
      </form>
      <ul class="navbar-nav">
        <?php if (!isset($_SESSION['username'])) { ?>
          <li class="nav-item active me-2">
            <a class="btn btn btn-outline-light" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-secondary" href="register.php">Register</a>
          </li>
        <?php } else { ?>
          <li class="nav-item active me-2">
            <a class="btn btn btn-outline-light" href=""><?php echo $_SESSION['username']; ?> </a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-secondary" href="cart.php">Carrello</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>