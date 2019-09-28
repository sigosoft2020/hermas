<?php 

include 'android_connection.php';



$data=array();

$library="SELECT * FROM yunani_library";
$result=mysqli_query($conn,$library);

if(mysqli_num_rows($result)>0)
{

while($list=mysqli_fetch_assoc($result))
{
   $data[]=$list;

}


$output['library']=$data;



}

else
{
$output['library']="No Data";
}

print_r(json_encode($output));





?>