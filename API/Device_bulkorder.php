<?php

include 'Device_connection.php';

$user_id=$_POST['user_id'];
//$category=$_POST['category'];
$product=$_POST['product'];
$unit=$_POST['unit'];
$notes=$_POST['notes'];

    $Get=mysqli_query($conn,"SELECT * FROM users WHERE user_id='$user_id'");
    $Get_row=mysqli_fetch_assoc($Get);
    $name=$Get_row['name'];
    $email=$Get_row['email'];
    $phone=$Get_row['phone'];
    
    $Get1=mysqli_query($conn,"SELECT * FROM address_table WHERE user_id='$user_id' order by address_id desc limit 1");
    $Get_row1=mysqli_fetch_assoc($Get1);
    $address_1=$Get_row1['address_1']."-".$Get_row1['address_2'];
    $city=$Get_row1['city']."-".$Get_row1['landmark'];
    $state=$Get_row1['state'];
    $place=$Get_row1['place'];
    $pincode=$Get_row1['pincode'];
    
    $Get2=mysqli_query($conn,"SELECT * FROM products WHERE product_id='$product'");
    $Get_row2=mysqli_fetch_assoc($Get2);
    $price=$Get_row2['price'];
    
    $total=$price*$unit;
    $OrderNO='COD'.time();
    $InvoiceNO='CF'.time();
    
    if($product!="")
    {
        $query="INSERT INTO bulk_order(product_id,price,qty,total,name,email,phone,address,city,state,status,order_no,invoice_no,notes) VALUES ('$product','$price','$unit','$total','$name','$email','$phone','$address_1','$city','$state','Order Placed','$OrderNO','$InvoiceNO','$notes')";
        if(mysqli_query($conn,$query))
            {
                $pass['Status']="Success";
            }
        else
            {
                $pass['Status']="Failed";
            }

    }
    else
    {
        $pass['Status']="Failed";
    }
    
print_r(json_encode($pass));

?>