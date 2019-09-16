<?php


session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };

include "db/config.php";

$category_id=$_GET['id'];




$sql="DELETE FROM category WHERE category_id=$category_id";
 mysqli_query($conn,$sql);
 header("location:manage_category.php");

?>