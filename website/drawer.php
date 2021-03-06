<?php
function drawCard($title, $author, $price, $id, $type)
{ ?>
    <div class="card border-secondary mb-3 me-3" style="width: 19rem;">
        <img src="assets/images/default-coverpage.jpg" class="card-img-top" alt="coverpage">
        <div class="card-body">
            <h5 class="card-title">Title: <?php echo $title ?></h5>
            <p class="card-text"> Author: <?php echo $author ?> </p>
            <div class="container">
                <div class="row">
                    <div class="col md-6">
                        <p class="card-text"> Price: <?php echo $price ?>€ </p>
                    </div>
                    <div class="col md-6">
                        <?php
                            if (!(strcmp($type, "Buy"))) { ?>
                                <a href="" <?php echo 'class="btn btn-dark ' . $type . '-button float-right" id="' . $id . '"' ?>> <?php echo $type ?> </a>
                            <?php }
                            if (!(strcmp($type, "Download"))) { ?>
                                <a <?php echo 'href="downloadBook.php?book=' . $id . '"' ?> class="btn btn-dark float-right"> <?php echo $type ?> </a>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
function drawPaginationNav($page, $numPages, $activePage)
{ ?>
    <nav>
        <ul class="pagination justify-content-center">

            <li class="page-item <?php if ($activePage == 1) echo 'disabled'; ?> ">
                <a class="page-link text-dark" <?php echo 'href="' . $page . '?page=' . ($activePage - 1) . '"' ?>>Previous</a>
            </li>
            <?php
            $endPage = $numPages;
            $startPage = $activePage - 2;

            if ($numPages > 5) {
                if ($startPage + 5 <= $numPages) {
                    if ($activePage < 3)
                        $startPage = 1;
                    $endPage = $startPage + 4;
                } else {
                    $startPage = $numPages - 4;
                }
            } else {
                $startPage = 1;
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $activePage) { ?>
                    <li class="page-item"><a class="page-link text-light bg-dark" <?php echo 'href="' . $page . '?page=' . $i . '"'; ?>> <?php echo $i; ?> </a></li>
                <?php } else { ?>
                    <li class="page-item"><a class="page-link text-dark" <?php echo 'href="' . $page . '?page=' . $i . '"'; ?>> <?php echo $i; ?> </a></li>
                <?php } ?>
            <?php } ?>

            <li class="page-item <?php if ($activePage == $numPages) echo 'disabled'; ?> ">
                <a class="page-link text-dark" <?php echo 'href="' . $page . '?page=' . ($activePage + 1) . '"' ?>>Next</a>
            </li>
        </ul>
    </nav>
<?php } ?>