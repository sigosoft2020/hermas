<?php

$product_id=$_GET['id'];

require 'db/config.php';


$update="UPDATE products SET featured='Featured' WHERE product_id='$product_id'";
mysqli_query($conn,$update);

header('location:manage_products.php');

?>