<?php

include ('config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['update'])){
        $id = htmlspecialchars($_GET['id']);
        $name = htmlspecialchars($_POST['name']);
        $price = htmlspecialchars($_POST['price']);

        $image = $_FILES['image'];
        $image_location = $image['tmp_name'];
        $image_name = $image['name'];
        $image_up = "img/" . $image_name;

        $sql = "UPDATE products SET name = '$name', price = '$price', image = '$image_up' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        if($result && move_uploaded_file($image_location,$image_up)){
            echo "<script>alert('Update Succesfuly!')</script>";
        }else{
            echo "<script>alert('Try again!')</script>";
        }
        header("location: products.php");
        exit();
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
    <?php
     include('config.php');
     $id = htmlspecialchars($_GET['id']);
     $up = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
     $data = mysqli_fetch_array($up);
    ?>
    <center>
        <div class="main">
            <form action="update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <h2>Update Product</h2>
                <img src="img/cover.png" alt="logo" width="400px"><br><br>
                <input type="text" name="name" placeholder="Name of product" required value="<?php echo htmlspecialchars($data['name']); ?>"><br><br>
                <input type="text" name="price" placeholder="Price of product" required value="<?php echo htmlspecialchars($data['price']); ?>"><br><br>
                <input type="file" name="image" id="file" style="display:none;">
                <label for="file" style="cursor: pointer; color: #3498db; text-decoration: underline;">Update image</label><br><br>
                
                <input type="submit" name="update" value="Update Product"><br><br>
                <a href="products.php">Show Products</a>
            </form>
        </div>
    </center>
</body>
</html>
