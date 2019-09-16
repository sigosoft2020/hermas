<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };




$order_id=$_GET['id'];

require 'db/config.php';




$sql="SELECT * FROM orders WHERE order_id='$order_id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$order_items=mysqli_query($conn,"SELECT * FROM order_items WHERE order_id='$order_id'");

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <link rel="icon" href="favicon.ico">

    <title>HERMAS | Admin</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    




 <?php require 'partials/sidebar.php'; ?>




        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Order Summary</h3>
              </div>

              
            </div>

            <div class="clearfix"></div>
            <div class="container " style="padding-top: 5%;">
            <div class="col-md-6">



            <table class="table" style="width: 50%;margin-left: 20%;">
  <thead>
    <tr>
     
    
    </tr>
  </thead>
  <tbody class="table-striped">
  <tr>
      <th scope="row"><strong>Name</strong></th>
      <td><?php echo $row['name'];?></td>
      
    </tr>
    <tr>
      <th scope="row"><strong>Email</strong></th>
      <td><?php echo $row['email'];?></td>
      
    </tr>
    <tr>
      <th scope="row"><strong>Mobile</strong></th>
      <td><?php echo $row['phone'];?></td>
      
    </tr>

    <tr>
      <th scope="row"><strong>Status</strong></th>
      <td><?php echo $row['status'];?></td>
      
    </tr>
    <tr>
      <th scope="row"><strong>Order No</strong></th>
      <td><?php echo $row['order_no'];?></td>
      
    </tr>
    <tr>
      <th scope="row"><strong>Invoice No</strong></th>
      <td><?php echo $row['invoice_no'];?></td>
      
    </tr>

     <tr>
      <th scope="row"><strong>Grand Total</strong></th>
      <td><?php echo $row['grand_total'];?></td>
     
    </tr>

    <tr>
      <th scope="row"><strong>user Type</strong></th>
      <td><?php echo $row['user_type'];?></td>
     
    </tr>


  
  </tbody>
</table>
</div>
      <div class="col-md-6">



            <table class="table" style="width: 50%;margin-left: 20%;">
  <thead>
    <tr>
     
    
    </tr>
  </thead>
  <tbody class="table-striped">
  <tr>
      <th scope="row"><strong>Name</strong></th>
      <td><?php echo $row['name'];?></td>
      
    </tr>
    <tr>
      <th scope="row"><strong>House/Flat No</strong></th>
      <td><?php echo $row['house'];?></td>
      
    </tr>
    <tr>
      <th scope="row"><strong>Locality</strong></th>
      <td><?php echo $row['address_1'];?></td>
      
    </tr>

    <tr>
      <th scope="row"><strong>Status</strong></th>
      <td><?php echo $row['address_2'];?></td>
      
    </tr>
    <tr>
      <th scope="row"><strong>City</strong></th>
      <td><?php echo $row['city'];?></td>
      
    </tr>
    <tr>
      <th scope="row"><strong>Landmark</strong></th>
      <td><?php echo $row['landmark'];?></td>
      
    </tr>

     <tr>
      <th scope="row"><strong>Pincode</strong></th>
      <td><?php echo $row['pincode'];?></td>
     
    </tr>
 
    <tr>
      <th scope="row"><strong>Mobile</strong></th>
      <td><?php echo $row['phone'];?></td>
      
    </tr> 
 


  
  </tbody>
</table>
</div>
</div>

<div class="container" style="padding: 5%;">
<div class="row">
    <table class="table">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Packet Size</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>

     <?php 
     while($data=mysqli_fetch_assoc($order_items))

     {?>
 
      <tr>
        <td><?php echo $data['product_name'];?></td>
        <td><?php echo $data['packet_size'];?></td>
        <td><?php echo $data['quantity'];?></td>
        <td><?php echo $data['product_price'];?></td>
        <td><?php echo $data['total'];?></td>
      </tr>
      <?php }; ?>
    </tbody>
  </table>


</div>
  
</div>




        <!-- </div> -->
        </div>
        </div>
       
              
        <footer>
          <div class="pull-right">
             Powered By <a href="">HERMAS</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>

  </body>
</html>