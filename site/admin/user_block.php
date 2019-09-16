<?php

session_start();

if(!isset($_SESSION['store']))
 {
   header('location:index.php');
 };

$current = date('Y-m-d');

include "db/config.php";

$ID=$_GET['id'];

$query="UPDATE users SET status='Blocked' WHERE user_id=$ID";

    mysqli_query($conn,$query);
 header("location:blocked_users.php");

?>
