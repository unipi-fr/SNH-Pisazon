<?php
require "drawer.php";
require "bookManager.php";

if (!isUserLogged()) {
    header('location: ./index.php');
}

function drawNoBookMessage()
{ ?>
    <div class="container">
        <p>
            It seems that you don't have buy yet any book. try to <a href="browseBook.php">browse our catalog</a> and see if you can find something interesting.
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
            </svg>
        </p>
    </div>
<?php
}
?>

<!doctype html>
<html lang="en">

<head>
    <?php include 'commonHeader.php'; ?>

    <script>
        function toggleChangePassword() {
            document.getElementById("change-password-form").classList.toggle('d-none');
            document.getElementById("change-password-button").classList.toggle('d-none');
        }
    </script>

    <script src="./checks.js"></script>
</head>

<body class="with-navbar">
    <header>
        <?php include 'navBar.php'; ?>
    </header>
    <main>
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3">
                    <img class="rounded-circle mt-5 img-responsive" src="assets/images/user-icon.png" style="width: 30%;">
                    <span class="font-weight-bold"><?php echo getSessionUsername(); ?></span>
                    <span class="text-black-50"><?php echo getSessionEmail(); ?></span>
                    <button type="button" class="btn btn-dark mt-3" id="change-password-button" onclick="toggleChangePassword()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                        </svg>
                        Change Password
                    </button>
                    <form id="change-password-form" class="d-none" action="profileManager.php" method='post'>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center experience">
                                <span>Edit Password</span>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="labels">Old password</label>
                                <input type="password" class="form-control" placeholder="old password" name="oldPassword">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="labels">New password</label>
                                <input type="password" class="form-control" id="inputPassword" placeholder="new super secret password" name="newPassword" oninput="checkpassword()">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="labels">Confirm password</label>
                                <input type="password" class="form-control" placeholder="confirm super secret password" name="confirmPassword">
                            </div>
                            <?php include 'passwordChecks.php'; ?>
                            <div class="col-md-12 mt-2">
                                <button type="submit" id="saveButton" class="btn btn-dark me-2" disabled>Save</button>
                                <button type="button" class="btn btn-secondary" onclick="toggleChangePassword()">Cancel</button>
                            </div>
                        </div>
                    </form>
                    <?php printErrorSessionMessage(); ?>
                    <?php printSuccessSessionMessage(); ?>
                </div>
            </div>
            <div class="col-md-9 border-right p-3">
                <div class="row d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">User's ebooks</h4>
                    <div class="container">
                        <div class="row">
                            <?php

                            $sessionUser = getSessionUserId();

                            $numPages = getHowManyPages("", $sessionUser);

                            $activePage = 1;
                            if (isset($_GET['page']) && is_numeric($_GET['page']))
                                $activePage = $_GET['page'];

                            $books = getBooks($activePage, "", $sessionUser);

                            if (sizeof($books) == 0) {
                                drawNoBookMessage();
                            } else {
                                foreach ($books as $book) {
                                    drawCard($book["title"], $book["author"], $book["price"], $book["id"], "Download");
                                }

                                drawPaginationNav("profilePage.php", $numPages, $activePage);
                            }
                            ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </main>
</body>

</html>