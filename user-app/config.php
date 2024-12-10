<?php
$dsn = "mysql:host=localhost;dbname=user-app";
$username = "root";
$password = "";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try{
    $con = new PDO($dsn, $username, $password, $options);
}
catch(PDOException $e){
    echo "Connection faild: " . $e->getMessage();
}
?>