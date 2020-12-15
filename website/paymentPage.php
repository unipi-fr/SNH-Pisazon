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

    <main class="central-form">

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
                <input type="text" class="form-control" id="cardNumber">
            </div>
            <div class="mb-3">
                <label for="owner" class="form-label">Owner</label>
                <input type="text" class="form-control" id="owner">
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">expire:</label>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="mm">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="yy">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label for="cvv" class="form-label">cvv</label>
                    <input type="text" class="form-control" id="cvv">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>
</body>

</html>