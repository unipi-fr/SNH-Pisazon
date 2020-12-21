<?php
require "sessionManager.php";
require "dbManager.php";
require "drawer.php";
?>

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
        <div class="container">
            <div class="row">
                <?php global $db;
                $conn = $db->getConn();
                $searchBuyedBookStatement = $conn->prepare("SELECT id_ebook FROM orders WHERE id_buyer = ?");
                $searchBuyedBookStatement->bind_param("s", $_SESSION['idUser']);

                $searchBuyedBookStatement->execute();
                $searchBuyedBookStatement->store_result();

                $numRow = $searchBuyedBookStatement->num_rows;

                $buyedEbooks = array();
                if ($numRow > 0) {
                    $searchBuyedBookStatement->bind_result($idEbook);

                    while ($searchBuyedBookStatement->fetch()) {
                        $buyedEbooks[] = $idEbook;
                    }
                }

                $searchBuyedBookStatement->free_result();
                $searchBuyedBookStatement->close();

                foreach ($buyedEbooks as $ebook) {
                    $bookStatement = $conn->prepare("SELECT * FROM ebook WHERE id = ?");
                    $bookStatement->bind_param("s", $ebook);

                    $bookStatement->execute();
                    $bookStatement->store_result();

                    $numRow = $bookStatement->num_rows;

                    $bookStatement->bind_result($idEbook, $title, $author, $price);

                    $bookStatement->fetch();

                    drawCard($title, $author, $price, $idEbook, "Download");

                    $bookStatement->free_result();
                    $bookStatement->close();
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