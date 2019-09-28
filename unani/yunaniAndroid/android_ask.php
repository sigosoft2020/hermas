<?php

include 'android_connection.php';

date_default_timezone_set("Asia/Kolkata");

$user_id = $_POST['user_id'];
$question = $_POST['question'];
$notes = $_POST['notes'];
$category = $_POST['category'];
$timestamp = date("Y-m-d H:i:s");

$sql="INSERT INTO ask_doctor(question, notes, category, status, user_id,timestamp) VALUES ('$question', '$notes', '$category', 'open', '$user_id','$timestamp')"; 

if (mysqli_query($conn, $sql)) 
{

    
    echo "Success" ;

} 

else 
{
    
    echo "Error";
}




?>