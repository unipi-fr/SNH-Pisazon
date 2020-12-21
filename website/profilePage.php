<?php 
require "sessionManager.php";
require "dbManager.php";

if (!isUserLogged()){
    header('location: ./index.php');
}
?>

<!doctype html>
<html lang="en">
    <header>
        <?php include 'commonHeader.php'; ?>

        <script>
            function toggleChangePassword(){
                document.getElementById("change-password-form").classList.toggle('d-none');
                document.getElementById("change-password-button").classList.toggle('d-none');
            }

        </script>


    </header>
    <body class="with-navbar">
        <header>
            <?php include 'navBar.php'; ?>
        </header>
        <main>
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3">
                        <img class="rounded-circle mt-5 img-responsive" src="assets/images/user-icon.png" style="width: 30%;">
                        <span class="font-weight-bold">Username</span>
                        <span class="text-black-50">user@mail.com</span>
                        <button type="button" class="btn btn-dark mt-3" id="change-password-button" onclick="toggleChangePassword()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
                                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            Change Password
                        </button>
                        <form id = "change-password-form" class="d-none" action="profileManager.php" method='post'>
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
                                    <input type="password" class="form-control" placeholder="new super secret password" name="newPassword">
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button type="submit" class="btn btn-dark me-2">Save</button>
                                    <button type="button" class="btn btn-secondary" onclick="toggleChangePassword()">Cancel</button>
                                </div>
                            </div>
                        </form>
                        <?php printErrorSessionMessage(); ?>
                        <?php printSuccessSessionMessage(); ?>
                    </div>
                </div>
                <div class="col-md-auto border-right p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">User's ebooks</h4>
                    </div>
                        

                </div>
            </div>
    
        </main>
    </body>
</html>


