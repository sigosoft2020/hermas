<?php

include "android_connection.php";

$sql="SELECT * FROM news";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

if(mysqli_num_rows($result) > 0){

$output[]=$row;
print(json_encode($output));
}
else{
	print("no_data");
}

 
?>