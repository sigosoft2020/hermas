<?php 

include 'android_connection.php';

$user_id=$_POST['user_id'];


$data=array();

// $home="SELECT users.name,users.id FROM  users INNER JOIN yunani_messaging ON yunani_messaging.sender_id=users.id WHERE user.id!='$user_id'";


 $home="SELECT reciever_id FROM yunani_messaging WHERE sender_id='$user_id' UNION SELECT sender_id FROM yunani_messaging  WHERE reciever_id='$user_id'";


$result=mysqli_query($conn,$home);

if(mysqli_num_rows($result)>0)
{

while($list=mysqli_fetch_assoc($result))
{
   
$user=$list['reciever_id'];

$name="SELECT users.name,users.user_id,yunani_messaging.message,date(yunani_messaging.timestamp) as date FROM users INNER JOIN yunani_messaging ON yunani_messaging.reciever_id=users.user_id WHERE users.user_id='$user' order by yunani_messaging.id desc limit 1";
$result1=mysqli_query($conn,$name);

while($row=mysqli_fetch_assoc($result1))
{

        $data[]=$row;
}

}

$pass['home']=$data;

}

else
{
	$pass['home']="No Data";
}

print_r(json_encode($pass));
?>