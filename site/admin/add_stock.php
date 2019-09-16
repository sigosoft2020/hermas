<?php

session_start();

if(!isset($_SESSION['admin']))
 {
   header('location:index.php');
 };


require 'db/config.php';

$sql="SELECT stock_table.*, products.product_name FROM stock_table INNER JOIN products ON products.product_id=stock_table.product_id";
$result=mysqli_query($conn,$sql);


if(isset($_POST['submit']))
{

 /*$stmt = $conn->prepare("INSERT INTO  stock_history (history_vendor_id, history_invoice_no, history_old_stock,history_new_stock,history_pur_date,history_exp_date,stock_table_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssss", $vendor_id, $invoice_id, $old_stock, $new_stock, $purchase_date, $exp_date, $stock_id);*/
      $stmt = $conn->prepare("INSERT INTO  stock_history (history_vendor_id) VALUES (?)");
      $stmt->bind_param('s', $_POST['vendor_id']);

  $new_stock=$_POST['new_stock'];
  $stock_id=$_POST['stock_id'];
  $vendor_id=$_POST['vendor_id'];
  $invoice_id=$_POST['invoice_no'];
  $purchase_date=$_POST['pdate'];
  $exp_date=$_POST['edate'];
  $old_stock=$_POST['current_stock'];
  $stmt->execute();

  $new=mysqli_query($conn, "UPDATE stock_table SET stock='$new_stock', stock_vendor_id = '$vendor_id', stock_inv_no = '$invoice_id', stock_pur_date = '$purchase_date', stock_exp_date = '$exp_date'  WHERE product_id='$stock_id'");

     

  /*$new=mysql_query("UPDATE stock_table SET stock = '$new_stock', stock_vender_id = '$vendor_id' ,stock_inv_no = '$invoice_id',stock_pur_date = '$new_pur_Date',stock_exp_date = '$new_exp_Date'WHERE id = $id");*/
  if($new)
  {
    mysqli_query($conn, "UPDATE products SET ProductStock='$new_stock' WHERE product_id='$stock_id'");

  }

  echo "<script> alert('Stock Added Successfully');window.location.href = 'add_stock.php';</script>";
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
                <h3>Stock</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Stock Details</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Product Name</th>
                          <th>Stock</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php while($row=mysqli_fetch_assoc($result))
                      {
                      ?>
                        <tr>
                           <td><?php echo $row['product_name']; ?></td>
                          <td><?php echo $row['stock']; ?></td>
                           <td><button data-toggle="modal" data-target="#my-ticket-1" onclick="yourFunction('<?php echo $row['product_id']; ?>','<?php echo $row['stock']; ?>')" style="cursor: pointer;" id="send" type="submit" class="btn btn-success" name="submit">Add Stock</button></td>  
                        </tr>
                       <?php }; ?> 
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
        </div>
        </div>


        <div class="modal fade" id="my-ticket-1" tabindex="-1" >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Add Stock</h4>
                  </div>
                  <div class="modal-body">
                  <div class="form-group clearfix">
                   <form method="POST"  onsubmit="validateform();" >
                   <div class="container">

                      <div class="row">
                      <div class="col-md-6">
                      <label>Current Stock</label>  
                      <input type="number" id="stock" class="form-control" readonly name="current_stock">
                      </div>
                      <div class="col-md-6">
                      <label>New Stock</label>  
                      <input type="text" min="0" name="new_stock" class="form-control" id="new_stock" onkeyup="newstock_validate(this.id)" autocomplete="off"><p id="warn1" style="color: red;" ></p>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Vendor Name</label>
                          <select id="vendor" class="form-control" name="vendor_id" required>
                               <option value='null'>..select..</option>
                            <?php 
                            $sql="SELECT * FROM vendor_details";
                            $result=mysqli_query($conn,$sql);
                            while($row=mysqli_fetch_assoc($result))
                            {
                            ?>
                            <option value="<?php echo $row['vender_id'];?>"><?php echo $row['vendor_name'];?></option>
                           <?php }; ?>
                          </select>
                          <p id="warn3" style="color: red;" ></p>
</div>
                        </div>

<div class="col-md-6">
                         <label>Invoice No</label>  
                      <input type="text" id="invoice_no" class="form-control" name="invoice_no">
                      <p id="warn2" style="color: red;" ></p>
                      </div>

<div class="col-md-6">
                         <label>Purchase Date</label>  
                     <input type="date" id="theDate" class="form-control" name="pdate">
                      </div>
                      <div class="col-md-6">
                         <label>Expiry Date</label>  
                      <input type="date" id="edate" class="form-control" name="edate" >
                      <p id="warn4" style="color: red;" ></p>
                      </div>
                      <br>
                      <div class="col-md-1">
                      <input type="hidden" id="stock_id" name="stock_id" class="form-control"><br>
                      <input type="submit" id="add_stock" name="submit" class="btn btn-success" value="Submit" onclick="btn_sub();"> 
                     <!--  <button type="submit" id="add_stock"  class="btn btn-success" onclick="btn_sub();">Submit</button> -->
                      </div>
                   </div>
                    </div>
                   </form>
                  
                   </div>
        <footer>
        </footer>
      </div>
    </div>
    </div>
<script>
    function yourFunction(intValue,tid){
     var currentstock=document.getElementById('stock').value = tid;
     var newstock=document.getElementById('stock_id').value = intValue;
  }



function newstock_validate(){
  var new_stock=$("#new_stock").val();
   var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/; 
    if(!numericReg.test(new_stock)) {
    //alert('only numbers required');
    document.getElementById('warn1').innerHTML = "Stock should be in numbers";
    event.preventDefault();
   } 
   if(new_stock == ""){
    document.getElementById('warn1').innerHTML = "";
   }
   else{
    return true;
   }  
}  
var date = new Date();

var day = date.getDate();
var month = date.getMonth() + 1;
var year = date.getFullYear();

if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;

var today = year + "-" + month + "-" + day;


document.getElementById('theDate').value = today;

function btn_sub(){
 var vendor = $('#vendor').val();
 var invoice_no = $('#invoice_no').val();
 var edate = $('#edate').val();
 if(vendor == 'null'){
document.getElementById('warn3').innerHTML = "Select a vendor";
  event.preventDefault();
 }
 if(invoice_no == ''){
  document.getElementById('warn2').innerHTML = "This field is required";
  event.preventDefault();
//document.getElementById('warn3').innerHTML = "Enter invoice no";
 // event.preventDefault();
 }
  if(edate == ''){
  document.getElementById('warn4').innerHTML = "This field is required";
  event.preventDefault();
//document.getElementById('warn3').innerHTML = "Enter invoice no";
 // event.preventDefault();
 }

}

</script>
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