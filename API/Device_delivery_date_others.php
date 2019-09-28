<?php 

include 'Device_connection.php';


$d=date('Y-m-d');



   $query="SELECT * FROM delivery WHERE delivery_date>='$d'"; 
   $result=mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)

{

while($row=mysqli_fetch_assoc($result))
{
   $date[]=$row;

}

}
else
{
   $date=[];
}

$output['date']=$date;

$pass=$output;



print_r(json_encode($pass));

?>