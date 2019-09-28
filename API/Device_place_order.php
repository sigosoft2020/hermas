
<?php

include 'Device_connection.php';

$BillingDet_Phone=$_POST['BillingDet_Phone'];
$BillingDet_Name=$_POST['BillingDet_Name'];
$BillingDet_Land=$_POST['BillingDet_Land'];
$BillingDet_City=$_POST['BillingDet_City'];
$BillingDet_Address=$_POST['BillingDet_Address'];
$BillingDet_Email=$_POST['BillingDet_Email'];


$BillingDet_UserId=$_POST['BillingDet_UserId'];

$UserType="User";


$GrandTotal=$_POST['GrandTotal'];;

$CartData=$_POST['CartData'];

// $delevery_date=$_POST['delevery_time'];
//$delevery_date_veg=$_POST['delevery_time_veg'];

// $longitude=$_POST['longitude'];
// $latitude=$_POST['latitude'];
// $voucher_code=$_POST['voucher_code'];
// $voucher_amount=$_POST['voucher_amount'];
$payment_mode=$_POST['payment_mode'];
//$del_slot_veg=$_POST['del_slot_veg'];
// $del_slot_others=$_POST['del_slot_others'];

//$OrderNO='APP'.time();
//$InvoiceNO='A'.time();
// $sel=mysqli_query($conn,"SELECT * FROM last_invoice WHERE last_id='1'");
// $sel_row=mysqli_fetch_assoc($sel);
// $last_invoice=$sel_row['last_invoice'];
    
$OrderNO='COD'.time();
$InvoiceNO='CF'.time();


date_default_timezone_set('Asia/Kolkata');
$t_date=date('Y-m-d');
$t_time=date('h:i:s a', time());

$query="INSERT INTO orders(order_no, invoice_no, grand_total, user_id, user_type, name,phone, landmark, city,address_1,status,type_of_sale,email,payment_mode,billing_date,billing_time,delivery_date) VALUES ('$OrderNO', '$InvoiceNO', '$GrandTotal', '$BillingDet_UserId', '$UserType', '$BillingDet_Name', '$BillingDet_Phone', '$BillingDet_Land', '$BillingDet_City', '$BillingDet_Address', 'Order Placed','App Order','$BillingDet_Email','$payment_mode','$t_date','$t_time','$delevery_date')";

if(mysqli_query($conn,$query))
{

 $OrderID=mysqli_insert_id($conn);
 //mysqli_query($conn,"update last_invoice SET last_invoice=last_invoice+1 WHERE last_id='1'");

 $qry="UPDATE users SET voucher_code='$voucher_code' where user_id='$BillingDet_UserId'";
mysqli_query($conn,$qry);

// $save_address=mysqli_query($conn,"INSERT INTO address_table(BillingDet_Land, BillingDet_City,BillingDet_Address, UserID) VALUES ('$BillingDet_Land', '$BillingDet_City', '$BillingDet_Address', '$BillingDet_UserId')");

 $json1 = json_decode($CartData, true);
$json = $json1['order'];
$elementCount  = count($json);





for ($i=0;$i < $elementCount; $i++) 
 {
 

    $ProductName=$json[$i]['ProductName'];
    $Product_Id=$json[$i]['Product_Id'];


    $Quantity=$json[$i]['Quantity'];
    $Product_MRP=$json[$i]['Product_MRP'];
    $offer_price=$json[$i]['offer_price'];
    $Total=$json[$i]['Total'];

    $GetImage=mysqli_query($conn,"SELECT * FROM products WHERE product_id='$Product_Id'");
    $GetImage_row=mysqli_fetch_assoc($GetImage);
 

    $ProductImage=$GetImage_row['image'];
    //$sgst=$GetImage_row['sgst'];
    //$cgst=$GetImage_row['cgst'];
   // $gst=$GetImage_row['gst'];
    $cat_id=$GetImage_row['category_id'];
    $ProductStock=$GetImage_row['ProductStock']-$Quantity;
   
  

 $sql=mysqli_query($conn,"INSERT INTO order_items(order_id, product_id, product_name, 	product_image, 	quantity, product_price, total, order_no, invoice_no,category) VALUES ('$OrderID', '$Product_Id', '$ProductName', '$ProductImage', '$Quantity', '$Product_MRP', '$Total', '$OrderNO', '$InvoiceNO','$cat_id')");

 
    if($ProductStock<=0)
    {
        $stock=mysqli_query($conn,"UPDATE products SET ProductStock='0',stock_status='out' WHERE ProductID='$Product_Id'");
    }
    else
    {
        $stock=mysqli_query($conn,"UPDATE products SET ProductStock=ProductStock-'$Quantity', stock_status='in' WHERE ProductID='$Product_Id'");
    }


 }

$pass['Status']="Success";
$pass['id']=$OrderNO;


}
else
{

$pass['Status']="Failed";

}



print_r(json_encode($pass));



?>