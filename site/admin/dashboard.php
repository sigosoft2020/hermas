<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


$current = date('Y-m-d');


include "db/config.php";
$sql="SELECT count(*)as pending FROM orders WHERE STATUS='Order Placed'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
   /* $stmt = $conn -> prepare('SELECT count(*) as pending FROM orders WHERE STATUS = "Order Placed"');
    $stmt -> execute(); 
    $result = $stmt->get_result();
    $row=mysqli_fetch_assoc($result);*/

$sql1="SELECT count(*)as cancelled FROM orders WHERE STATUS='Cancelled'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);
/*$sql1 = $conn -> prepare('SELECT count(*) as cancelled FROM orders WHERE STATUS = "Cancelled"');
    $sql1 -> execute(); 
    $result1 = $sql1->get_result();
    $row1=mysqli_fetch_assoc($result1);*/

$sql2="SELECT count(*)as delivered FROM orders WHERE STATUS='Delivered'";
$result2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_assoc($result2);
/*$sql2 = $conn -> prepare('SELECT count(*) as delivered FROM orders WHERE STATUS = "Delivered"');
    $sql2 -> execute(); 
    $result2 = $sql2->get_result();
    $row2=mysqli_fetch_assoc($result2);*/

$sql3="SELECT count(*)as total FROM `orders` ";
$result3=mysqli_query($conn,$sql3);
$row3=mysqli_fetch_assoc($result3);
/*$sql3 = $conn -> prepare('SELECT count(*) as total FROM orders ');
    $sql3 -> execute(); 
    $result3 = $sql3->get_result();
    $row3=mysqli_fetch_assoc($result3);*/

$sql4="SELECT * FROM orders WHERE status='Delivered' AND type_of_sale='App Order' AND delivery_date='$current'  ";
$result4=mysqli_query($conn,$sql4);
$row4=mysqli_fetch_assoc($result4);
/* $sql4 = $conn -> prepare('SELECT * FROM orders WHERE status = "Delivered" AND type_of_sale="App Order" AND delivery_date="$current"');
    $sql4 -> execute(); 
    $result4 = $sql4->get_result();
    $row4=mysqli_fetch_assoc($result4);*/

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hermas | Admin</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    
 
   



  </head>

  <body class="nav-md">


  <?php require 'partials/sidebar.php'; ?>

        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">


          
<div class="row top_tiles">
                     <a href="live_orders.php"> <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats" style="background-color: #dadada;">
                          <div class="icon i1"><i class="fa fa-clock-o"></i></div>
                          <div class="count"><?php echo $row['pending']; ?></div>
                          <h3>Pending Orders</h3>

                        </div>
                      </div></a>
                      
                      <a href="cancelled_orders.php"><div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats" style="background-color: #dadada;">
                          <div class="icon i2"><i class="fa fa-close"></i></div>
                          <div class="count"><?php echo $row1['cancelled']; ?></div>
                          <h3>Cancelled Orders</h3>

                        </div>
                      </div> </a>
                      
                     <a href="Delivered_order.php"> <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats" style="background-color: #dadada;">
                          <div class="icon i3"><i class="fa fa-truck"></i></div>
                          <div class="count"><?php echo $row2['delivered']; ?></div>
                          <h3>Delivered Orders</h3>

                        </div>
                      </div></a>

                       <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats" style="background-color: #dadada;">
                          <div class="icon i3"><i class="fa fa-list-ul"></i></div>
                          <div class="count"><?php echo $row3['total']; ?></div>
                          <h3>Total Orders</h3>

                        </div>
                      </div>
                      
                    </div>
<br><br>
                        <div class="clearfix"></div>
                        
                  <!--   <div class="col-md-6 col-sm-6 col-xs-12">
                       <div class="x_panel">
                            <div class="x_title">
                                 <h2>Activity <small></small></h2>
                                 <div class="clearfix"></div>
                            </div>
                            <div class="x_content2">
                            <div class="graphx" id="sales-line-chart-all" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div> -->
                  <!--   
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <div class="x_panel">
                            <div class="x_title">
                                 <h2>ORDERS <small></small></h2>
                                 <div class="clearfix"></div>
                            </div>
                            <div class="x_content2">
                            <div class="graphx" id="sales-line-chart-alll" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div> -->
              
                        
                    
                            
                            
                     <!--      <h3>Today's Activity</h3>  -->
                        
                        
                <!--        <div class="x_content">
                    <div id="graph_bar" style="width:100%; height:280px;"></div>
                  </div>
                        -->
                      </div>
                    </div>

                  </div>
                  <br />


        </div>


        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Powered By <a href="">Hermas</a>
          </div>
          <div class="clearfix"></div>
        </footer>
    
    
    
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgres-->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
    <script src="build/js/graph.js"></script>
    
      <!-- morris.js -->
    <script src="vendors/raphael/raphael.min.js"></script>
    <script src="vendors/morris.js/morris.min.js"></script>

	<script>
	

<?php

    include "db/config.php";
    $d=date('Y-m-d');
    $query="select sum(GrandTotal) as total from app_orders where status='Order Placed' and payment_mode != 'COD' and billing_date='$d'";
    if($res=mysqli_query($conn,$query)){
    while ($row = mysqli_fetch_array($res))
    {
        
     $sale=$row['total'];
     $sale=round($sale, 0);
    }
    }
    $d=date('Y-m-d');
    $query="select sum(VGrandTotal) as total from vendor_purchase where Vbilling_date='$d'";
    if($res=mysqli_query($conn,$query)){
    while ($row = mysqli_fetch_array($res))
    {
     $purchase=$row['total'];
     $purchase=round($purchase, 0);
    }
    }
    $d=date('Y-m-d');
    $sql="SELECT count(*)as pending FROM `app_orders` WHERE STATUS='Order Placed' AND billing_date='$d'";
    $result=mysqli_query($conn,$sql);
    $res1=mysqli_fetch_assoc($result);
    
    $d=date('Y-m-d');
    $sql2="SELECT count(*)as delivered FROM `app_orders` WHERE STATUS='Delivered' AND billing_date='$d'";
    $result2=mysqli_query($conn,$sql2);
    $res2=mysqli_fetch_assoc($result2);
    
    $d=date('Y-m-d');
    $sql3="SELECT count(*)as cancelled FROM `app_orders` WHERE STATUS='Cancelled' AND billing_date='$d'";
    $result3=mysqli_query($conn,$sql3);
    $res3=mysqli_fetch_assoc($result3);
    
    $d=date('Y-m-d');
    $sql4="SELECT count(*)as dispatched FROM `app_orders` WHERE STATUS='Dispatched' AND billing_date='$d'";
    $result4=mysqli_query($conn,$sql4);
    $res4=mysqli_fetch_assoc($result4);
    
?>

	  new Morris.Bar({
      element: 'sales-line-chart-all',
      resize: true,
      data: [
              { y: 'sales', a: <?php echo $sale; ?> },
              { y: 'Purchase', a: <?php echo $purchase; ?>},

          ],
          xkey: 'y',
          ykeys: ['a'],
  
      labels: [' amount']
    });
    
    new Morris.Bar({
      element: 'sales-line-chart-alll',
      resize: true,
      data: [
              { y: 'Pending', a: <?php echo $res1['pending']; ?> },
              { y: 'Delivered', a: <?php echo $res2['delivered']; ?>},
              { y: 'Cancelled', a: <?php echo $res3['cancelled']; ?>},
              //{ y: 'Dispatched', a: <?php echo $res4['dispatched']; ?>},

          ],
          xkey: 'y',
          ykeys: ['a'],
  
      labels: [' orders']
    });

	</script>
  </body>
</html>
