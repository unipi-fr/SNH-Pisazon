<?php session_start(); ?>
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <?php include 'commonHeader.php'; ?>
    <title>Pisazon Homepage</title>
    
    <!-- Custom styles for this template -->
    <!-- <link href="sticky-footer-navbar.css" rel="stylesheet">-->
  </head>
  <body class="with-navbar d-flex flex-column h-100">
        
    <header>
      <?php include 'navBar.php'; ?>
    </header>
    <?php if (false){?>
    <div class="card img-fluid">
        <img class="card-img-top img-blur" src="assets/images/pisa-background.jpg" alt="Card image">
        <div class="card-img-overlay container">
            <h1>Home Page</h1>
            <p class="lead">This part of the website is on custruction.</p>
            <p>Be patient, we are working for you.</p>
        </div>
    </div>
    <?php }?>

    <!-- Begin page content -->
    <div class="container">
        <div class="row">
            <?php for ($i = 1; $i < 10; $i++) { ?>
                <div class="card col-auto mb-3 me-3" style="width: 18rem;">
                    <img src="assets/images/default-coverpage.jpg" class="card-img-top" alt="coverpage">
                    <div class="card-body">
                        <h5 class="card-title">Book <?php echo $i ?></h5>
                        <p class="card-text">Some text here for the description</p>
                        <a href="#" class="btn btn-primary">99 €</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
      <div class="container">
        <span class="text-muted">&copy; 2020 System Network Hacking - security.txt</span>
      </div>
    </footer>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>