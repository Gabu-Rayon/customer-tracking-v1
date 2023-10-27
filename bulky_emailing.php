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

    include("inc/header.php");
    include("inc/sidebar.php");
?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Send Email</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Email</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        More Classifieds Send Mail
                    </div>
                    <div class="card-body">
                        <form method="POST" action="send_email.php">
                            <div class="row mb-3">
                                <!-- <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" name="to" id="to" required>
                                            <option value="" disabled selected>Select an email</option>
                                            <?php
                                            // $twoHoursAgo = date("Y-m-d H:i:s", strtotime('-2 hours'));
                                            // $sql = $pdo->prepare("SELECT email FROM moreusers WHERE created_at <= :twoHoursAgo");
                                            // $sql->bindParam(':twoHoursAgo', $twoHoursAgo);
                                            // $sql->execute();

                                            // while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            //     $email = $row['email'];
                                            //     echo '<option value="' . $email . '">' . $email . '</option>';
                                            // }
                                            ?>
                                        </select>
                                         <label class="form-check-label" for="to">To:</label>
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" type="email" name="to" id="to" placeholder="Email Address" required />
                                        <label class="form-check-label" for="subject">To:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" type="text" name="subject" id="subject" placeholder="Suject" required />
                                        <label class="form-check-label" for="subject">Subject:</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <textarea class="form-control" type="text" cols="50" id="message" name="message" placeholder="Message:" required>
                                            </textarea>
                                        <label class="form-check-label" for="to">Message:</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><button class="btn btn-primary btn-block" name="send_email">Send Email</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    <?php
    include("inc/footer.php");
}
