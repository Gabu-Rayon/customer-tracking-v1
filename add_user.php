<?php
session_start();
 require_once("config.php");
if (empty($_SESSION['id'])) {
    header("Location: sign-in.php"); 
}else{
  
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
                    <h1 class="mt-4">Add New User</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">add New User</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Add New User
                        </div>
                        <div class="card-body">
                            <form method="POST" action="#" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-select" name="country_code" id="country_code">
                                                <option value="KE">Kenya</option>
                                                <option value="UG">Uganda</option>
                                                <option value="US">United States</option>
                                                <option value="CA">Canada</option>

                                            </select>
                                            <label for="country_code">Country Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-select" name="language_code" id="language_code">
                                                <option value="en">English</option>
                                                <option value="es">Spanish</option>
                                                <option value="SW">Swahili</option>
                                                <option value="FR">French</option>
                                            </select>
                                            <label for="language_code">Language Code</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-check-input" type="radio" name="user_type_id" id="male" value="1"> Admin
                                            <input class="form-check-input" type="radio" name="user_type_id" id="female" value="2"> Normal User
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-check-input" type="radio" name="gender_id" id="male" value="1"> Male
                                            <input class="form-check-input" type="radio" name="gender_id" id="female" value="2"> Female
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" type="text" id="name" name="name" placeholder="Enter your name" />
                                            <label class="form-check-label" for="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" type="file" name="photo" id="photo">
                                            <label class="form-check-label" for="photo">User Photo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-select" name="about" id="about">
                                                <option value="administrator">Administrator</option>
                                                <option value="user">User</option>
                                                <option value="customer">customer</option>
                                            </select>
                                            <label for="language_code">About</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" name="auth_field" id="auth_field">
                                                <option value="email">Email</option>
                                                <option value="phone">Phone</option>
                                            </select>
                                            <label for="language_code">Author Field</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" type="email" id="email" name="email" placeholder="Enter your Email" />
                                            <label class="form-check-label" for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" type="text" id="phone" name="phone" placeholder="Enter your Phone" />
                                            <label class="form-check-label" for="phone">Phone</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-select" name="phone_country" id="phone_country">
                                                <option value="KE">Kenya</option>
                                                <option value="TZ">Tanzania</option>
                                            </select>
                                            <label for="phone_country">Phone Country</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-check-input" type="radio" name="phone_hidden" id="phone_hidden" value="1"> Phone Hidden
                                            <input class="form-check-input" type="radio" name="phone_hidden" id="phone_not_hidden" value="0"> Phone Not Hidden
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" type="text" id="username" name="username" placeholder="Enter your Username" />
                                            <label class="form-check-label" for="username">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" type="password" id="password" name="password" placeholder="Enter your Password" />
                                            <label class="form-check-label" for="password">Pasword</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-check-input" type="radio" name="can_be_impersonated" id="can_be_impersonated" value="1"> Can Be Impersonated
                                            <input class="form-check-input" type="radio" name="can_be_impersonated" id="cannot_impersonated" value="0"> Cannot Be Impersonated
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-check-input" type="radio" name="is_admin" id="is_admin" value="1"> Is Admin
                                            <input class="form-check-input" type="radio" name="is_admin" id="is_not_admin" value="0"> Is Not Admin
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-check-input" type="radio" name="disable_comments" id="enable_comments" value="1"> Enable Comments
                                            <input class="form-check-input" type="radio" name="disable_comments" id="disable_comments" value="0"> Disable Comments
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" name="provider" id="provider">
                                                <option value="google">Google</option>
                                                <option value="facebook">Facebook</option>
                                                <option value="twitter">Twitter</option>
                                                <option value="linkedin">Linkedin</option>
                                            </select>
                                            <label for="provider">Provider</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-check-input" type="radio" name="email_verified_at" id="verify_email" value="1"> Verified Email
                                            <input class="form-check-input" type="radio" name="email_verefied_at" id="dont_verify_email" value="0"> Don't Verified Email
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-check-input" type="radio" name="phone_verified_at" id="verify_phone" value="1"> Verify Phone
                                            <input class="form-check-input" type="radio" name="phone_verfied_at" id="dont_verify_phone" value="0"> Don't Verify Phone
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-check-input" type="radio" name="accept_terms" id="accept_terms" value="1">Accepts Terms
                                            <input class="form-check-input" type="radio" name="accept_terms" id="dont_accept_terms" value="0">Don't Accept Terms
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-check-input" type="radio" name="accept_marketing_terms" id="accept_marketing_terms" value="1"> Accepts Marketing Terms
                                            <input class="form-check-input" type="radio" name="accept_marketing_terms" id="dont_accept_mareting_terms" value="0"> Accepts Marketing Terms
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-select" id="timeZone" name="timeZone">
                                                <option value="America/New_York">America/New York (EST/EDT)</option>
                                                <option value="America/Chicago">America/Chicago (CST/CDT)</option>
                                                <option value="America/Denver">America/Denver (MST/MDT)</option>
                                                <option value="America/Los_Angeles">America/Los Angeles (PST/PDT)</option>
                                            </select>
                                            <label for="timeZone">Select Time Zone:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-check-input" type="radio" name="blocked" id="blocked" value="1"> Block
                                            <input class="form-check-input" type="radio" name="blocked" id="dont_block" value="0"> Don't Block
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><button class="btn btn-primary btn-block" href="add_new_user">Add New User</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
<?php
include("inc/footer.php");   
}