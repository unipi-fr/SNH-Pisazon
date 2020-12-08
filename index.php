<!doctype html>
<html lang="en" class="h-100">
  <head>
    <?php include 'commonHeader.php'; ?>
 

    <style>
      .blur{
        filter: blur(8px);
        -webkit-filter: blur(8px);

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      }
    </style>

    <!-- <style>
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
    </style>-->

    <title>Pisazon Homepage</title>
    
    <!-- Custom styles for this template -->
    <!-- <link href="sticky-footer-navbar.css" rel="stylesheet">-->
  </head>
  <body class="d-flex flex-column h-100">
    
<header>
  <?php include 'navBar.php'; ?>
</header>

<!-- Begin page content -->
<main class="flex-shrink-0">
<div class="card img-fluid">
  <img class="card-img-top blur" src="assets/images/pisa.jpg" alt="Card image">
  <div class="card-img-overlay container">
  <h1 class="mt-5">Sticky footer with fixed navbar</h1>
    <p class="lead">Pin a footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS. A fixed navbar has been added with <code class="small">padding-top: 60px;</code> on the <code class="small">main &gt; .container</code>.</p>
    <p>Back to <a href="examples/sticky-footer/">the default sticky footer</a> minus the navbar.</p>
  </div>
</div>
</main>

<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted">Place sticky footer content here.</span>
  </div>
</footer>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      
  </body>
</html>