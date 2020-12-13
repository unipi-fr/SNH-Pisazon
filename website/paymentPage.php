<?php session_start() ?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <?php include 'commonHeader.php'; ?>
</head>

<body class="with-navbar d-flex flex-column h-100">
    <header>
        <?php include 'navBar.php'; ?>
    </header>

    <main class="flex-shrink-0">
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
                            <input type="number" class="form-control" placeholder="month">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" placeholder="year">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label for="cvv" class="form-label">cvv</label>
                    <input type="number" class="form-control" id="cvv">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">&copy; 2020 System Network Hacking - security.txt</span>
        </div>
    </footer>

    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>