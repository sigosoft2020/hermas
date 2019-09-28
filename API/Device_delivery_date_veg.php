<?php 

include 'Device_connection.php';

$Key=$_POST['Key'];
$d=date('Y-m-d');
if($Key=='Vegetables')
{

   $query="SELECT * FROM delivery WHERE category='Vegetables' and delivery_date>='$d'"; 
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
   $date[]="No date";
}




$output['date']=$date;





$pass=$output;




}




print_r(json_encode($pass));





?>