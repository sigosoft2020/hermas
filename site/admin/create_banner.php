<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


$current = date('Y-m-d');

include "db/config.php";
if(isset($_POST['submit']))
{

$position                   =$_POST['position'];
$slt                   =$_POST['slt'];

$data                   =$_POST['data'];

if($slt=='0'){
    $selt="category";
}
else{
   $selt="product"; 
}
$target_dir = "../uploads/offer_image/"; //directory details
    
    $imageFileType = pathinfo($_FILES["OfferImage"]["name"],PATHINFO_EXTENSION); //image type(png or jpg etc)
    $target=$target_dir.time().'.'.$imageFileType;
    $OfferImage = time().'.'.$imageFileType; //full path
    if(move_uploaded_file($_FILES["OfferImage"]["tmp_name"], $target))

    {
   $query="INSERT INTO offer_image(OfferImage,position,item,item_id) VALUES ('$OfferImage','$position','$selt','$data')";
      if (mysqli_query($conn, $query))
       {
          echo "<script> alert('Offer Image Added Successfully');window.location.href = 'manage_banner.php';</script>";
       } 

      else 
      {
          echo "<script> alert('Error');window.location.href = 'create_banner.php';</script>";
      }

  }
  else
  {
      echo "<script> alert('Error');window.location.href = 'create_banner.php';</script>";

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

    <title>Farmroot| Store</title>

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

     


<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Offer Image</h3>
              </div>

          
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>

                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="POST" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                        
                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CategoryID"> Select Item 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="slt" id="slt" class="form-control col-md-7 col-xs-12" >
                            <option value="">SELECT</option> 
                            <option value="0">Category</option> 
                            <option value="1">Product</option> 
                        </select> 
                        </div>
                      </div>


                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CategoryID"> Item 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
 
                        <select name="data" id="data" class="form-control col-md-7 col-xs-12" >
                            <option value="">Select</option> 
                        <!--<?php 
                        $result = mysqli_query($conn,"SELECT * from category WHERE CStatus='Active'");
                        while ($row = mysqli_fetch_array($result))
                        {
                            echo "<option value=".$row['Category_Id'].">".$row['Category_Title']."</option>";
                        }
                        ?> -->       
                        </select> 
                        </div>
                      </div>
                      
                      

                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="OfferImage"> Offer Image<span class="required">*(900*500 pixel)</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="OfferImage" class="form-control col-md-7 col-xs-12" name="OfferImage" placeholder="Offer Image" required="required" type="file" onchange="preview_image(this)">
                        </div>
                      </div>

                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CategoryID">Position 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-7 col-xs-12" name="position" >
                                <option value="1">1</option>
                                <option  value="2">2</option>
                                <option  value="3">3</option>
                                <option  value="4">4</option>
                                <option  value="5">5</option>
                                <option value="6">6</option>
                                <option  value="7">7</option>
                                <option  value="8">8</option>
                                <option  value="9">9</option>
                                <option  value="10">10</option>
                            </select>
                                      
                        </div>
                      </div>


                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" onClick="window.location.reload()" class="btn btn-primary">Cancel</button>
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
    <!-- NProgres->
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
  
  <script>
       $('#slt').on('change',function(){
         var cat_id = $("#slt option:selected").val();

         $.ajax({
         method: "POST",
         url: "http://hermasunani.com/admin/getdata.php",
         data : { cat_id : cat_id },
         dataType : "json",
         success : function( data ){
           $('#data').html(data);
           console.log(data);
             }
       });
       });
   </script>
   
<script type="">
    function preview_image(id)
     {
       var id = id.id;
       var x = document.getElementById(id);
       var size = x.files[0].size;
       if (size > 100000) {
         alert('Please select an image with size less than 1 mb.');
         document.getElementById(id).value = "";
       }
       else {
         var val = x.files[0].type;
         var type = val.substr(val.indexOf("/") + 1);
         s_type = ['jpeg','jpg','png'];
         var flag = 0;
         for (var i = 0; i < s_type.length; i++) {
           if (s_type[i] == type) {
             flag = flag + 1;
           }
         }
         if (flag == 0) {
           alert('This file format is not supported.');
           document.getElementById(id).value = "";
         }
       /*  else {
           var reader = new FileReader();
           reader.onload = function()
           {
             var cn = id.substring(3);
             var preview = 'preview' + cn;
             var output = document.getElementById(preview);
             output.src = reader.result;
           }
           reader.readAsDataURL(x.files[0]);
         }*/

       }
     }
   </script>  </body>
</html>
