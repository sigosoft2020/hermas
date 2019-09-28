<?php 

include 'android_connection.php';

$general="SELECT *,date(`timestamp`) as date FROM admin_messages order by id desc limit 1";
$result=mysqli_query($conn,$general);

if(mysqli_num_rows($result)>0)
{

    while($list=mysqli_fetch_assoc($result))
    {
       $data[]=$list;
    
    }

    $pass['general']=$data;

}

else
{
	$pass['general']="No Data";
}

print_r(json_encode($pass));

?>