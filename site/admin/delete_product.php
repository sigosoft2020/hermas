<?php


session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };

include "db/config.php";

$product_id=$_GET['id'];




$sql="DELETE FROM products WHERE product_id=$product_id";
 mysqli_query($conn,$sql);


$del=mysqli_query($conn,"DELETE FROM stock_table WHERE product_id=$product_id");



 header("location:manage_products.php");

?>