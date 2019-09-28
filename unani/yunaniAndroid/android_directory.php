<?php 

include 'android_connection.php';



$data=array();

$directory="SELECT * FROM yunani_directory where block='0'";
$result=mysqli_query($conn,$directory);

if(mysqli_num_rows($result)>0)
{

while($list=mysqli_fetch_assoc($result))
{
   $data[]=$list;

}

$output['directory']=$data;

}

else
{
$output['directory']="No Data";
}

print_r(json_encode($output));

?>