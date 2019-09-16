<?php

$salesman_id=$_GET['id'];

require 'db/config.php';


$update="UPDATE vendor_details SET status='Active' WHERE vender_id='$product_id'";
mysqli_query($conn,$update);
/*$stmt = $conn -> prepare('UPDATE salesman SET salesman_status = "Active" WHERE s_id = ? ');
$stmt -> bind_param('s',  $salesman_id);
$stmt -> execute();*/
header('location:manage_salesman.php');

?>