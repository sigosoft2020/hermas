<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


$current = date('Y-m-d');


include "db/config.php";

$current = date('Y-m-d');


if(isset($_POST['submit']))
{

$name            = $_POST['name'];

$from          = $_POST['from'];
$to          = $_POST['to'];
$amount           = $_POST['amount'];
$val           = $_POST['val'];
$code           = $_POST['code'];
$time           = $_POST['time'];
$timeto           = $_POST['timeto'];

$time = date("H:i:s",strtotime($time));
$timeto = date("H:i:s",strtotime($timeto));

$t1=strtotime("$from $time");
$t2=strtotime("$to $timeto");

/*$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 7) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    $code= $pass; */
    
$sql="INSERT INTO voucher(voucher_name, amount, valid_from,valid_to,voucher_code,minimum_cart_value,time,time_to,str_time_from,str_time_to) VALUES ('$name', '$amount',  '$from','$to','$code','$val','$time','$timeto','$t1','$t2')";

if (mysqli_query($conn, $sql))
 {
   
    echo "<script> alert('Added Successfully');window.location.href = 'voucher.php';</script>";
 } 

else 
{
  
    echo "<script> alert('Error');window.location.href = 'voucher.php';</script>";
}

};

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
    <!-- bootstrap-wysiwyg -->
    <link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    
    <link href="vendors/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="vendors/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="vendors/bootstrap-timepicker/icons.css" rel="stylesheet" type="text/css" />

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">

 <?php require 'partials/sidebar.php'; ?>

        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Voucher</h3>
              </div>

          
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Voucher</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>

                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">


                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CustomerName"> Voucher Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" name="name" placeholder="Voucher Name" id="name"   type="text">
                        </div>
                        </div>
                        
                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CustomerName"> Voucher Code 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" name="code" placeholder="Voucher Code" id="code" type="text">
                        </div>
                        </div>
                      
                      
                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total">Amount<span class="required">*</span>
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                         <input class="form-control" name="amount" placeholder="Amount" id="amount"  required="required" type="number">
                      </div>

                      </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Date From<span class="required">*</span>
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                         <input class="form-control" name="from" placeholder="Valid Form" id="from"  required="required" type="date">
                      </div>

                      </div>

                    
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Date To<span class="required">*</span>
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                         <input class="form-control" name="to" placeholder="Valid To" id="to"  required="required" type="date">
                      </div>

                      </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Time From
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                         <input class="form-control" name="time" placeholder="Time" id="timepicker"  type="text">
                      </div>

                      </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Time To
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                         <input class="form-control" name="timeto" placeholder="Time" id="timepickerTo"  type="text">
                      </div>

                      </div>

                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Minimum Cart Value
                        </label>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                         <input class="form-control" name="val" placeholder="Cart Value" id="val"  type="number">
                      </div>

                      </div>
 

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <a href="manage_voucher.php"><button type="button" class="btn btn-primary" >Cancel</button></a>
                          <input type="submit" name="submit" class="btn btn-success" value="Submit">
                        </div>
                      </div>
                    </form>

                 
                  </div>
                </div>
              </div>
            </div>
     
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Powered By <a href="">Hermas</a>
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
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="vendors/starrr/dist/starrr.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
    
    <script src="vendors/bootstrap-timepicker/bootstrap-timepicker.js"></script>
    <script src="vendors/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <script src="vendors/bootstrap-timepicker/jquery.form-pickers.init.js"></script>
    
     <script>
       function GetCustomers()
       {

           var VBillingDet_Name = document.getElementById('VBillingDet_Name').value

      //alert(VBillingDet_Name); 


           xhr = new XMLHttpRequest();
           xhr.open('POST' , 'getpayment.php' , true);

           xhr.setRequestHeader('Content-Type', 'application/json');
           xhr.send(JSON.stringify({
           VBillingDet_Name:VBillingDet_Name

           }));


           xhr.onreadystatechange = function() {

           if (this.readyState == 4 && this.status == 200) {


            console.log('-------------------------------111--------------------------->>>')

           var temp =xhr.responseText;
           if (temp) {

           temp= JSON.parse(temp);

           document.getElementById('GrandTotal').value =temp.vendor.GrandTotal;

             }

           }
           };

       }


   </script>


  
  </body>
</html>
