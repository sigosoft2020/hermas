<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


$current = date('Y-m-d');


include "db/config.php";

$ID=$_GET['id'];

$query="UPDATE users SET status='Active' WHERE user_id=$ID";

    mysqli_query($conn,$query);
 header("location:manage_user.php");



?>
