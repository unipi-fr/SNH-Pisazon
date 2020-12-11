<?php
session_start();
require "dbManager.php";
?>

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
                    url: "cartHandler.php/addItem",
                    data: {
                        id: $(this).attr('id'),
                        action: "deleteItem"
                    }
                }).done(function(msg) {
                    alert(msg);
                    location.reload();
                });
            });
        });
    </script>
</head>

<body class="with-navbar d-flex flex-column h-100" style="align-items: center;">
    <header>
        <?php include 'navBar.php'; ?>
    </header>

    <main class="flex-shrink-0">
        <div class="container">

            <?php foreach ($_SESSION['cart'] as $id) {
                $id = $db->sqlInjectionFilter($id);

                $queryText = 'SELECT * FROM ebook WHERE id = ' . $id;
                $result = $db->performQuery($queryText);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
            ?>
                    <div class="card mb-3" style="max-width: 600px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="assets/images/default-coverpage.jpg" class="card-img-top" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"> Title: <?php echo $row["title"] ?> </h5>
                                    <p class="card-text"> Author: <?php echo $row["author"] ?> </p>
                                    <p class="card-text"> Price: <?php echo $row["price"] ?> € </p>
                                    <a href="#" class="btn btn-primary cart-button" <?php echo 'id="'.$row["id"].'"'?>> delete from cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

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