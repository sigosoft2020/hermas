<?php 

include 'Device_connection.php';



$query="SELECT offer.*, product.* FROM offer INNER JOIN product ON offer.Brand_Id=product.Product_Brand WHERE ProductStock>0";
$result=mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)

{

while($row=mysqli_fetch_assoc($result))
{
   $Brand[]=$row;
   $status="success";

}

}
else
{
    $brand[]="No Brands";
    $status="failed";
}

$output['Brand']=$Brand;
$output['Status']=$status;

$pass=$output;

print_r(json_encode($pass));

?>