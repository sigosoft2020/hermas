<?php

include 'Device_connection.php';
$category_id = $_POST['category_id'];


$sql="SELECT * FROM products WHERE category_id='$category_id' AND status='Active' order by product_id desc";
$result=mysqli_query($conn,$sql);


if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{
    $list[]=$row;
    $status="success";
}

}
else
{
   $list[]="no data";
   $status="failed";
}

$output['list']=$list;
$output['Status']=$status;

$pass=$output;
print_r(json_encode($pass));

?>
