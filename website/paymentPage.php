<?php session_start() ?>
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

        <?php if (isset($_SESSION['errorMessage'])) { ?>
            <div class="alert alert-danger mb-3" role="alert">
                <?php echo $_SESSION['errorMessage']; ?>
            </div>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php } ?>

        <form method="post" action="./paymentManager.php">
            <input name="action" value="payItem" type="hidden">
            <div class="mb-3">
                <label for="cardNumber" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="cardNumber" required pattern = "^[0-9 ]{19}$">
            </div>
            <div class="mb-3">
                <label for="owner" class="form-label">Owner</label>
                <input type="text" class="form-control" id="owner" required>
            </div>
            <div class="row mb-3">
                <div class="col-9">
                    <label class="form-label">expire:</label>
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select" required>
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
                            <select class="form-select" required>
                                <option value="16"> 2020</option>
                                <option value="17"> 2021</option>
                                <option value="18"> 2022</option>
                                <option value="19"> 2023</option>
                                <option value="20"> 2024</option>
                                <option value="21"> 2025</option>
                                <option value="21"> 2026</option>
                                <option value="21"> 2027</option>
                                <option value="21"> 2028</option>
                                <option value="21"> 2029</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="cvv" class="form-label">cvv</label>
                    <input type="text" class="form-control" id="cvv" required pattern="^[0-9]{3}$">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>
</body>

</html>