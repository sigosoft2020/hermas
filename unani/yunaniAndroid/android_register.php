<?php

include 'android_connection.php';

$name = $_POST['name'];
$place = $_POST['place'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$type = $_POST['type'];


 $sql="INSERT INTO users(name,phone,email,place,type,image) VALUES ('$name', '$mobile', '$email', '$place', '$type','dummy.jpg')";

if (mysqli_query($conn, $sql)) 
{
    $last_id = mysqli_insert_id($conn);
    mysqli_query($conn,"UPDATE users SET bulk_stat='0' where user_id='$last_id'");
    echo $last_id;
} 

else 
{
    echo "0";
}




?>