<?php 

include 'android_connection.php';



$data=array();

$event="SELECT * FROM events";
$result=mysqli_query($conn,$event);

if(mysqli_num_rows($result)>0)
{

while($list=mysqli_fetch_assoc($result))
{
   $data[]=$list;

}


$output['events']=$data;



}

else
{
$output['events']="No Data";
}

print_r(json_encode($output));





?>