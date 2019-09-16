<?php

$salesman_id=$_GET['id'];

require 'db/config.php';


$update="UPDATE vendor_details SET status='Disabled' WHERE vender_id='$product_id'";
mysqli_query($conn,$update);
/*$stmt = $conn -> prepare('UPDATE salesman SET salesman_status = "Disabled" WHERE s_id = ? ');
$stmt -> bind_param('s',  $salesman_id);
$stmt -> execute();*/

// header('location:disabled_products.php');
echo "<script> alert('Salesman Disabled');window.location.href = 'disabled_salesman.php';</script>";
?>