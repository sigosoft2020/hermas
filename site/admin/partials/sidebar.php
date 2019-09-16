    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><span><img src="../images/logo.png" width="60%"></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <!-- <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/logo.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>Admin</h2>
              </div>
            </div> -->
            <!-- /menu profile quick info -->


            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                
                <ul class="nav side-menu">
                  <li><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard </a>
                    
                  </li>


                  <li><a><i class="fa fa-ticket"></i> Category <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="create_category.php">Add Category</a></li>
                      <li><a href="manage_category.php">Manage Category</a></li>
                      
                    </ul>
                  </li>

                       <li><a><i class="fa fa-shopping-bag"></i> Vendor <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                      <li><a href="create_vendor.php">Add Vendor</a></li>
                      <li><a href="manage_vendor.php">Manage Vendor</a></li>
                       <li><a href="disabled_venders.php">Blocked Vendor</a></li>
                    </ul>
                  </li>
               
                 <!--  </li> -->

                      <li><a><i class="fa fa-shopping-bag"></i> Products <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                      <li><a href="create_product.php">Add Products</a></li>
                      <li><a href="manage_products.php">Manage Products</a></li>
                      <li><a href="disabled_products.php">Blocked Products</a></li>
                    </ul>
                  </li>


               



                 <!--  <li><a href="add_stock.php"><i class="fa fa-truck"></i> Add Stock </a>
                    
                  </li> -->
                   <li><a><i class="fa fa-truck"></i> Stock <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="add_stock.php">Add Stock</a></li>
                      <li><a href="stock_history.php">Stock History</a></li>
                      
                    </ul>
                  </li>

                   <li><a><i class="fa fa-shopping-bag"></i> Orders <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                      <li><a href="live_orders.php">Live Orders</a></li>
                      <li><a href="delivered_order.php">Delivered Orders</a></li>
                      <li><a href="cancelled_orders.php">Bulk Orders</a></li>
                    </ul>
                  </li>
                  <!--  <li><a href="live_orders.php"><i class="fa fa-shopping-cart"></i> Live Orders</a>
                   <li><a href="delivered_order.php"><i class="fa fa-truck"></i> Delivered Orders</a>
                   <li><a href="cancelled_orders.php"><i class="fa fa-cart-arrow-down"></i> Cancelled Orders</a></li>
                  <li><a href="bulk_orders.php"><i class="fa fa-first-order"></i> Bulk Orders</a></li> -->
                  <li><a><i class="fa fa-user"></i>Users<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                      <li><a href="manage_user.php">Manage Users</a></li>
                      <li><a href="blocked_users.php">Blocked Users</a></li>
                      
                    </ul>
                  </li>
                  
                 <li><a><i class="fa fa-gift"></i>Banner Images<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="create_banner.php">Create Banner Images</a></li>
                      <li><a href="manage_banner.php">Manage Banner Images</a></li>
                      
                    </ul>
                  </li>


                  <li><a><i class="fa fa-user"></i> Salesman <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                      <li><a href="create_salesman.php">Add Salesman</a></li>
                      <li><a href="manage_salesman.php">Manage Salesman</a></li>
                       <li><a href="disabled_salesman.php">Blocked Salesman</a></li>
                    </ul>
                  </li>
                  
                   <li><a><i class="fa fa-gift"></i>Voucher<span class="fa fa-chevron-down">    </span></a>
                    <ul class="nav child_menu">
                      <li><a href="voucher.php">Create Voucher</a></li>
                     <li><a href="manage_voucher.php">Manage Voucher</a></li>
                    </ul>
                  </li>
                  
                    <li><a><i class="fa fa-quote-left"></i>Testimonials<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="testimonial.php">Create Testimonials</a></li>
                      <li><a href="manage_testimonial.php">Manage Testimonials</a></li>
                      
                    </ul>
                  </li>
                  
                  <li><a><i class="fa fa-bell"></i>Wholesaler Request<span class="fa fa-chevron-down">    </span></a>
                    <ul class="nav child_menu">
                      <li><a href="wholesaler_request.php">Wholesaler Requests</a></li>
                      <li><a href="manage_wholesaler.php">Manage Wholesaler</a></li>
                    </ul>
                  </li>
                    <li><a href="subscription.php"><i class="fa fa-home"></i>Subscriptions</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

     
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right" style="margin-right: 120px;">
                <li class="">
                  <a href="" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Admin
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!-- <li><a href=""> Profile</a></li> -->
                    <li>
                      <a href="password_change.php">
                        
                        <span>Change Passwod</span>
                      </a>
                    </li>
                    <li>
                        <!--<a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>-->
                        <a class="dropdown-item"  data-toggle="modal" data-target=".bd-example-modal-sm">Log out</a>
                    </li>
                  </ul>
                </li>

              
              </ul>
            </nav>
            
              <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                   <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body">
                              <p>Are you sure to logout?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary default mb-1" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-success default mb-1" href="logout.php">Logout</a>
                            </div>
                        </div>
                    </div>
              </div>
            
          </div>
        </div>