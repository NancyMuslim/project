<?php

include ('config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['upload'])){
        $name = htmlspecialchars($_POST['name']);
        $price = htmlspecialchars($_POST['price']);

        $image = $_FILES['image'];
        $image_location = $image['tmp_name'];
        $image_name = $image['name'];
        $image_up = "img/" . $image_name;

        $sql = "INSERT INTO products (name, price, image) VALUES('$name', '$price', '$image_up')";
        $result = mysqli_query($conn, $sql);
        if($result && move_uploaded_file($image_location,$image_up)){
            echo "<script>alert('Upload Succesfuly!')</script>";
        }else{
            echo "<script>alert('Try again!')</script>";
        }
        header("location: index.php");
        exit();
    }
}

?>