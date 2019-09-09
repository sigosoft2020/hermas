  <?php $owner = $this->session->userdata['owner']; ?>
  <div class="topbar">
      <!-- LOGO -->
      <div class="topbar-left">
          <a href="<?=site_url('admin/dashboard')?>" class="logo">
            <span>

               <img src="<?=base_url()?>assets/images/logo.png" alt="" height="50">
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
                       <span class="ml-1"><?=$owner['name']?><i class="mdi mdi-chevron-down"></i> </span>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                      <a href="<?=site_url('users/logoutOwner')?>" class="dropdown-item notify-item">
                          <i class="fi-power"></i> <span>Logout</span>
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
                      <a href="<?=site_url('owner/dashboard')?>">
                          <i class="fa fa-dashcube"></i><span> Dashboard </span>
                      </a>
                  </li>

                  <li>
                      <a href="#"><i class="fa fa-futbol-o"></i> <span> Turfs </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('owner/turfs')?>">Active turfs</a></li>
                          <li><a href="<?=site_url('owner/turfs/blocked')?>">Blocked turfs</a></li>
                          <li><a href="<?=site_url('owner/turfs/pending')?>">Pending turfs</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="#"><i class="fa fa-book"></i> <span> Bookings </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('owner/bookings/upcoming')?>">Upcoming</a></li>
                          <li><a href="<?=site_url('owner/bookings/completed')?>">Completed</a></li>
                          <li><a href="<?=site_url('owner/bookings/cancelled')?>">Cancelled</a></li>
                          <li><a href="<?=site_url('owner/bookings/add')?>">Add booking</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="#"><i class="fa fa-user"></i> <span>My Customers </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('owner/customers')?>">View customers</a></li>
                          <li><a href="<?=site_url('owner/customers/add')?>">Add customer</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="#"><i class="fa fa-user"></i> <span> Staffs </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('owner/staffs')?>">View staffs</a></li>
                          <li><a href="<?=site_url('owner/staffs/add')?>">Add staff</a></li>
                      </ul>
                  </li>


                  <li>
                      <a href="#"><i class="fa fa-money"></i> <span> Expenses </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('owner/expenses')?>">View expenses</a></li>
                          <li><a href="<?=site_url('owner/expenses/add')?>">Add expense</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="#"><i class="fa fa-credit-card-alt"></i> <span> Payments </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('owner/payments')?>">View payments</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="<?=site_url('owner/feedbacks')?>"><i class="fa fa-comments-o"></i> <span> Feedbacks </span></a>
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
