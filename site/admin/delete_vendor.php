<?php


session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };

include "db/config.php";

$vendor_id=$_GET['id'];




$sql="DELETE FROM vendor_details WHERE vender_id=$vendor_id";
 mysqli_query($conn,$sql);
 header("location:manage_vendor.php");

?>