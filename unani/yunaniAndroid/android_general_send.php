<?php

include 'android_connection.php';

date_default_timezone_set("Asia/Kolkata");

$user_id = $_POST['user_id'];
$message = $_POST['message'];
$timestamp = date("Y-m-d H:i:s");

$sql="INSERT INTO admin_messages(message, user_id, type,timestamp) VALUES ('$message', '$user_id', 'Send','$timestamp')"; 

if (mysqli_query($conn, $sql)) 
{

    
    echo "Success" ;

} 

else 
{
    
    echo "Error";
}




?>