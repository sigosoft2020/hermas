<?php 

include 'Device_connection.php';
$d=date('Y-m-d');

//$query="SELECT * FROM special_offers";
//$query="SELECT * FROM products where period_from <= '$d' and period_to >= '$d'";
//$query="SELECT * FROM products where offer_price!=''";
$query="SELECT * from products  where special_offer='1' and period_from <= '$d' and period_to >= '$d' and ProductStock>0 order by offer_possition asc";
$result=mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)

{

while($row=mysqli_fetch_assoc($result))
{
   $images[]=$row;
   $status="Success";

}

}
else
{
   $images[]="No offer images";
   $status="failed";
}

$output['images']=$images;
$output['Status']=$status;

$pass=$output;

print_r(json_encode($pass));

?>