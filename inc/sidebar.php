<div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading"> Addons</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users fa-fw"></i></div>
                            Users
                        </a>
                        <a class="nav-link" href="add_user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                            Add New user
                        </a>
                        <a class="nav-link" href="reset_password.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-bolt fa-fw"></i></div>
                            Reset Password
                        </a>
                        <a class="nav-link" href="bulky_emailing.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-envelope fa-fw"></i></div>
                            Email user
                        </a>
                        <a class="nav-link" href="bulky_sms.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-envelope fa-fw"></i></div>
                            Sms User
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $user_name; ?>.
                </div>
            </nav>
        </div>