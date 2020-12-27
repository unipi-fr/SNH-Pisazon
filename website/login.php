<?php require_once "sessionManager.php";
if (isset($_SESSION['idUser'])) { // if we backtrace in the history we don't want to see this page again after loggin in  
    header("location: BrowseBook.php");
}
?>

<!doctype html>
<html lang="en" class="h-100">

<head>
    <?php include 'commonHeader.php'; ?>
    <link href="assets/dist/css/generalCentralForm.css" rel="stylesheet">
    <title>Login Page</title>
</head>

<body class="text-center">

    <header>
        <?php include 'navBar.php'; ?>
    </header>

    <main class="central-form">
        <form method="post" action="./loginManager.php">
            <img src="assets/images/icon.png" class="mb-4" height="60">
            <h1 class="h3 mb-3 fw-normal">Please login</h1>
            <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Your username" required="" autofocus="">
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Your super secret password" required="">
            </br>
            <button class="w-100 btn btn-lg btn-dark" type="submit">Login</button>
            <p>
                Don't have an account yet?
                <a href="register.php" class="link-dark">Register</a>
                <br>
                <a href="passwordRecovery.php" class="link-dark"> Did you forget your password? </a>
            </p>
        </form>
        <?php printSuccessSessionMessage() ?>
        <?php printErrorSessionMessage(); ?>
    </main>
</body>

</html>