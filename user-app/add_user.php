<?php
$title = "Add";
$btn_title = "Save";
$user = $email = $pass = $mobile = ''; // Default empty values

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';
    $con = new PDO($dsn, $username, $password, $options);

    // Check if 'update' action is triggered by POST
    if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['id'])) {
        $id = htmlspecialchars($_POST['id']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $mobile = htmlspecialchars($_POST['mobile']);

        // Update the user in the database
        $sql = "UPDATE users SET username = :username, email = :email, password = :password, mobile = :mobile WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirect to index.php after updating
            header("Location: index.php");
            exit;
        }
    }
} elseif (isset($_GET['id'])) {
    // If the page is loaded for an update (GET request with ID), fetch the user details
    require_once 'config.php';
    $con = new PDO($dsn, $username, $password, $options);
    $id = htmlspecialchars($_GET['id']);
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt) {
        $title = 'Update';
        $current_user = $stmt->fetch(); // Fetch the user data
        if ($current_user) {
            $user = htmlspecialchars($current_user['username']);
            $email = htmlspecialchars($current_user['email']);
            $pass = htmlspecialchars($current_user['password']);
            $mobile = htmlspecialchars($current_user['mobile']);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>User-App</title>
</head>
<body>
    <div class="container">
        <div class="wrapper p-5 m-5">
            <div class="d-flex justify-content-between">
                <h2><?php echo $title; ?> User</h2>
                <div><a href="index.php"><i data-feather="corner-down-left"></i></a></div>
            </div>
        </div>
        <form action="index.php" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your name" autocomplete="off" required value="<?php echo $user; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" autocomplete="off" required value="<?php echo $email; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="off" required value="<?php echo $pass; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Mobile</label>
                <input type="tel" name="mobile" class="form-control" placeholder="Enter your mobile" autocomplete="off" required value="<?php echo $mobile; ?>">
            </div>
            <?php if (isset($_GET['id'])) { ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                <input type="hidden" name="action" value="update">
            <?php } ?>
            <input type="submit" class="btn btn-primary" value="<?php echo $btn_title; ?>" name="save">
        </form>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/icon.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
