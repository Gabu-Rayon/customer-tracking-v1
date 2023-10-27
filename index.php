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
$sql = "SELECT * FROM moreusers";
try {
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

include("inc/header.php");
include("inc/sidebar.php");
?>
      
      <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol> 
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            More Classifieds User's
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Country Code</th>
                                        <th>Language Code</th>
                                        <th>User Type</th>
                                        <th>Gender</th>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>About</th>
                                        <th>Auth {Email/Phone}</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Phone National</th>
                                        <th>Phone Country</th>
                                        <th>Phone Hidden</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Remember Token</th>
                                        <th>Is Admin</th>
                                        <th>Can Be Impersonated</th>
                                        <th>Disabled Comments</th>
                                        <th>IP Address</th>
                                        <th>Provider</th>
                                        <th>Provider Id</th>
                                        <th>Email Token</th>
                                        <th>Phone Token</th>
                                        <th>Email verified @</th>
                                        <th>Phone Verified @</th>
                                        <th>Accept Terms</th>
                                        <th>Accepts Marketing Offers</th>
                                        <th>Time Zone</th>
                                        <th>Blocked</th>
                                        <th>Closed</th>
                                        <th>Last Activity</th>
                                        <th>Last Login @</th>
                                        <th>Deleted @</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Affiliated Id</th>
                                        <th>Edit User</th>
                                        <th>Delete</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Country Code</th>
                                        <th>Language Code</th>
                                        <th>User Type</th>
                                        <th>Gender</th>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>About</th>
                                        <th>Auth {Email/Phone}</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Phone National</th>
                                        <th>Phone Country</th>
                                        <th>Phone Hidden</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Remember Token</th>
                                        <th>Is Admin</th>
                                        <th>Can Be Impersonated</th>
                                        <th>Disabled Comments</th>
                                        <th>IP Address</th>
                                        <th>Provider</th>
                                        <th>Provider Id</th>
                                        <th>Email Token</th>
                                        <th>Phone Token</th>
                                        <th>Email verified @</th>
                                        <th>Phone Verified @</th>
                                        <th>Accept Terms</th>
                                        <th>Accepts Marketing Offers</th>
                                        <th>Time Zone</th>
                                        <th>Blocked</th>
                                        <th>Closed</th>
                                        <th>Last Activity</th>
                                        <th>Last Login @</th>
                                        <th>Deleted @</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Affiliated Id</th>
                                        <th>Edit User</th>
                                        <th>Delete</th>

                                    </tr>
                                </tfoot>


                                <tbody>
                                    <?php foreach ($results as $row) : ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['country_code']; ?></td>
                                        <td><?php echo $row['language_code']; ?></td>
                                        <td> <?php echo $row['user_type_id'] == 1 ? 'Admin' : 'Normal User'; ?> </td>
                                        <td>
                                            <?php
                                                switch ($row['gender_id']) {
                                                    case 0:
                                                        echo 'Not Defined';
                                                        break;
                                                    case 1:
                                                        echo 'Male';
                                                        break;
                                                    case 2:
                                                        echo 'Female';
                                                        break;
                                                    case 3:
                                                        echo 'Transgender';
                                                        break;
                                                }
                                                ?>
                                        </td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><img src="users_images/<?php echo $row['photo']; ?>" alt="User Image"></td>
                                        <td><?php echo $row['about']; ?></td>
                                        <td><?php echo $row['auth_field']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['phone_national']; ?></td>
                                        <td><?php echo $row['phone_country']; ?></td>
                                        <td><?php echo $row['phone_hidden'] == 1 ? 'Hidden' : 'Not Hidden'; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['password']; ?></td>
                                        <td><?php echo $row['remember_token']; ?></td>
                                        <td><?php echo $row['is_admin'] == 1 ? 'Admin' : 'Normal User'; ?></td>
                                        <td><?php echo $row['can_be_impersonated'] == 1 ? 'Yes' : 'No'; ?></td>
                                        <td><?php echo $row['disable_comments'] == 1 ? 'Yes Disable' : 'No Enable'; ?>
                                        </td>
                                        <td><?php echo $row['ip_addr']; ?></td>
                                        <td><?php echo $row['provider']; ?></td>
                                        <td><?php echo $row['provider_id']; ?></td>
                                        <td><?php echo $row['email_token']; ?></td>
                                        <td><?php echo $row['phone_token']; ?></td>
                                        <td><?php echo $row['email_verified_at']; ?></td>
                                        <td><?php echo $row['phone_verified_at']; ?></td>
                                        <td><?php echo $row['accept_terms'] == 1 ? 'Yes' : 'No'; ?></td>
                                        <td><?php echo $row['accept_marketing_offers'] == 1 ? 'Yes' : 'No'; ?></td>
                                        <td><?php echo $row['time_zone']; ?></td>
                                        <td><?php echo $row['blocked'] == 1 ? 'Yes' : 'NO'; ?></td>
                                        <td><?php echo $row['closed'] == 1 ? 'Yes' : 'No'; ?></td>
                                        <td><?php echo $row['last_activity']; ?></td>
                                        <td><?php echo $row['last_login_at']; ?></td>
                                        <td><?php echo $row['deleted_at']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><?php echo $row['updated_at']; ?></td>
                                        <td><?php echo $row['affiliate_id'] == Null ? 'Null' : ''; ?></td>
                                        <td>
                                            <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
                                        </td>
                                        <td>
                                        <button onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>      
<?php 
    include("inc/footer.php");
 ?>
<script>
function confirmDelete(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
       
        $.ajax({
            url: 'delete_user.php',
            type: 'POST',
            data: { id: userId },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    } else {
    }
}
</script>

<?php 
}