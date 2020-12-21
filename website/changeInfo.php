<?php ?>

<!doctype html>
<html lang="en" class="h-100">
    <header>
        <?php include 'commonHeader.php'; ?>
    </header>
    <body class="with-navbar">
        <header>
            <?php include 'navBar.php'; ?>
        </header>
        <main class="flex-shrink-0 d-flex flex-column h-100">
            <div class="container rounded bg-white mt-5 mb-5">
                <div class="row">
                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <img class="rounded-circle mt-5 img-responsive" src="assets/images/user-icon.png" style="width: 100%;">
                            <span class="font-weight-bold">Username</span>
                            <span class="text-black-50">user@mail.com</span>
                        </div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Info</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="labels">Username</label>
                                    <input type="text" class="form-control" placeholder="Username" value="currentUsername" readonly>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Current email</label>
                                    <input type="text" class="form-control" placeholder="current email" value="current@mail.com" readonly>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">New email</label>
                                    <input type="text" class="form-control" placeholder="new email" value="">
                                </div>
                            </div>

                            <div class="mt-5 text-center"><button class="btn btn-dark profile-button" type="button">Save Profile</button></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center experience">
                                <span>Edit Password</span>
                                <span class="border px-3 p-1 add-experience">
                        <i class="fa fa-plus">
                        </i>&nbsp;Experience</span>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label class="labels">Old password</label>
                                <input type="password" class="form-control" placeholder="old password" value="">
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label class="labels">New password</label>
                                <input type="password" class="form-control" placeholder="new super secret password" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>



