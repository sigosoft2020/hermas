<?php 

include 'Device_connection.php';

$order_no=$_POST['order_no'];

//$query="SELECT * FROM app_orders WHERE BillingDet_UserId='$UserID'";
//$query="SELECT app_orders.*,app_order_items.* FROM app_orders INNER JOIN app_order_items ON app_order_items.OrderNo= app_orders.OrderNO WHERE app_orders.OrderNO='$order_no'";
$query="SELECT orders.*,order_items.*,products.*,order_items.quantity as qty FROM orders INNER JOIN order_items ON order_items.order_no= orders.order_no INNER JOIN products on products.product_id=order_items.product_id WHERE orders.order_no='$order_no'";

$result=mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)

{

while($row=mysqli_fetch_assoc($result))
{
   $Orders[]=$row;

}

}
else
{
   $Orders[]="No Orders";
}




$output['Orders']=$Orders;





$pass=$output;


print_r(json_encode($pass));





?>