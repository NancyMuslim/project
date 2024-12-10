<?php
require_once 'config.php'; 

$action = false;
$users = [];

try {
    $con = new PDO($dsn, $username, $password, $options);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ensure the keys exist before using them to avoid warnings
        $user = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
        $pass = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
        $mobile = isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : '';

        if (isset($_POST['save'])) {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                // Update user
                $id = htmlspecialchars($_POST['id']);
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET username=:username, email=:email, mobile=:mobile, password=:password WHERE id=:id";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':username', $user, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_pass, PDO::PARAM_STR);
                $stmt->execute();
                $action = 'update';
            } else {
                // Add user
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, password, email, mobile) VALUES (:username, :password, :email, :mobile)";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':username', $user, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_pass, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
                $stmt->execute();
                $action = 'add';
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'del') {
            // Delete user
            $id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';
            if ($id !== '') {
                $sql = "DELETE FROM users WHERE id = :id";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $action = 'del';
            }
        }
    }

    // Fetch all users
    $users_sql = "SELECT * FROM users";
    $stmt = $con->prepare($users_sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p style='color:red; font-weight:bold;'>Error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/toaster.css"> 
    <title>User-App</title>
</head>
<body>
    <div class="container">
        <div class="wrapper p-5 m-5">
            <div class="d-flex justify-content-between">
                <h2>All Users</h2>
                <div><a href="add_user.php"><i data-feather="user-plus"></i> Add User</a></div>
            </div>
            <hr>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)) {
                        foreach ($users as $user) { ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['username']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars($user['mobile']); ?></td>
                            <td>
                                <div class="d-flex justify-content-evenly">
                                    <!-- Edit Button -->
                                    <i onclick="editUser(<?= $user['id']; ?>);" class="text-success" data-feather="edit" style="cursor: pointer;" title="Edit User"></i>

                                    <!-- Delete Button with Confirmation -->
                                    <i onclick="confirmDelete(<?= $user['id']; ?>);" class="text-danger" data-feather="trash-2" style="cursor: pointer;" title="Delete User"></i>
                                </div>
                            </td>
                        </tr>
                    <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">No users found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/toaster.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/icon.js"></script>
    <script>
        feather.replace();
        
        // Show toaster notification if an action was performed
        <?php if ($action) { ?>
            toaster.info('Action: <?= $action; ?> completed!');
        <?php } ?>

        // Confirm Deletion
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                // Create form and submit to delete user
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = 'index.php';

                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;
                form.appendChild(input);

                let actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'del';
                form.appendChild(actionInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Redirect to edit user page
        function editUser(id) {
            window.location.href = 'add_user.php?action=update&id=' + id;
        }
    </script>
</body>
</html>
