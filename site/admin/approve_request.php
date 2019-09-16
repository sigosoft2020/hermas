<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


$current = date('Y-m-d');



require 'db/config.php';

$RequestID=$_GET['id'];




$sql="UPDATE bulorder_register SET stat='active' WHERE reg_id='$RequestID'";
 mysqli_query($conn,$sql);
 header("location:manage_wholesaler.php");

?>