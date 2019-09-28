<?php
include 'Device_connection.php';


$item=$_POST['item'];
$item_id=$_POST['item_id'];


if($item == "category"){
    $query="SELECT * from category where category_id='$item_id'";
    
    $result=mysqli_query($conn,$query);

        if(mysqli_num_rows($result)>0)
        
        {
           while($row=mysqli_fetch_assoc($result))
            {
           $search['Item']=$item;
           $search['Title']=$row['category_name'];
           $search['Id']=$row['category_id'];
           $status="success";
            }
        }
        else{
           $search['Item']=[];
           $search['Title']=[];
           $search['Id']=[];
           $status="failed";
        }
   
}
else{
    $query1="SELECT * from products where product_id='$item_id'";

    $result=mysqli_query($conn,$query1);

        if(mysqli_num_rows($result)>0)
        {
           while($row=mysqli_fetch_assoc($result))
           {
           $search['Item']=$item;
           $search['Title']=$row['product_name'];
           $search['Id']=$row['product_id'];
           $status="success";
           }
        }
        else{
           $search['Item']=[];
           $search['Title']=[];
           $search['Id']=[];
           $status="failed";
        }
}

$output['data']=$search;
$output['status']=$status;
$pass=$output;
print_r(json_encode($pass));
?>
