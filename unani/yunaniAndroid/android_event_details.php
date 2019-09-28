<?php 

include 'android_connection.php';

$event_id=$_POST['event_id'];




$events="SELECT * FROM events WHERE id='$event_id'";
$result=mysqli_query($conn,$events);

if(mysqli_num_rows($result)>0)
{
  
  $list=mysqli_fetch_assoc($result);

  $pass['event_details']=$list;

}




else
{
	$pass['event_details']="No Data";
}

print_r(json_encode($pass));





?>