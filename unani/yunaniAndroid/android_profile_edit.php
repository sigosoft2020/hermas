<?php

include 'android_connection.php';

$id = $_POST['user_id'];

$mobile = $_POST['mobile'];
$email = $_POST['email'];


$emailCheck = true;
$mobileCheck = true;

$check_mobile = mysqli_query($conn,"SELECT * FROM users WHERE phone='$mobile'");
$row_mobile = mysqli_fetch_assoc($check_mobile);
$check_email =  mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
$row_email = mysqli_fetch_assoc($check_email);


if(mysqli_num_rows($check_mobile)>0)
  {
      if($row_mobile['user_id'] != $id)
      {
          $mobileCheck = false;
      }
  }
  

  if($mobileCheck)
        {
          $name  = $_POST['name'];
          $place = $_POST['place'];
         
        if ($id = mysqli_query($conn, "UPDATE users set name='$name',email='$email',phone='$mobile',place='$place' where user_id='$id'")) {
          $pass = [
            'Status' => 'success',
            'name' => $name,
            'mobileCheck' => $mobileCheck
          ];
          
        }
        else {
          $pass = [
            'Status' => 'failed',
            'mobileCheck' => $mobileCheck
          ];
        }
    }

    else
    {
        $pass = [
          'Status' => 'failed',
          'mobileCheck' => $mobileCheck
        ];
    }

  print_r(json_encode($pass));
 
?>