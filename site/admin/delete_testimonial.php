<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


$current = date('Y-m-d');


include "db/config.php";

$testimonial_Id=$_GET['id'];

$query="delete  FROM testimonial WHERE id='$testimonial_Id'";

     if (mysqli_query($conn, $query))
     {

       echo "<script> alert('Testimonial deleted Successfully');window.location.href = 'manage_testimonial.php';</script>";

     }

     else
     {

       echo "<script> alert('Error Please Try Again');window.location.href = 'manage_testimonial.php';</script>";

     }

?>
