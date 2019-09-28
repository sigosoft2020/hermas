<?php 

include 'android_connection.php';

$user_id=$_POST['user_id'];
$UserImageP = $_POST['UserImage'];

 $UserImage=time();
 $userpath = "../../uploads/users/$UserImage.png";

$img=$UserImage.'.png';
$res=file_put_contents($userpath,base64_decode($UserImageP));

if(isset($res))
{
    $contact="update users set image='$img' where user_id='$user_id'";
    $result=mysqli_query($conn,$contact);
    
    if(isset($result))
    {

     $pass['status']="success";
     $pass['img']=$img;
    }
    else
    {
    	$pass['status']="failed";
    }

}


else
{
	$pass['status']="failed";
}

print_r(json_encode($pass));

?>