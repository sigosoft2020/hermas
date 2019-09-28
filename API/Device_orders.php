<?php 

include 'Device_connection.php';

$UserID=$_POST['UserID'];

//$query="SELECT * FROM app_orders WHERE BillingDet_UserId='$UserID'";
$query="SELECT DISTINCT order_id,invoice_no,order_no,timestamp,status,grand_total,payment_mode FROM orders WHERE user_id='$UserID' order by order_id desc";

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