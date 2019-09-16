<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };

$product_id=$_GET['id'];

require 'db/config.php';

$view=mysqli_query($conn,"SELECT * FROM products WHERE product_id='$product_id'");
$row=mysqli_fetch_assoc($view);

if(isset($_POST['submit']))
{

$product_name=$_POST['name'];
$product_description=$_POST['description'];
$indication = $_POST['indication'];
$category_id=$_POST['category_id'];
$quantity=$_POST['quantity'];
$price=$_POST['price'];
$percentage = $_POST['b2b_percentage'];
$b2b = $_POST['b2b_price'];

     $query="UPDATE products SET product_name='$product_name', product_description='$product_description',indication='$indication',category_id='$category_id', quantity='$quantity', price='$price',b2b_percentage='$percentage',b2b_price='$b2b' WHERE product_id='$product_id'";
       
     if (mysqli_query($conn, $query))
     {

       echo "<script> alert('Product Updated  Successfully');window.location.href = 'manage_products.php';</script>";

     } 
 
     else 
     {
  
        echo "<script> alert('Error Please Try Again');window.location.href = 'manage_products.php';</script>";
    //   echo("Error description: " . mysqli_error($conn));
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

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  </head>

  <body class="nav-md">

 <?php require 'partials/sidebar.php'; ?>

        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Product</h3>
              </div>

          
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Product Details</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>

                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left" >
                          
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Product Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="Name" value="<?php echo $row['product_name'];?>" required="required" type="text">
                        </div>
                      </div>

                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Category<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="category" class="form-control" name="category_id" required>

                          <?php

                          $cat_id=$row['category_id'];

                          $cat="SELECT * FROM category WHERE category_id='$cat_id'";
                          $c_result=mysqli_query($conn,$cat);
                          $c_row=mysqli_fetch_assoc($c_result);
                        
                          ?>  
                                                      
                           <option value="<?php echo $c_row['category_id'];?>"><?php echo $c_row['category_name'];?></option>  



                            <?php 
                            $sql="SELECT * FROM category";
                            $result=mysqli_query($conn,$sql);
                            while($rower=mysqli_fetch_assoc($result))
                            {
                            ?>

                            <option value="<?php echo $rower['category_id'];?>"><?php echo $rower['category_name'];?></option>

                           <?php }; ?>

                          </select>
                          </div>
                          </div>
                      
                      
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty"> Quantity <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="qty" class="form-control col-md-7 col-xs-12" name="quantity" placeholder="Quantity" value="<?php echo $row['quantity'];?>" required="required" type="text">
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Price <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="price" class="form-control col-md-7 col-xs-12" name="price" placeholder="Price" value="<?php echo $row['price'];?>" required="required" type="number">
                        </div>
                      </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="b2b_percentage"> B2B Percentage <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <!-- <input id="price" class="form-control selectpicker col-md-7 col-xs-12" data-live-search="true" data-validate-length-range="6" data-validate-words="2" name="b2b_percentage" id="b2b_percentage" placeholder="B2B Percentage" required="required" type="text" > -->
                           <input type="number" class="form-control selectpicker col-md-7 col-xs-12" data-live-search="true" data-validate-length-range="6" data-validate-words="2" name="b2b_percentage" id="b2b_percentage" value="<?php echo $row['b2b_percentage'];?>" >
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="b2b_price"> B2B Price <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <!--  <input id="price" class="form-control selectpicker col-md-7 col-xs-12" data-live-search="true" data-validate-length-range="6" data-validate-words="2" name="b2b_price" id="b2b_price" placeholder="B2B Price" required="required" type="text" > -->
                          <input type="number" class="form-control selectpicker col-md-7 col-xs-12" data-live-search="true" step="any" data-validate-length-range="6" data-validate-words="2" name="b2b_price" id="b2b_price" value="<?php echo $row['b2b_price'];?>" >

                        </div>
                      </div>

                      

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="description" required="required" name="description" class="form-control col-md-7 col-xs-12" rows="5"><?php echo $row['product_description'];?></textarea>
                        </div>
                      </div>
                      
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="indication">Indication <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="indication" required="required" name="indication" class="form-control col-md-7 col-xs-12" rows="5"><?php echo $row['indication'];?></textarea>
                        </div>
                      </div>
                      
                      <div class="col-md-4 col-md-offset-3">

                      <img src="../uploads/products/<?php echo $row['image']; ?>" class="img-thumbnail" width="100%"/><br><br>
                       <a href="product_image.php?id=<?php echo $row['product_id']; ?>">Edit Image</a><br><br>
                      
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cancel</button>
                          <button id="send" type="submit" class="btn btn-success" name="submit">Submit</button>
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
    <script type="">
      $('#b2b_price').on('change',function(){
          var cat_id = $("#b2b_price option:selected").val();
          // document.getElementById("b2b_percentage").disabled = true;
          
       });
       
        $('#b2b_percentage').on('change',function(){
         var cat_id = $("#b2b_percentage option:selected").val();
         var price = document.getElementById("price").value;
         var percentage =document.getElementById("b2b_percentage").value;
         b2b =price-(price*percentage/100);  
         document.getElementById("b2b_price").value = b2b;
         // document.getElementById("b2b_price").disabled = true;
          
       });
    </script>
  
  </body>
</html>
