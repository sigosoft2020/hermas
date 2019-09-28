
<?php

include 'dbconnection.php';

$user_id=$_POST['user_id'];
$house=$_POST['house'];
$house_no=$_POST['house_no'];
$city=$_POST['city'];
$pincode=$_POST['pincode'];
$place=$_POST['place'];




$query="INSERT INTO address_table(house,house_no,city,pincode,user_id,place) VALUES ('$house','$house_no','$city','$pincode','$user_id','$place')";


if(mysqli_query($conn,$query))
{
    $pass['Status']="Success";
}
else
{
    $pass['Status']="Failed";
}

print_r(json_encode($pass));

?>
gfhh