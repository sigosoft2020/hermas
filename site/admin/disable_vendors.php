<?php

$product_id=$_GET['id'];

require 'db/config.php';


$update="UPDATE vendor_details SET status='Disabled' WHERE vender_id='$product_id'";
mysqli_query($conn,$update);
/*$stmt = $conn -> prepare('UPDATE vendor_details SET status = "Disabled" WHERE vender_id = ? ');
$stmt -> bind_param('s',  $product_id);
$stmt -> execute();*/

// header('location:disabled_products.php');
echo "<script> alert('Vendor Disabled');window.location.href = 'disabled_venders.php';</script>";
?>