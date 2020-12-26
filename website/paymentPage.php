<?php
require_once "sessionManager.php";

if(!isUserLogged()){
    setErrorMessage("You must be logged in to buy a book.");
    header("location: login.php");
}

if (!checkBook()) {
    // we haven't clicked on a buy button in the BrowseBook page
    header("location: BrowseBook.php");
}
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <?php include 'commonHeader.php'; ?>
    <link href="assets/dist/css/generalCentralForm.css" rel="stylesheet">
</head>

<body class="text-center">
    <header>
        <?php include 'navBar.php'; ?>
    </header>

    <main class="central-form" style="max-width: 25rem;">

        <?php
            if(isUserLogged()){
                printSuccessSessionMessage();
                printErrorSessionMessage();
            }
            ?>

        <form id="form_payment" method="post" action="./paymentManager.php">
            <input name="action" value="payItem" type="hidden">
            <div class="mb-3">
                <label for="cardNumber" class="form-label">Card Number</label>
                <input name="cardNumber" type="text" class="form-control" id="cardNumber">
            </div>
            <div class="mb-3">
                <label for="owner" class="form-label">Owner</label>
                <input type="text" class="form-control" id="owner">
            </div>
            <div class="row mb-3">
                <div class="col-9">
                    <label class="form-label">expire:</label>
                    <div class="row mb-3">
                        <div class="col">
                            <select name="expireMonth" id="monthSelect" class="form-select">
                                <option value="01">January</option>
                                <option value="02">February </option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="expireYear" id="yearSelect" class="form-select">
                                <?php
                                date_default_timezone_set('Europe/Rome');
                                $currentYear =  date("Y");

                                for ($i = 0; $i < 10; $i++) {
                                    $year = $currentYear + $i; ?>
                                    <option <?php echo 'value="' . $year . '"' ?>> <?php echo $year ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="cvv" class="form-label">cvv</label>
                    <input name="cvv" type="text" class="form-control" id="cvv">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <script>
            var form = document.getElementById("form_payment");
            form.onsubmit = function(){
                form.reset();
            }
        </script>
    </main>
</body>

</html>