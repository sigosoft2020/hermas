<?php

$product_id=$_GET['id'];

require 'db/config.php';


$update="UPDATE vendor_details SET status='Active' WHERE vender_id='$product_id'";
mysqli_query($conn,$update);

header('location:manage_vendor.php');

?>