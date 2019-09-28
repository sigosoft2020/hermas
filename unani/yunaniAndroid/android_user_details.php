<?php 

include 'android_connection.php';

$user_id=$_POST['user_id'];

$events="SELECT * FROM  users WHERE user_id='$user_id'";
$result=mysqli_query($conn,$events);

if(mysqli_num_rows($result)>0)
{
  
  $list=mysqli_fetch_assoc($result);

  $pass['user_details']=$list;
}

else
{
	$pass['user_details']="No Data";
}

print_r(json_encode($pass));

?>