<?php
// Establish connection
$conn = mysqli_connect('localhost', 'root', '', 'market');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
