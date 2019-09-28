<?php 

include 'android_connection.php';

//$user_id=$_POST['user_id'];
$data=array();

$general="SELECT admin_messages.*,users.name FROM admin_messages inner join users on users.user_id=admin_messages.user_id";
$result=mysqli_query($conn,$general);

if(mysqli_num_rows($result)>0)
{
    while($list=mysqli_fetch_assoc($result))
    {
       $data[]=$list;
    }

$pass['general']=$data;

}

else
{
	$pass['general']="No Data";
}

print_r(json_encode($pass));

?>