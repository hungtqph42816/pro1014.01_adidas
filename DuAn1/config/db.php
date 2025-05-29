<?php
    $con= new mysqli("localhost", "root", "", "shoestore");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
?>