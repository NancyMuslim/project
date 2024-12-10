<?php
include ('config.php');

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);

        $sql = "DELETE FROM products WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: products.php"); // Redirect after successful deletion
            exit();
        } else {
            echo "Error query fails";  
        } 
        $stmt->close();
    } else {
        echo "No product ID received.";
    }
?>
