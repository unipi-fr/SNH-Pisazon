<!doctype html>
<html lang="en" class="h-100">

<head>
    <?php include 'commonHeader.php'; ?>
    <link href="assets/dist/css/signin.css" rel="stylesheet">
    <title>Login Page</title>
</head>

<body class="text-center">
    <main class="form-signin">
        <form method="post" action="./loginManager.php">
            <img src="assets/images/icon.png" class="mb-4" height="60">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            </br>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <?php
            session_start();
            if (isset($_SESSION['errorMessage'])) {
                echo '<div class="alert alert-danger" role="alert">';
                echo $_SESSION['errorMessage'];
                echo '</div>';
                unset($_SESSION['errorMessage']);
            }
            ?>
            <p> Don't have an account yet? <a href="#" class="link-primary">Sign up</a></p>
        </form>
    </main>
</body>

</html>