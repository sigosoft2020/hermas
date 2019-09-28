<?php 

include 'android_connection.php';

$user_id=$_POST['user_id'];
$contact_id=$_POST['contact_id'];


$data=array();

$contact="SELECT * FROM yunani_messaging WHERE (sender_id='$user_id' AND reciever_id='$contact_id') OR (sender_id='$contact_id' AND reciever_id='$user_id') ORDER By id ASC";
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