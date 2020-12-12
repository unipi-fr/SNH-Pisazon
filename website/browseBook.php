<?php session_start() ?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <?php include 'commonHeader.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.cart-button').click(function() {
                $.ajax({
                    type: "POST",
                    url: "cartHandler.php",
                    data: {
                        id: $(this).attr('id'),
                        action: "addItem"
                    }
                }).done(function(msg) {
                    alert(msg);
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
        <?php

        require "dbManager.php";

        $queryText = 'SELECT * FROM ebook';
        $result = $db->performQuery($queryText);

        if ($result->num_rows > 0) { ?>

            <div class="container">
                <div class="row">

                    <?php while ($row = $result->fetch_assoc()) { ?>

                        <div class="card col-auto mb-3 me-3" style="width: 15rem;">
                            <img src="assets/images/default-coverpage.jpg" class="card-img-top" alt="coverpage">
                            <div class="card-body">
                                <h5 class="card-title">Title: <?php echo $row["title"] ?></h5>
                                <p class="card-text"> Author: <?php echo $row["author"] ?> </p>
                                <div>
                                    <p class="card-text me-auto" style="padding-top:0.5rem"> Price: <?php echo $row["price"] ?>€ </p>
                                    <?php if (isset($_SESSION['username'])) { ?>
                                        <a href="#" class="btn btn-primary cart-button pull-right" <?php echo 'id="' . $row["id"] . '"' ?>> Buy </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">&copy; 2020 System Network Hacking - security.txt</span>
        </div>
    </footer>

    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>