<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


$current = date('Y-m-d');


include "db/config.php";

$UserID=$_GET['id'];

$query="DELETE  FROM users WHERE user_id=$UserID";

    mysqli_query($conn,$query);
 header("location:manage_user.php");

?>
