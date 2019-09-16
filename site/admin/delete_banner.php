<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


$current = date('Y-m-d');


require 'db/config.php';

$OfferImageID=$_GET['id'];


$sql="DELETE FROM offer_image WHERE OfferImageID=$OfferImageID";
 mysqli_query($conn,$sql);
 header("location:manage_banner.php");

?>