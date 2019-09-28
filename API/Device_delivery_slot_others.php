<?php 

include 'Device_connection.php';



   $query="SELECT * FROM delivery_slot"; 
   $result=mysqli_query($conn,$query);



if(mysqli_num_rows($result)>0)

{

while($row=mysqli_fetch_assoc($result))
{
   $slot[]=$row;

}

}
else
{
   $slot[]="No slot";
}




$output['slot']=$slot;





$pass=$output;





print_r(json_encode($pass));





?>