<?php

include 'Device_connection.php';

$user_id=$_POST['user_id'];
$product_id=$_POST['product_id'];


$qry="select orders.*,order_items.* from orders inner join order_items on orders.order_id=order_items.order_id where orders.user_id='$user_id' and order_items.product_id='$product_id'";
    $validate=mysqli_query($conn,$qry);
    
if(mysqli_num_rows($validate)>0)
{
    
    $pass['Status']="Success";
}
else
{
   $pass['Status']="Failed";
}

print_r(json_encode($pass));

?>