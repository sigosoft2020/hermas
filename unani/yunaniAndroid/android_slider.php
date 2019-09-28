<?php 

include 'android_connection.php';



$image=array();

$image="SELECT * FROM slider";
$i_result=mysqli_query($conn,$image);

if(mysqli_num_rows($i_result)>0)
{

while($list=mysqli_fetch_assoc($i_result))
{
   $test[]=$list;

}


$output['image']=$test;

$pass['slider']=$output;

}

else
{
	$pass['slider']="No Data";
}

print_r(json_encode($pass));





?>