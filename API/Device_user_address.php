
<?php

include 'Device_connection.php';

$user_id=$_POST['user_id'];
$name=$_POST['name'];
$mobile=$_POST['mobile'];
$house=$_POST['house'];
$city=$_POST['locality'];
$house_no=$_POST['house_no'];
$landmark=$_POST['landmark'];
$latitude=$_POST['latitude'];
$longitude=$_POST['longitude'];
//$place=$_POST['office'];
//$title=$_POST['des'];



$query="INSERT INTO address_table(house,city,user_id,landmark,house_no,	new_name,new_mobile,latitude,longitude) VALUES ('$house','$city','$user_id','$landmark','$house_no','$name','$mobile','$latitude','$longitude')";


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