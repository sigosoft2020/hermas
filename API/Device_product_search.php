<?php

include 'Device_connection.php';
$key = $_POST['key'];


$sql="SELECT product_id,product_name FROM products WHERE product_name LIKE '$key%'";
$result=mysqli_query($conn,$sql);


if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{
    $message = array('ProductName' => $row['product_name'],'ProductID' => $row['product_id']);
    $pass[]=$message;
    
}


}

else
{
   $pass[]="no data";
}

print_r(json_encode($pass));

?>
