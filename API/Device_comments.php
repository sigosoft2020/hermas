<?php
include 'Device_connection.php';


$product_id=$_POST['productId'];

$query="SELECT users.name,users.image,product_rating.comments,product_rating.rate from product_rating inner join users on product_rating.user_id=users.user_id where product_rating.product_id='$product_id' AND product_rating.comments!='NULL' order by rate_id desc";

$result=mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)

{
    while($row=mysqli_fetch_assoc($result))
{
     $search[]=$row;
     $result1="success";
}

}
else
{

     $result1="Failed";
}


$output['data']=$search;
$output['result']=$result1;

$pass=$output;

print_r(json_encode($pass));

?>
