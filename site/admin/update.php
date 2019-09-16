<?php
session_start();
if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };
require 'db/config.php';
$sql="SELECT * FROM vendor_details";
$result=mysqli_query($conn,$sql);
?>
<?php 


  ?>
<?php
session_start();
if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };
require 'db/config.php';
$sql="SELECT * FROM vendor_details";
$result=mysqli_query($conn,$sql);
?>
<?php 


  ?>
