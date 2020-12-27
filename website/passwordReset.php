<?php

require_once "passwordResetLib.php";

if (isUserLogged()) {
    header('location: ./index.php');
}

$token = null;
if (isset($_GET["token"])) {
    $token = $_GET["token"];
}

if (isset($_POST["token"])) {
    $token = $_POST["token"];
}

if ($token !== null) {
    if (checkValidToken($token) !== false) {
        if (isset($_POST["password"]) && isset($_POST["confirmPassword"])) {
            if ($_POST["password"] === $_POST["confirmPassword"]) {
                if (changePasswordAndResetToken($_POST["password"]) === true) {
                    setSuccessMessage("Password changed <br> now you can log in with the new password");
                    header('location: ./login.php');
                }
            } else {
                setErrorMessage("Passowords don't match.");
            }
        }
    }
} else {
    resetSessionTokenUserId();
    setErrorMessage("Token not provided.");
}

?>

<!doctype html>
<html lang="en">

<head>
    <?php include 'commonHeader.php'; ?>
    <script src="./checks.js"></script>
</head>

<body class="with-navbar">
    <header>
        <?php include 'navBar.php'; ?>
    </header>
    <main>
        <div class="row mt-xl-5 text-center">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php if (isSessionTokenValid()) { ?>
                    <form class="central-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <h2 for="emailAddress" class="">Select a new password</h2>
                            <label for="inputPassword" class="form-label">Password</label>
                            <input name="password" type="password" id="inputPassword" class="form-control" required="" oninput="checkpassword()">
                            <?php include 'passwordChecks.php'; ?>
                            <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                            <input name="confirmPassword" type="password" id="inputConfirmPassword" class="form-control" required="">
                            <input name="token" type="text" class="d-none" value="<?php echo $token; ?>">
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" id="saveButton" class="btn btn-dark" disabled> Save </button>
                        </div>
                    </form>
                <?php } ?>
                <?php printErrorSessionMessage(); ?>
            </div>
            <div class="col-md-3"></div>
        </div>
    </main>
</body>

</html>