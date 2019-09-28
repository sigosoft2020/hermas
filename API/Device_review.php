<?php

include 'Device_connection.php';

$user_id=$_POST['user_id'];
$product_id=$_POST['product_id'];
$rating=$_POST['rating'];
$comment=$_POST['comment'];
$date=date('Y-m-d');

$qry="select orders.*,order_items.* from orders inner join order_items on orders.order_id=order_items.order_id where orders.user_id='$user_id' and order_items.product_id='$product_id'";
    $validate=mysqli_query($conn,$qry);
if(mysqli_num_rows($validate)>0){
    
    $res="select * from product_rating where user_id='$user_id' AND product_id='$product_id'";
    $val=mysqli_query($conn,$res);
    if(mysqli_num_rows($val)>0)
    {
        $pass['Status']="Already Added";
    }
    else
    {
      $query="INSERT INTO product_rating(product_id,user_id,rate,date,comments) VALUES ('$product_id','$user_id','$rating','$date','$comment')";
    //   mysqli_query($conn,$query);
   
  if(mysqli_query($conn,$query))
{
    $sql="select count(*) as cnt,sum(rate) as sum from product_rating where product_id='$product_id'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result))
      {
         $ct=$row['cnt'];
         $sm=$row['sum'];
         $avg=round(($sm/$ct),1);
      }
      $qry="update products set rating='$avg' where product_id='$product_id'";
      if(mysqli_query($conn,$qry)){
             
             $pass['Status']="Success";
         }
    
}

else
{
    $pass['Status']="Failed";
} 
    }    
}
else{
    $pass['Status']="Not Purchased";
}

print_r(json_encode($pass));

?>