  <?php $user = $this->session->userdata['admin']; ?>
  <div class="topbar">
      <!-- LOGO -->
      <div class="topbar-left">
          <a href="<?=site_url('admin/dashboard')?>" class="logo">
            <span>

               <img src="<?=base_url()?>assets/images/footer-logo.png" alt="" height="50">
            </span>
            <i>
              <img src="<?=base_url()?>assets/images/logo_sm.png" alt="" height="30">
            </i>
          </a>
      </div>

      <nav class="navbar-custom">

          <ul class="list-unstyled topbar-right-menu float-right mb-0">

              <li class="dropdown notification-list">
                  <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                     aria-haspopup="false" aria-expanded="false">
                       <span class="ml-1"><?=$user['name']?><i class="mdi mdi-chevron-down"></i> </span>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- <a href="<?=site_url('admin/settings')?>" class="dropdown-item notify-item">
                        <i class="fi-power"></i> <span>Settings</span>
                    </a> -->
                    <a href="<?=site_url('users/logoutAdmin')?>" class="dropdown-item notify-item">
                        <i class="fi-power"></i> <span>Log Out</span>
                    </a>
                  </div>
              </li>
          </ul>

          <ul class="list-inline menu-left mb-0 float-left">
              <li class="float-left">
                  <button class="button-menu-mobile open-left waves-light waves-effect">
                      <i class="dripicons-menu"></i>
                  </button>
              </li>
          </ul>
 <!-- <h2 class="page_hd">Vendor</h2> -->
      </nav>

  </div>
  <!-- Top Bar End -->


  <!-- ========== Left Sidebar Start ========== -->
  <div class="left side-menu">
      <div class="slimscroll-menu" id="remove-scroll">

          <!--- Sidemenu -->
          <div id="sidebar-menu">
              <!-- Left Menu Start -->
              <ul class="metismenu" id="side-menu">
                  <li class="menu-title">Navigation</li>
                  <li>
                      <a href="<?=site_url('admin/dashboard')?>">
                          <i class="fa fa-home"></i><span> Dashboard </span>
                      </a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-ticket"></i> <span> Category </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/category/add')?>">Add Category</a></li>
                          <li><a href="<?=site_url('admin/category')?>">Manage Category</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/vendor')?>"><i class="fa fa-users"></i> <span> Vendors </span></a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-shopping-bag"></i> <span> Products </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/products/add')?>">Add Products</a></li>
                          <li><a href="<?=site_url('admin/products')?>">Manage Products</a></li>
                      </ul>
                   </li>
                   <li>
                      <a href="#"><i class="fa fa-truck"></i> <span> Stock </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/stock')?>">Add Stock</a></li>
                          <li><a href="<?=site_url('admin/stock/history')?>">Stock History</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-shopping-bag"></i> <span> Orders </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/orders')?>">Live Orders</a></li>
                          <li><a href="<?=site_url('admin/orders/delivered')?>">Delivered Orders</a></li>
                          <li><a href="<?=site_url('admin/orders/cancelled')?>">Cancelled Orders</a></li>
                          <li><a href="<?=site_url('admin/orders/bulk')?>">Bulk Orders</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/users')?>"><i class="fa fa-user"></i> <span> Users </span></a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-image"></i> <span> Banner Images </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/banner/add')?>">Create Banner Images</a></li>
                          <li><a href="<?=site_url('admin/banner')?>">Manage Banner Images</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="<?=site_url('admin/salesman')?>"><i class="fa fa-user"></i> <span> Salesman </span></a>
                  </li>

                  <li>
                      <a href="<?=site_url('admin/voucher')?>"><i class="fa fa-gift"></i> <span> Voucher </span></a>
                  </li>

                  <li>
                      <a href="#"><i class="fa fa-quote-left"></i> <span> Testimonial </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/testimonial/add')?>">Create Testimonial</a></li>
                          <li><a href="<?=site_url('admin/testimonial')?>">Manage Testimonial</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="#"><i class="fa fa-bell"></i> <span> Wholesaler Request </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/wholesaler/request')?>"> Wholesaler Requests</a></li>
                          <li><a href="<?=site_url('admin/wholesaler')?>">Manage Wholesaler</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="<?=site_url('admin/newsletter')?>"><i class="fa fa-credit-card-alt"></i> <span> Subscription </span></a>
                  </li>
              </ul>

          </div>
          <!-- Sidebar -->
          <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

  </div>
  <!-- Left Sidebar End -->

  <style>
    .page_hd {    width: 100%;
    text-align: center;
    color: #FFF;
    font-size: 22px;
    text-transform: uppercase;
    line-height: 70px;}

  </style>
