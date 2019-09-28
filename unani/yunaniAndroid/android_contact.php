<?php 

include 'android_connection.php';

$user_id=$_POST['user_id'];


$data=array();

$contact="SELECT * FROM users WHERE user_id!='$user_id'";
$result=mysqli_query($conn,$contact);

if(mysqli_num_rows($result)>0)
{

while($list=mysqli_fetch_assoc($result))
{
   $data[]=$list;

}




$pass['contact']=$data;

}

else
{
	$pass['contact']="No Data";
}

print_r(json_encode($pass));





?>