<?php

include 'Device_connection.php';


$order_no=$_POST['invoice_no'];
$reason=$_POST['reason'];
$grand_total=$_POST['grand_total'];
$item=$_POST['item_name'];
$Product_Id=$_POST['Product_Id'];
$qty=$_POST['qty'];
$rate=$_POST['rate'];
$user_id=$_POST['user_id'];
$comments=$_POST['comments'];
$pickup_date=$_POST['pickup_date'];
$pickup_time=$_POST['pickup_time'];
$refund_total=$_POST['refund_total'];

date_default_timezone_set('Asia/Kolkata');
$ret_date=date('Y-m-d');
$ret_time=date('h:i:s a', time());

    
    $Get="SELECT * FROM orders WHERE order_no='$order_no'";
    $result=mysqli_query($conn,$Get);
    while($Get_row=mysqli_fetch_array($result))
    {
        $payment_mode=$Get_row['payment_mode'];
        $OrderID=$Get_row['OrderID'];
        $invoice_no=$Get_row['InvoiceNO'];
    }
 
if($payment_mode=='COD')
{
    $query="INSERT INTO returned_orders(order_no,invoice_no,reason,ret_date,ret_time,grand_total,item,Product_Id,qty,rate,user_id,mode_of_pay,comments,pickup_time,pickup_date,refund_total) VALUES ('$order_no','$invoice_no','$reason','$ret_date','$ret_time','$grand_total','$item','$Product_Id','$qty','$rate','$user_id','$payment_mode','$comments','$pickup_time','$pickup_date','$refund_total')";
    $update="UPDATE order_items SET ret_status='Returned' WHERE order_id='$OrderID' AND product_id='$Product_Id'";
    
}
else
{
    $bank_id=$_POST['bank_id'];
    
    $Get_bank_det="SELECT * FROM bank_details WHERE bank_id='$bank_id' AND user_id='$user_id'";
    $res=mysqli_query($conn,$Get_bank_det);
    while($Get1=mysqli_fetch_array($res))
    {
        //$bank_name=$Get['bank_name'];
        $acount_number=$Get1['account_number'];
        $ifsc_code=$Get1['ifsc_code'];
    }
    
    $query="INSERT INTO returned_orders(order_no,invoice_no,reason,ret_date,ret_time,grand_total,item,Product_Id,qty,rate,user_id,mode_of_pay,bank_id,account_no,ifsc_code,comments,pickup_time,pickup_date,refund_total) VALUES ('$OrderNO','$invoice_no','$reason','$ret_date','$ret_time','$grand_total','$item','$Product_Id','$qty','$rate','$user_id','$payment_mode','$bank_id','$acount_number','$ifsc_code','$comments','$pickup_time','$pickup_date','$refund_total')";
    $update="UPDATE order_items SET ret_status='Returned' WHERE order_id='$OrderID' AND product_id='$Product_Id'";
}

if(mysqli_query($conn,$query) && mysqli_query($conn,$update))
{
    
    $pass['Status']="Success";
}
else
{
    $pass['Status']="Failed";
}

print_r(json_encode($pass));

?>