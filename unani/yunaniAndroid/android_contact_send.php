<?php

include 'android_connection.php';

date_default_timezone_set("Asia/Kolkata");

$user_id = $_POST['user_id'];
$contact_id = $_POST['contact_id'];
$message = $_POST['message'];
$timestamp = date("Y-m-d H:i:s");

$sql="INSERT INTO yunani_messaging (message, sender_id, reciever_id,timestamp) VALUES ('$message','$user_id','$contact_id','$timestamp')"; 

if (mysqli_query($conn, $sql)) 
{

    
    echo "Success" ;

} 

else 
{
    
    echo "Error";
}




?>