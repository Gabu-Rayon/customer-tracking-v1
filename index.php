<?php
session_start();
require_once("config.php");
if (empty($_SESSION['id'])) {
    header("Location: sign-in.php");
} else {

    $id = $_SESSION['id'];

    $countStmt = $pdo->query("SELECT COUNT(*) AS user_count FROM moreusers");
    $userCount = $countStmt->fetch(PDO::FETCH_ASSOC);

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
                    <li class="breadcrumb-item active"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        Total Users <?php echo  $userCount['user_count']; ?>
                    </li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        More Classifieds User's
                    </div>
                    <div class="card-body">

                        <!-- <div class="row col-4">
                            <div class="text-center">
                                <label for="user-type-filter">User Type:</label>
                                <select class="form-select d-inline p-2" aria-label="Default select example" id="user-type-filter">
                                    <option value="">All</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Normal User">Normal User</option>
                                </select>
                                <label for="sort-order">Sort By:</label>
                                <select class="form-select d-inline p-2" aria-label="Default select example" id="sort-order">
                                    <option value="id">ID</option>
                                    <option value="name">Name</option>
                                </select>
                            </div>
                        </div> -->

                        <br>
                        <table class="table table-striped" id="datatablesSimple">

                            <thead>
                                <tr>
                                    <th data-sort="id">ID</th>
                                    <th data-sort="country-code">Country Code</th>
                                    <th data-sort="langauge-code">Language Code</th>
                                    <th data-sort="user-type">User Type</th>
                                    <th data-sort="gender">Gender</th>
                                    <th data-sort="name">Name</th>
                                    <th data-sort="photo">Photo</th>
                                    <th data-sort="about">About</th>
                                    <th data-sort="auth">Auth {Email/Phone}</th>
                                    <th data-sort="email">Email</th>
                                    <th data-sort="phone">Phone</th>
                                    <th data-sort="phone-national">Phone National</th>
                                    <th data-sort="phone-country">Phone Country</th>
                                    <th data-sort="phone-hidden">Phone Hidden</th>
                                    <th data-sort="username">Username</th>
                                    <th data-sort="password">Password</th>
                                    <th data-sort="remember-token">Remember Token</th>
                                    <th data-sort="is-admin">Is Admin</th>
                                    <th data-sort="can-be-impersonated">Can Be Impersonated</th>
                                    <th data-sort="disabled-comments">Disabled Comments</th>
                                    <th data-sort="ip-address">IP Address</th>
                                    <th data-sort="provider">Provider</th>
                                    <th data-sort="provider-id">Provider Id</th>
                                    <th data-sort="email-token">Email Token</th>
                                    <th data-sort="phone-token">Phone Token</th>
                                    <th data-sort="email-verified">Email verified @</th>
                                    <th data-sort="phone-verified">Phone Verified @</th>
                                    <th data-sort="accept-terms">Accept Terms</th>
                                    <th data-sort="accepts-marketing-offers">Accepts Marketing Offers</th>
                                    <th data-sort="time-zone">Time Zone</th>
                                    <th data-sort="blocked">Blocked</th>
                                    <th data-sort="closed">Closed</th>
                                    <th data-sort="last-activity">Last Activity</th>
                                    <th data-sort="last-login">Last Login @</th>
                                    <th data-sort="deleted">Deleted @</th>
                                    <th data-sort="created-at">Created at</th>
                                    <th data-sort="updated-at">Updated at</th>
                                    <th data-sort="affiliated-at">Affiliated Id</th>
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
                                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="btn btn-danger">Delete</button>
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
                        data: {
                            id: userId
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + error);
                        }
                    });
                } else {}
            }
            // Function to filter and sort user data
            function filterAndSortUsers() {
                const userTypeFilter = $('#user-type-filter').val();
                const sortBy = $('#sort-order').val();

                $('tbody tr').hide();

                if (userTypeFilter) {
                    $(`td:contains('${userTypeFilter}')`).parent().show();
                } else {
                    $('tbody tr').show();
                }
                const rows = $('tbody tr:visible').toArray();
                rows.sort((a, b) => {
                    const aValue = $(a).find(`td[data-sort="${sortBy}"]`).text();
                    const bValue = $(b).find(`td[data-sort="${sortBy}"]`).text();
                    return aValue.localeCompare(bValue);
                });
                $('tbody').empty().append(rows);
            }

            $('#user-type-filter, #sort-order').on('change', filterAndSortUsers);

            //JavaScript for text search:
            $('#text-search').on('input', function() {
                const searchText = $(this).val().toLowerCase();
                $('tbody tr').hide().filter(function() {
                    return $(this).text().toLowerCase().includes(searchText);
                }).show();
            });
        </script>

    <?php
}
