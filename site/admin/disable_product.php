<?php

$product_id=$_GET['id'];

require 'db/config.php';


$update="UPDATE products SET status='Disabled' WHERE product_id='$product_id'";
mysqli_query($conn,$update);

// header('location:disabled_products.php');
echo "<script> alert('Product Disabled');window.location.href = 'disabled_products.php';</script>";
?>