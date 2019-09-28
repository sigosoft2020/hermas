<?php 

include 'android_connection.php';

$user_id=$_POST['user_id'];


$data=array();

$question="SELECT * FROM ask_doctor WHERE user_id='$user_id' order by id desc";
$result=mysqli_query($conn,$question);

if(mysqli_num_rows($result)>0)
{

while($list=mysqli_fetch_assoc($result))
{
   $data[]=$list;

}




$pass['question']=$data;

}

else
{
	$pass['question']="No Data";
}

print_r(json_encode($pass));





?>