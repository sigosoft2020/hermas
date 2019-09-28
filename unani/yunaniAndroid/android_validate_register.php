<?php

include 'android_connection.php';


$mobile = $_POST['mobile'];
$email = $_POST['email'];




$query = "SELECT * FROM users WHERE phone='$mobile'";
$result = mysqli_query($conn,$query);
$row=mysqli_fetch_assoc($result);

if(mysqli_num_rows($result)==0)
{


$check = "SELECT * FROM users WHERE email='$email'";
$resultcheck = mysqli_query($conn,$check);
$rowcheck=mysqli_fetch_assoc($resultcheck);

if(mysqli_num_rows($resultcheck)==0)
{


 $user['error']="0";
 $user['user_otp']="emythri";
 $user['password_otp']="emythri123";
 $user['centerid_otp']="EMYTRI";
 print_r(json_encode($user));

}
else
{
 
 $user['error']="email_exist";
 $user['user_otp']="0";
 $user['password_otp']="0";
 $user['centerid_otp']="0";
 print_r(json_encode($user));
}


}
else
{

 $user['error']="mobile_exist";
 $user['user_otp']="0";
 $user['password_otp']="0";
 $user['centerid_otp']="0";
 print_r(json_encode($user));


}

?>