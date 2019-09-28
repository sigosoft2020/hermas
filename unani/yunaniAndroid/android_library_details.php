<?php 

include 'android_connection.php';

$library_id=$_POST['library_id'];

$image=array();



$slider="SELECT image FROM library_slider WHERE library_id='$library_id'";
$s_result=mysqli_query($conn,$slider);

if(mysqli_num_rows($s_result)>0)
{
while($list=mysqli_fetch_assoc($s_result))
{
   $view[]=$list;

}

}

else
{
$view['image']="no data";	
}



$output['slider']=$view;

$library="SELECT * FROM yunani_library WHERE id='$library_id'";
$result=mysqli_query($conn,$library);
$row=mysqli_fetch_assoc($result);

$output['library']=$row;


$pass['data']=$output;


print_r(json_encode($pass));





?>