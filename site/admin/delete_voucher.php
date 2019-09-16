<?php 

session_start();

require 'db/config.php';

$CashVoucherID=$_GET['id'];

$sql="DELETE FROM voucher WHERE voucher_id=$CashVoucherID";
 mysqli_query($conn,$sql);
 
 header("location:manage_voucher.php");

?>