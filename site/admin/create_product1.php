<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };




require 'db/config.php';

if(isset($_POST['submit']))
{




$product_name=$_POST['name'];
$product_description=$_POST['description'];
$indication = $_POST['indication'];
$category_id=$_POST['category_id'];
$quantity=$_POST['quantity'];
$price=$_POST['price'];


    function checkFile($file){
    // check file type
    $allowed =  array('gif','png' ,'jpg', 'jpeg', 'GIF','PNG' ,'JPG', 'JPEG');
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if(!in_array($ext, $allowed) ) {
        die("Unsupported file format, allowed(gif,png,jpg,jpeg).");
    }
    elseif ($file['size'] > 1000000) {
        die("file size too large.");
    }
    else{
    // file upload
    $shuffled = str_shuffle('1234567890');
    $file_name = $shuffled.time().'.'.$ext;
    move_uploaded_file($file['tmp_name'], '../uploads/product_images/' . $file_name);
    return $file_name;
  };
}


$file1 = $_FILES['file-1'];
$file2 = $_FILES['file-2'];
$file3 = $_FILES['file-3'];
$file4 = $_FILES['file-4'];


    $target_dir = "../uploads/products/"; //directory details
    
    $imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION); //image type(png or jpg etc)
    $target=$target_dir.time().'.'.$imageFileType;
    $image = time().'.'.$imageFileType; //full path
    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target))
    {

     $query="INSERT INTO products(product_name, product_description, image, category_id, quantity, price, status, featured,indication) VALUES ('$product_name', '$product_description', '$image', '$category_id', '$quantity', '$price', 'Active', 'Product','$indication')";
       
     if (mysqli_query($conn, $query))
     {

       $ProductID=mysqli_insert_id($conn);

       $stock=mysqli_query($conn,"INSERT INTO stock_table(product_id, stock) VALUES ('$ProductID', '0')");

       
       if ($file1['size'] > 0) {
       $file1_name = checkFile($file1);
       mysqli_query($conn, "INSERT INTO product_images(ProductID, image) VALUES('$ProductID', '$file1_name')");
       };

      if ($file2['size'] > 0) {
      $file2_name = checkFile($file2);
      mysqli_query($conn, "INSERT INTO product_images(ProductID, image) VALUES('$ProductID', '$file2_name')");
      };

      if ($file3['size'] > 0) {
      $file3_name = checkFile($file3);
      mysqli_query($conn, "INSERT INTO product_images(ProductID, image) VALUES('$ProductID', '$file3_name')");
      };
      
      if ($file4['size'] > 0) {
      $file3_name = checkFile($file4);
      mysqli_query($conn, "INSERT INTO product_images(ProductID, image) VALUES('$ProductID', '$file3_name')");
      };


       echo "<script> alert('Product Added Successfully');window.location.href = 'manage_products.php';</script>";

     } 
 
     else 
     {
  
       echo "<script> alert('Error Please Try Again');window.location.href = 'create_product.php';</script>";

     }
   
     } 

     else
     
     {

      echo "<script> alert('Upload Error');window.location.href = 'create_product.php';</script>";

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
                    <form id="demo-form2" method="POST"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left" >


                          

                      

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Product Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="Name" required="required" type="text">
                        </div>
                      </div>

                      
                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Category<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="category" class="form-control" name="category_id" required>

                            <?php 
                            $sql="SELECT * FROM category";
                            $result=mysqli_query($conn,$sql);
                            while($row=mysqli_fetch_assoc($result))
                            {
                            ?>

                            <option value="<?php echo $row['category_id'];?>"><?php echo $row['category_name'];?></option>

                           <?php }; ?>

                          </select>
                          </div>
                          </div>
                      
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty"> Quantity <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="qty" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="quantity" placeholder="Quantity" required="required" type="text">
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price"> Price <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="price" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="price" placeholder="Price" required="required" type="number">
                        </div>
                      </div>



                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="description" required="required" name="description" class="form-control col-md-7 col-xs-12" rows="5"></textarea>
                        </div>
                      </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="indication">Indication <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="indication" required="required" name="indication" class="form-control col-md-7 col-xs-12" rows="5"></textarea>
                        </div>
                      </div>

                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Product Image <span class="required">(600*600 Pixel) *</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="image" name="image" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div></br></br></br>




                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file-1">Image <span class="required">(600*600 Pixel) </span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="file-1" name="file-1" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file-2">Image <span class="required">(600*600 Pixel) </span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="file-2" name="file-2"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file-3">Image <span class="required">(600*600 Pixel) </span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="file-3" name="file-3"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file-4">Image <span class="required">(600*600 Pixel) </span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" id="file-4" name="file-4"  class="form-control col-md-7 col-xs-12">
                        </div>
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
  
  </body>
</html>
