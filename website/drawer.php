<?php
function drawCard($title, $author, $price, $id)
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
                        <?php if (isset($_SESSION['username'])) { ?>
                            <a href="./paymentPage.php" class="btn btn-primary cart-button float-right" <?php echo 'id="' . $id . '"' ?>> Buy </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>