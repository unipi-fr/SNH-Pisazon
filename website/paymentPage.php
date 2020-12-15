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
                <input type="text" class="form-control" id="cardNumber" required pattern="^[0-9 ]{19}$">
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
                            <select id="monthSelect" class="form-select" onchange="checkDate()" required>
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
                            <select id="yearSelect" class="form-select" onchange="checkDate()" required>
                                <option value="2020"> 2020</option>
                                <option value="2021"> 2021</option>
                                <option value="2022"> 2022</option>
                                <option value="2023"> 2023</option>
                                <option value="2024"> 2024</option>
                                <option value="2025"> 2025</option>
                                <option value="2026"> 2026</option>
                                <option value="2027"> 2027</option>
                                <option value="2028"> 2028</option>
                                <option value="2029"> 2029</option>
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

    <script>
        function checkDate() {
            var month = document.getElementById("monthSelect").value;
            var year = document.getElementById("yearSelect").value;

            var d = new Date();

            var currentMonth = d.getMonth() + 1;
            var currentYear = d.getFullYear();

            if ((year < currentYear) || (year == currentYear && month <= currentMonth)) {
                
            }
            
        }
    </script>
</body>

</html>