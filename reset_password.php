<?php
session_start();
require_once("config.php");
if (empty($_SESSION['id'])) {
    header("Location: sign-in.php");
} else {

    $id = $_SESSION['id'];
    $sql = $pdo->prepare("SELECT * FROM `users` WHERE `id`='$id'");
    $sql->execute();
    $fetch = $sql->fetch();
    $user_name = $fetch['username'];
    $user_email = $fetch['email'];
    
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Password Reset</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Enter New Password to reset your password.</div>
                                        <form method="post" id="reset-form" action="reset_pwd.php">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="new-Password" name="new_password" type="password" placeholder="New Password" />
                                                <label for="newPassword">New Password</label>
                                                <div class="text-danger" id="new_password_error"></div>
                                            </div>

                                            <br>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="confirm-new-Password" name="confirm_new_password" type="password" placeholder="Confirm New Password" />
                                                <label for="newPassword">Confirm New Password</label>
                                                <div class="text-danger" id="confirm_new_password_error"></div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="sign-in.php">Return to Sign in</a>
                                                <button type="submit" id="reset" class="btn btn-primary" href="login.html">Reset Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script>
$(function() {
    // Function to clear error messages
    function clearErrors() {
        $("#new_password_error").text("");
        $("#confirm_password_error").text("");
    }

    // Attach an event listener to input fields to clear errors on input
    $('#reset-form input').on('input', function() {
        clearErrors();
    });

    $('#reset').click(function(e) {
        e.preventDefault();
        let self = $(this);
        self.prop('disabled', true);
        var data = $('#reset-form').serialize();
        $.ajax({
            url: 'reset_pwd.php',
            type: "POST",
            data: data,
        }).done(function(res) {
            res = JSON.parse(res);
            // Clear previous error messages
            clearErrors();
            if (res['status']) {
                location.href = res['redirect'];
            } else {
                if ('msg' in res) {
                    // Display error messages
                    $.each(res['msg'], function(key, message) {
                        $("#" + key + "_error").text(message);
                    });
                }
            }
            self.prop('disabled', false);
        }).fail(function() {
            alert("An error occurred");
            self.prop('disabled', false);
        });
    });
});
</script>
    </body>
</html>
<?php 
}