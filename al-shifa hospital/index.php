<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Al-Shifa Hospital</title>
</head>
<body>
    <div class="main">
        <div class="logo">
            <h2>Al-Shifa Hospital</h2>
        </div>
        <div class="book">
            <p>Welcome to Al-Shifa Hospital</p>
            <form action="" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="date" name="date" required>
                <input type="submit" value="Book" name="submit">
            </form>
        </div>
    </div>
</body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $date = htmlspecialchars($_POST['date']);
    $send = htmlspecialchars($_POST['submit']);

    if(isset($send)){
        require_once 'config.php';
    try {
        $con = new PDO($dsn, $username, $password, $options);
        $sql = "INSERT INTO paitents (username, email, date) VALUES (:username, :email, :date)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        if ($stmt->execute()) {
            echo "<p style='color:green; font-weight:bold; text-align:center'>Booking Successful!</p>";
        } else {
            echo "<p style='color:red; font-weight:bold; text-align:center'>Booking Failed. Please Try Again.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red; font-weight:bold;'>Error: " . $e->getMessage() . "</p>";
    }
    }  
}

?>