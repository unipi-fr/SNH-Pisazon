<?php
require_once "passwordResetLib.php";

if (isUserLogged()) {
    header('location: ./index.php');
}

if(isset($_GET["token"])){
    if(checkValidToken($_GET["token"]) !== false){

    }
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
            <?php if(isSessionTokenValid()){?>
                <form class = "central-form" method ="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <h2 for="emailAddress" class="">Select a new password</h2>
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" id="inputPassword" class="form-control" required="">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input name="confirmPassword" type="password" id="inputConfirmPassword" class="form-control" required="">
                    </div>
                    <div class="form-group mt-2">
                    <button type="submit" class="btn btn-success"> Save </button>
                    </div>
                </form>
            <?php } else { ?>
                <form class = "central-form" method ="get" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <h2>Insert the token that you recivied by email</h2>
                        <input name="token" type="text" id="inputToken" class="form-control" required="">
                    </div>
                    <div class="form-group mt-2">
                    <button type="submit" class="btn btn-success"> Reset password </button>
                    </div>
                </form>
            <?php } ?>
            
            <?php printSuccessSessionMessage() ?>
            <?php printErrorSessionMessage(); ?>
            </div>
            <div class = "col-md-3"></div>
        </div>
    </main>
</body>

</html>