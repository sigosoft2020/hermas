<?php

 include 'Device_connection.php';

 $name=$_POST['name'];
 $email=$_POST['email'];
 $address=$_POST['address'];
 $phone=$_POST['phone'];
 $city=$_POST['city'];
 $state=$_POST['state'];
 $pincode=$_POST['pincode'];
 $userID=$_POST['user_id'];
 $date=date('Y-m-d');

 $validate=mysqli_query($conn,"SELECT * FROM bulorder_register WHERE email='$email' OR phone='$phone'");
 
 if(mysqli_num_rows($validate)>0)
 {
  $pass['Status']="User Already Registered";
  $pass['user_id']=0;
 }

 else
 {

 $query="INSERT INTO bulorder_register(name,email,phone,address,city,state,pincode,date,userID,stat) VALUES ('$name','$email','$phone','$address','$city','$state','$pincode','$date','$userID','block')";

 if (mysqli_query($conn, $query))
  {
      $last_id=mysqli_insert_id($conn);
      mysqli_query($conn,"UPDATE users SET bulk_stat='0' where user_id='$userID'");
      $set=mysqli_query($conn,"SELECT * FROM bulorder_register WHERE reg_id='$last_id'");
      $user=mysqli_fetch_assoc($set);
      $pass['Status']="Success";
      $pass['user_id']=$user['reg_id']; 
  }
     
  else 
  {
   
   $pass['Status']="Failed"; 
   $pass['user_id']=0; 
     
  }    

  }

  print_r(json_encode($pass));
 
?>