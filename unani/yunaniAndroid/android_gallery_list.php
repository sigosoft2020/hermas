<?php 

include 'android_connection.php';



$data=array();

$gallery="SELECT * FROM gallery";
$result=mysqli_query($conn,$gallery);

if(mysqli_num_rows($result)>0)
{

while($list=mysqli_fetch_assoc($result))
{
   $data[]=$list;

}


$output['gallery']=$data;



}

else
{
$output['gallery']="No Data";
}

print_r(json_encode($output));





?>