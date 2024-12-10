<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shopping</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <div class="main">
            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <h2>Online Shopping</h2>
                <img src="img/cover.png" alt="logo" width="400px"><br><br>
                <input type="text" name="name" placeholder="Name of product" required><br><br>
                <input type="text" name="price" placeholder="Price of product" required><br><br>
                <input type="file" name="image" id="file" style="display:none;" required>
                <label for="file" style="cursor: pointer; color: #3498db; text-decoration: underline;">Upload image</label><br><br>
                <input type="submit" name="upload" value="Upload Product"><br><br>
                <a href="products.php">Show Products</a>
            </form>
        </div>
    </center>
</body>
</html>
