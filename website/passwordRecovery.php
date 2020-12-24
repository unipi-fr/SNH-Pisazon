<?php
require_once "passwordRecoveryLib.php";

if (isUserLogged()) {
    header('location: ./index.php');
}

if(isset($_POST["emailAddress"])){
    sendPasswordRecoveryEmail($_POST["emailAddress"]);
}
?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'commonHeader.php'; ?>
</head>

<body class="with-navbar">
    <header>
        <?php include 'navBar.php'; ?>
    </header>
    <main>
        <div class="row mt-xl-5 text-center">
            <div class = "col-md-3"></div>
            <div class = "col-md-6">
            <form class = "central-form" method ="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <h2 for="emailAddress" class="">Insert your email address</h2>
                    <input type="email" name="emailAddress" class="form-control form-control-lg" id="emailAddress" placeholder="name@example.com">
                </div>
                <div class="form-group mt-2">
                <button type="submit" class="btn btn-success">
                    Send email 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                    </svg>
                </button>
                </div>
            </form>
            <?php printSuccessSessionMessage() ?>
            <?php printErrorSessionMessage(); ?>
            </div>
            <div class = "col-md-3"></div>
        </div>
    </main>
</body>

</html>