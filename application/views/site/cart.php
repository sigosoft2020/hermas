<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>HERMAS | Basket</title>
    <link href="<?=base_url()?>site/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>site/css/style.default.css" rel="stylesheet">
    <link href="<?=base_url()?>site/css/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">    
    <!--  <link href="carousel.css" rel="stylesheet"> -->  
  </head>

<body>
      <div class="green-5 clearfix">
        <?php $this->load->view('site/includes/header.php'); ?>
      <div id="all" class="basket">
        <div id="content">
            <div class="container">
                <div class="col-md-12" id="basket">
                    <div class="box">
                        <h1>Shopping cart</h1>
                        <!-- <p class="text-muted">You currently have <?php echo $count; ?> item(s) in your cart.</p> -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Product</th>
                                            <th>Quantity</th>
                                            <th>Unit price</th>                               <th colspan="2">Total</th>
                                        </tr>
                                    </thead>

                                    <form method="POST">
                                      <tbody>
                                        <tr>
                                           <!--  <td>
                                                <a href="#">
                                                    <img src="uploads/products/<?php echo $cart[$i]['image']; ?>" alt="Product">
                                                </a>
                                            </td>
                                            <td><a href="#"><?php echo $cart[$i]['product_name']; ?></a>
                                            </td>
                                            <td>
                                            <p><?php echo $cart[$i]['quantity']; ?></p>
                                                
                                            </td>
                                            <td>₹<?php echo $cart[$i]['price']; ?></td>
                                         
                                            <td>₹<?php echo $cart[$i]['total']; ?></td>
                                            <td><button type="submit" class="my-cart-btn bg-blue" name="remove" value="<?php echo $i; ?>" onclick="return confirm('Are you sure to remove this item from cart?')"><i class="far fa-trash-alt"></i></button>
                                            </td> -->
                                        </tr>
                                      </tbody>
                                    </form>

                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <!-- <th colspan="2">₹<?php echo $grandtotal; ?></th> -->
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.table-responsive -->

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="product.php" class="btn btn-primary">Continue shopping</a>
                                </div>

                                <div class="pull-right">
                                    <!-- <button class="btn btn-primary">Update basket</button> -->
                                    <a href="login.php"><button class="btn btn-primary">Proceed to checkout</button></a>
                                </div>

                                <div class="pull-right">
                                    <!-- <button class="btn btn-primary">Update basket</button> -->
                                    <a href="checkout.php"><button class="btn btn-primary">Proceed to checkout</button></a>
                                </div>
                            </div>
                    <!-- /.box -->
                    </div>
                <!-- /.col-md-9 -->
               </div>
                <!-- /.col-md-3 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
    </div>
    <!-- /#all -->
    <?php $this->load->view('site/includes/footer.php'); ?>
   
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){

/**
 * This object controls the nav bar. Implement the add and remove
 * action over the elements of the nav bar that we want to change.
 *
 * @type {{flagAdd: boolean, elements: string[], add: Function, remove: Function}}
 */
var myNavBar = {

    flagAdd: true,

    elements: [],

    init: function (elements) {
        this.elements = elements;
    },

    add : function() {
        if(this.flagAdd) {
            for(var i=0; i < this.elements.length; i++) {
                document.getElementById(this.elements[i]).className += " fixed-theme";
            }
            this.flagAdd = false;
        }
    },

    remove: function() {
        for(var i=0; i < this.elements.length; i++) {
            document.getElementById(this.elements[i]).className =
                    document.getElementById(this.elements[i]).className.replace( /(?:^|\s)fixed-theme(?!\S)/g , '' );
        }
        this.flagAdd = true;
    }

};

/**
 * Init the object. Pass the object the array of elements
 * that we want to change when the scroll goes down
 */
myNavBar.init(  [
    "header",
    "header-container",
    "brand"
]);

/**
 * Function that manage the direction
 * of the scroll
 */
function offSetManager(){

    var yOffset = 0;
    var currYOffSet = window.pageYOffset;

    if(yOffset < currYOffSet) {
        myNavBar.add();
    }
    else if(currYOffSet == yOffset){
        myNavBar.remove();
    }

}

/**
 * bind to the document scroll detection
 */
window.onscroll = function(e) {
    offSetManager();
}

/**
 * We have to do a first detectation of offset because the page
 * could be load with scroll down set.
 */
offSetManager();
}); </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="../../assets/js/vendor/holder.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

</body>

</html>