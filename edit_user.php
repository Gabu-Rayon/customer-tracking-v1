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
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
        
        $newName = $_POST['name'];
        $newCountryCode = $_POST['country_code'];
        $newLanguageCode = $_POST['language_code'];
        $newUserTypeId = $_POST['user_type_id'];
        $newGenderId = $_POST['gender_id'];
        $newAbout = $_POST['about'];
        $newAuthField = $_POST['auth_field'];
        $newEmail = $_POST['email'];
        $newPhone = $_POST['phone'];
        $newPhoneNational = $_POST['phone_national'];
        $newPhoneCountry = $_POST['phone_country'];
        $newPhoneHidden = $_POST['phone_hidden'];
        $newUsername = $_POST['username'];
        $newIsAdmin = $_POST['is_admin'];
        $newCanBeImpersonated = $_POST['can_be_impersonated'];
        $newDisableComments = $_POST['disable_comments'];
        $newProvider = $_POST['provider'];
        $newProviderId = $_POST['provider_id'];
        $newBlocked = $_POST['blocked'];
        $newClosed = $_POST['closed'];

        
        if ($_FILES['photo']['name']) {
            $photo = $_FILES['photo'];
            $photoName = $photo['name'];
            $photoTmpName = $photo['tmp_name'];
            $photoType = $photo['type'];

            
            $uploadDirectory = 'users_images/';

            
            $photoFileName = uniqid('photo_') . '_' . $photoName;

            
            $targetPath = $uploadDirectory . $photoFileName;
            move_uploaded_file($photoTmpName, $targetPath);
        } else {
            $stmtPhoto = $pdo->prepare("SELECT photo FROM moreusers WHERE id = :id");
            $stmtPhoto->bindParam(':id', $userId);
            $stmtPhoto->execute();
            $existingPhoto = $stmtPhoto->fetchColumn();
            $photoFileName = $existingPhoto;
        }
        try {
            $stmt = $pdo->prepare("UPDATE moreusers SET
                name = :name,
                country_code = :country_code,
                language_code = :language_code,
                user_type_id = :user_type_id,
                gender_id = :gender_id,
                about = :about,
                auth_field = :auth_field,
                email = :email,
                phone = :phone,
                phone_national = :phone_national,
                phone_country = :phone_country,
                phone_hidden = :phone_hidden,
                username = :username,
                is_admin = :is_admin,
                can_be_impersonated = :can_be_impersonated,
                disable_comments = :disable_comments,
                provider = :provider,
                provider_id = :provider_id,
                blocked = :blocked,
                closed = :closed,
                photo = :photo
                WHERE id = :id");

            $stmt->bindParam(':id', $userId);
            $stmt->bindParam(':name', $newName);
            $stmt->bindParam(':country_code', $newCountryCode);
            $stmt->bindParam(':language_code', $newLanguageCode);
            $stmt->bindParam(':user_type_id', $newUserTypeId);
            $stmt->bindParam(':gender_id', $newGenderId);
            $stmt->bindParam(':about', $newAbout);
            $stmt->bindParam(':auth_field', $newAuthField);
            $stmt->bindParam(':email', $newEmail);
            $stmt->bindParam(':phone', $newPhone);
            $stmt->bindParam(':phone_national', $newPhoneNational);
            $stmt->bindParam(':phone_country', $newPhoneCountry);
            $stmt->bindParam(':phone_hidden', $newPhoneHidden);
            $stmt->bindParam(':username', $newUsername);
            $stmt->bindParam(':is_admin', $newIsAdmin);
            $stmt->bindParam(':can_be_impersonated', $newCanBeImpersonated);
            $stmt->bindParam(':disable_comments', $newDisableComments);
            $stmt->bindParam(':provider', $newProvider);
            $stmt->bindParam(':provider_id', $newProviderId);
            $stmt->bindParam(':blocked', $newBlocked);
            $stmt->bindParam(':closed', $newClosed);
            $stmt->bindParam(':photo', $photoFileName);

            $stmt->execute();
            echo '<script>alert("User Updated Successfully")</script>';
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM moreusers WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    header("Location: index.php"); 
    exit();
}
include("inc/header.php");
include("inc/sidebar.php");
?>
 <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit User</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Edit User
                        </div>
                        <div class="card-body">
                            <main>
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                                <div class="card-header">
                                                    <h3 class="text-center font-weight-light my-4">Edit User</h3>
                                                </div>
                                                <div class="card-body">
                                                    <form method="POST" action="#" enctype="multipart/form-data">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <select class="form-select" name="country_code" id="country_code" required>
                                                                        <option value="KE" <?php if ($user['country_code'] == "KE") echo "selected"; ?>>Kenya</option>
                                                                        <option value="TZ" <?php if ($user['country_code'] == "TZ") echo "selected"; ?>>Tanzania</option>
                                                                        <option value="UG" <?php if ($user['country_code'] == "UG") echo "selected"; ?>>Uganda</option>
                                                                        <option value="US" <?php if ($user['country_code'] == "US") echo "selected"; ?>>United States</option>
                                                                        <option value="UK" <?php if ($user['country_code'] == "UK") echo "selected"; ?>>United Kingdom</option>
                                                                        <option value="ET" <?php if ($user['country_code'] == "ET") echo "selected"; ?>>Ethiopia</option>
                                                                    </select>
                                                                    <label for="CountryCode">Country Code</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating">
                                                                    <select class="form-select" name="language_code" id="language_code" required>
                                                                        <option value="ENG" <?php if ($user['language_code'] == "ENG") echo "selected"; ?>>English</option>
                                                                        <option value="SW" <?php if ($user['language_code'] == "SW") echo "selected"; ?>>Swahili</option>
                                                                        <option value="FRE" <?php if ($user['language_code'] == "FRE") echo "selected"; ?>>French</option>
                                                                    </select><label for="langaugeCode">Langauge Code</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="radio" name="user_type_id" value="1" <?php if ($user['user_type_id'] == 1) echo "checked"; ?>> Admin(User Type)
                                                            <input type="radio" name="user_type_id" value="2" <?php if ($user['user_type_id'] == 2) echo "checked"; ?>> Normal User (UserType)
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input type="radio" name="gender_id" value="0" <?php if ($user['gender_id'] == 0) echo "checked"; ?>> Not Specified
                                                                    <input type="radio" name="gender_id" value="1" <?php if ($user['gender_id'] == 1) echo "checked"; ?>> Male
                                                                    <input type="radio" name="gender_id" value="2" <?php if ($user['gender_id'] == 2) echo "checked"; ?>> Female
                                                                    <input type="radio" name="gender_id" value="3" <?php if ($user['gender_id'] == 3) echo "checked"; ?>> Others
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="name" type="text" name="name" value="<?php echo $user['name']; ?>" placeholder="Name" required="required" />
                                                                    <label for="name">Name</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="photo" type="file" name="photo" placeholder="Photo" accept=".jpg, .jpeg, .png" required="required" />
                                                                    <img src="users_images/<?php echo $user['photo']; ?>" height="40" width="40" alt="User Photo">
                                                                    <label for="UserPhoto">User Photo</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="about" type="text" name="about" value="<?php echo $user['about']; ?>" placeholder="About" required="required" />
                                                                    <label for="about">About</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="authField" type="text" name="auth_field" value="<?php echo $user['auth_field']; ?>" placeholder="Auth" required="required" />
                                                                    <label for="authField">Auth</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="emai" type="email" name="emal" value="<?php echo $user['email']; ?>" placeholder="Email" required="required" />
                                                                    <label for="email">Email</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="phone" type="text" name="phone" value="<?php echo $user['phone']; ?>" placeholder="phone" required="required" />
                                                                    <label for="phone">Phone</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="phone_national" type="text" name="phone_national" value="<?php echo $user['phone_national']; ?>" placeholder="Phone National" required="required" />
                                                                    <label for="phoneNational">Phone National</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <select class="form-select" name="phone_country" id="phone_country" required>
                                                                        <option value="KE" <?php if ($user['phone_country'] == "KE") echo "selected"; ?>>Kenya</option>
                                                                        <option value="UG" <?php if ($user['phone_country'] == "UG") echo "selected"; ?>>Uganda</option>
                                                                        <option value="TZ" <?php if ($user['phone_country'] == "TZ") echo "selected"; ?>>Tanzania</option>
                                                                    </select>
                                                                    <label for="phoneCountry">Phone Country</label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input type="radio" name="phone_hidden" value="0" <?php if ($user['phone_hidden'] == 0) echo "checked"; ?>>  Don't Hidden Phone
                                                                    <input type="radio" name="phone_hidden" value="1" <?php if ($user['phone_hidden'] == 1) echo "checked"; ?>> Hidden Phone
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="username" type="text" name="username" value="<?php echo $user['username']; ?>" placeholder="User Name" required="required" />
                                                                    <label for="username">Username</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                <input type="radio" name="is_admin" value="0" <?php if ($user['is_admin'] == 0) echo "checked"; ?>> Is Admin
                                                                    <input type="radio" name="is_admin" value="1" <?php if ($user['is_admin'] == 1) echo "checked"; ?>>Not Admin
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                <input type="radio" name="can_be_impersonated" value="0" <?php if ($user['can_be_impersonated'] == 0) echo "checked"; ?>> Cannot be impersonated
                                                                    <input type="radio" name="can_be_impersonated" value="1" <?php if ($user['can_be_impersonated'] == 1) echo "checked"; ?>> can be impersonated
                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input type="radio" name="disable_comments" value="0" <?php if ($user['disable_comments'] == 0) echo "checked"; ?>> Enable Comments
                                                                    <input type="radio" name="disable_comments" value="1" <?php if ($user['disable_comments'] == 1) echo "checked"; ?>> Disable Comments
                                                               
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <select class="form-select" name="provider" id="provider" required>
                                                                        <option value="facebook" <?php if ($user['provider'] == "facebook") echo "selected"; ?>>Facebook</option>
                                                                        <option value="google" <?php if ($user['provider'] == "google") echo "selected"; ?>>Google</option>
                                                                        <option value="twitter" <?php if ($user['provider'] == "twitter") echo "selected"; ?>>Twitter</option>
                                                                        <option value="linkedin" <?php if ($user['provider'] == "linkedin") echo "selected"; ?>>LinkedIn</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input class="form-control" id="provider_id" type="text" name="provider_id" value="<?php echo $user['provider_id']; ?>" placeholder="provider Id" required="required" />
                                                                    <label for="providerId">Provider Id</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                <input type="radio" name="blocked" value="0" <?php if ($user['blocked'] == 0) echo "checked"; ?>> Not Blocked
                                                                    <input type="radio" name="blocked" value="1" <?php if ($user['blocked'] == 1) echo "checked"; ?>> Blocked
                                                               
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3 mb-md-0">
                                                                    <input type="radio" name="closed" value="0" <?php if ($user['closed'] == 0) echo "checked"; ?>> Not Closed
                                                                    <input type="radio" name="closed" value="1" <?php if ($user['closed'] == 1) echo "checked"; ?>> Closed

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-4 mb-0">
                                                            <div class="d-grid"><button class="btn btn-primary btn-block" name="update_user">Update User</button></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </main>
            <?php
include("inc/footer.php"); 
}