<?php
function drawCard($title, $author, $price, $id, $type)
{ ?>
    <div class="card mb-3 me-3" style="width: 18rem;">
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
                        <?php if (isset($_SESSION['username'])) {
                            if (!(strcmp($type, "Buy"))) { ?>
                                <a href="" <?php echo 'class="btn btn-primary ' . $type . '-button float-right" id="' . $id . '"' ?>> <?php echo $type ?> </a>
                            <?php }
                            if (!(strcmp($type, "Download"))) { ?>
                                <form method="get" action="/ebook/Libro1.pdf">
                                    <button type="submit" <?php echo 'class="btn btn-primary ' . $type . '-button float-right" id="' . $id . '"' ?>> <?php echo $type ?> </button>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>