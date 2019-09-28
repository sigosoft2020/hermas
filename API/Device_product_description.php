<?php 

include 'Device_connection.php';

$prodID=$_POST['prod_id'];


$query="SELECT * from products where product_id='$prodID'";

$result=mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)

{

while($row=mysqli_fetch_assoc($result))
{
   $prod[]=$row;

}

}
else
{
   $prod[]="No Data";
}




$output['prod']=$prod;





$pass=$output;


print_r(json_encode($pass));





?>