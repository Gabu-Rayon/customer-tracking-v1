<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form action="login.php" method="post" id="login-form">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="signin-email" name="email" type="email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                            <div class=" text-danger" id="email_error">
                                        </div>
                                        <br>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="signin-password" name="password" type="password" placeholder="Password" />
                                            <label for="inputPassword">Password</label>
                                            <div class=" text-danger" id="password_error">
                                        </div>
                                        <br>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember_me" value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#">Forgot Password?</a>
                                            <button type="submit" id="login" class="form-btn btn btn-primary" href="index.html">Sign in</button>
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
            $("#error-msg").hide();
            $('#login').click(function(e) {
                let self = $(this);
                e.preventDefault();

                self.prop('disabled', true);
                var data = $('#login-form').serialize();
                //clear  the error messages when user types in data
                $('#signin-email,#signin-password').on('input', function() {
                    $("#email_error").text("");
                    $("#password_error").text("");
                });
                // sending ajax request to login.php file
                $.ajax({
                    url: 'login.php',
                    type: "POST",
                    data: data,
                }).done(function(res) {
                    res = JSON.parse(res);
                    if (res['status']) {
                        location.href = res['redirect'];
                    } else {
                        // Clear previous error messages
                        $("#email_error").text("");
                        $("#password_error").text("");

                        if (res['msg']['email']) {
                            $("#email_error").text(res['msg']['email']);
                        }
                        if (res['msg']['password']) {
                            $("#password_error").text(res['msg']['password']);
                        }

                        self.prop('disabled', false);
                    }
                }).fail(function() {
                    alert("error");
                }).always(function() {
                    self.prop('disabled', false);
                });
            });
        });
    </script>
</body>

</html>