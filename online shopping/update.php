<?php

include('config.php');

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $price = $row['price'];
        $image = $row['image']; 
    } else {
        echo "Product not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    
    $image_up = $row['image'];  // Default to existing image if no new one is uploaded

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_location = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_up = "img/" . basename($image_name); 

        if (move_uploaded_file($image_location, $image_up)) {
            echo "Image upload successful";
        } else {
            echo "<script>alert('Image upload failed!')</script>";
        }
    }

    $sql = "UPDATE products SET name='$name', price='$price', image='$image_up' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <div class="main">
            <form action="update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <h2>Update Product</h2>
                <img src="img/cover.png" alt="logo" width="400px"><br><br>
                <input type="text" name="name" placeholder="Name of product" required value="<?php echo htmlspecialchars($name); ?>"><br><br>
                <input type="text" name="price" placeholder="Price of product" required value="<?php echo htmlspecialchars($price); ?>"><br><br>
                <input type="file" name="image" id="file" style="display:none;">
                <label for="file" style="cursor: pointer; color: #3498db; text-decoration: underline;">Update image</label><br><br>
                
                <input type="submit" name="upload" value="Update Product"><br><br>
                <a href="products.php">Show Products</a>
            </form>
        </div>
    </center>
</body>
</html>
