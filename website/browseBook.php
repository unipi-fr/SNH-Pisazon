<?php
require "drawer.php";
require "bookManager.php"; ?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <?php include 'commonHeader.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.Buy-button').click(function() {
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

                $filter = "";
                if(isset($_GET['title']))
                    $filter = $_GET['title'];

                $numPages = getHowManyPages($filter);

                $activePage = 1;
                if (isset($_GET['page']) && is_numeric($_GET['page']))
                    $activePage = $_GET['page'];

                $books = getBooks($activePage, $filter);

                foreach ($books as $book) {
                    drawCard($book["title"], $book["author"], $book["price"], $book["id"], "Buy");
                }

                drawPaginationNav("browseBook.php", $numPages, $activePage);
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