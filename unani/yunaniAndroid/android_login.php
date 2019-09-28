<?php 

include 'android_connection.php';

$mobile=$_POST['mobile'];

$query="SELECT * from users WHERE phone='$mobile'";
$result = mysqli_query($conn,$query); 
$list=mysqli_fetch_assoc($result);

if(mysqli_num_rows($result)==1){


 $user['details']=$list;
 $user['error']="0";
 $user['user_otp']="emythri";
 $user['password_otp']="emythri123";
 $user['centerid_otp']="EMYTRI";
 print_r(json_encode($user));

}

else
{

 $user['error']="1";
 $user['details']="0";
 $user['user_otp']="0";
 $user['password_otp']="0";
 $user['centerid_otp']="0";
     print_r(json_encode($user)); //mobile number already exist
 }    






 ?>