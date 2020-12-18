<?php session_start() ?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <?php include 'commonHeader.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.buy-button').click(function() {
                $.ajax({
                    type: "POST",
                    url: "paymentManager.php",
                    data: {
                        id: $(this).attr('id'),
                        action: "setItem"
                    }
                }).done(function(msg) {
                    window.location.replace("paymentPage.php");
                });
            });
        });
    </script>
</head>

<body class="with-navbar d-flex flex-column h-100">
    <header>
        <?php include 'navBar.php'; ?>
    </header>

    <main class="flex-shrink-0">
        <div class="container">
            <div class="row">
                <?php

                require "dbManager.php";
                require "drawer.php";

                $queryText = 'SELECT * FROM ebook';
                $result = $db->performQuery($queryText);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        drawCard($row["title"], $row["author"], $row["price"], $row["id"], "buy");
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">&copy; 2020 System Network Hacking - security.txt</span>
        </div>
    </footer>

    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>