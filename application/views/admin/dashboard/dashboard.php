<!DOCTYPE html>
<html>
    <head>
      <?php $this->load->view('admin/includes/includes'); ?>
      <style media="screen">
        .button {
          color: black;
          padding: 20px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          border-radius: 50%;
        }
        .button-pitch{
          color: black;
          padding: 20px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
        }
        .button-slot {
          color: black;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          padding-top:25px;
          padding-bottom:25px;
          border-radius: 100%;
        }
        .class-ul li{
          list-style: none;
          display: inline;
        }
        
      </style>
    </head>
    <body>
        <div id="wrapper">
            <?php $this->load->view('admin/includes/sidebar'); ?>

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title float-left">Dashboard</h4>

                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="#">Hermas</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <a style="text-decoration:none;color:#797979;" href="<?=site_url('admin/bookings/upcoming')?>"><div class="card-box tilebox-one">
                                    <i class="fi-box float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Pending Orders</h6>
                                    <!-- <h4 class="mb-3" data-plugin="counterup"><?=$pending?></h4> -->
                                    <!-- <span class="badge badge-primary"> +11% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div></a>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <a style="text-decoration:none;color:#797979;" href="<?=site_url('admin/bookings/upcoming')?>"><div class="card-box tilebox-one">
                                    <i class="fi-layers float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Cancelled Orders</h6>
                                    <!-- <h4 class="mb-3"><span data-plugin="counterup"><?=$bookingThisMonth?></span></h4> -->
                                    <!-- <span class="badge badge-primary"> -29% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div></a>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <a style="text-decoration:none;color:#797979;" href="<?=site_url('admin/turfs')?>"><div class="card-box tilebox-one">
                                    <i class="fi-tag float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Delivered Orders</h6>
                                    <!-- <h4 class="mb-3"><span data-plugin="counterup"><?=$turf?></span></h4> -->
                                    <!-- <span class="badge badge-primary"> 0% </span> <span class="text-muted ml-2 vertical-middle">From previous period</span> -->
                                </div></a>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <a style="text-decoration:none;color:#797979;" href="<?=site_url('admin/customers')?>"><div class="card-box tilebox-one">
                                    <i class="fi-briefcase float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Total Orders</h6>
                                    <!-- <h4 class="mb-3" data-plugin="counterup"><?=$users?></h4> -->
                                    <!-- <span class="badge badge-primary"> +89% </span> <span class="text-muted ml-2 vertical-middle">Last year</span> -->
                                </div></a>
                            </div>

                        </div>
                        
                        
                       <!--  <div class="row">
                          <div class="col-lg-12">
                              <div class="card-box">
                                  <h4 class="header-title mb-4">Booking Calendar</h4>

                                  <div class="col-md-4">
                                    <label>Select turf</label>
                                    <select class="form-control form-control-xs selectpicker" name="turf_id" data-size="7" data-live-search="true" data-title="Search turfname" id="turf" data-width="100%" required>
                                      <option value="0">--- Choose turf ---</option>
                                      <?php foreach ($turfs as $turf) { ?>
                                        <option value="<?=$turf->turf_id?>" data-subtext="<?=$turf->place?>"><?=$turf->turf_name?></option>
                                      <?php } ?>
                                    </select>
                                  </div>

                                  <div class="col-md-12 mt-3">
                                    <div id="date-div">

                                    </div>
                                  </div>

                                  <div class="col-md-12 mt-3">
                                    <div id="pitch-div" class="button-list">

                                    </div>
                                  </div>

                                  <div class="col-md-12 mt-3">
                                    <div id="slot-div" class="button-list">

                                    </div>
                                  </div>

                              </div>
                          </div>
                        </div> -->



                        <!-- end row -->

                <!--         <div class="row">
                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">New users</h4>

                                    <div class="inbox-widget slimscroll" style="max-height: 370px;">
                                      <?php foreach ($customers as $user) { ?>

                                        <a href="<?=site_url('admin/customers')?>">
                                            <div class="inbox-item">
                                                <div class="inbox-item-img"><img src="<?=base_url() . $user->image?>" class="rounded-circle bx-shadow-lg" alt=""></div>
                                                <p class="inbox-item-author"><?=$user->username?></p>
                                                <p class="inbox-item-text"><?=$user->email . ", " . $user->mobile?></p>
                                            </div>
                                        </a>

                                     <?php } ?>

                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Latest Feedbacks</h4>

                                    <div class="comment-list slimscroll" style="max-height: 370px;">
                                      <?php foreach ($feedbacks as $feedback) { ?>

                                        <a href="<?=site_url('admin/feedbacks')?>">
                                            <div class="comment-box-item">
                                                <div class="badge badge-pill badge-success"><?=$feedback->turf_name?></div>
                                                <p class="commnet-item-date">1 month ago</p>
                                                <h6 class="commnet-item-msg"><?=$feedback->review?></h6>
                                                <?php for ($i=0; $i < $feedback->rating; $i++) { ?>
                                                  <i style="color:#a9a6a6;font-size:10px;" class="fa fa-star"></i>
                                                <?php } ?>
                                                <p class="commnet-item-user"><?=$feedback->username?></p>
                                            </div>
                                        </a>

                                      <?php } ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Last expenses</h4>

                                    <ul class="list-unstyled transaction-list slimscroll mb-0" style="max-height: 370px;">
                                      <?php foreach ($expenses as $exp) { ?>

                                        <a style="color:#797979;" href="<?=site_url('admin/expenses')?>"><li>
                                            <i class="dripicons-arrow-down text-success"></i>
                                            <span class="tran-text"><?=$exp->notes?></span>
                                            <span class="pull-right text-success tran-price"><?=$exp->expense?></span>
                                            <span class="pull-right text-muted"><?=$exp->date?></span>
                                            <span class="clearfix"></span>
                                        </li></a>

                                      <?php } ?>
                                    </ul>

                                </div>
                            </div>

                        </div> -->


                    </div> <!-- container -->

                </div> <!-- content -->

                <?php $this->load->view('admin/includes/footer') ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <?php $this->load->view('admin/includes/scripts') ?>
        <script type="text/javascript">
          var selected_button = 0;
          var selected_pitch = 0;
          var date = '';
          var day_id  = '';
          var slots = [];
          var ts_ids = [];
          var tp_id = 0;
          $('#turf').on('change',function(){
            var turf_id = $('#turf').val();
            if (turf_id == 0) {
              $('#date-div').html('');
              $('#slot-div').html('');
              $('#pitch-div').html('');
            }
            else {
              $.ajax({
                method: "POST",
                url: "<?=site_url('admin/dashboard/getDates');?>",
                dataType : "json",
                success : function( data ){
                  $('#date-div').html(data.string);
                }
              });
            }
          });
          function getPitches(id)
          {
            $('#slot-div').html('');
            $('#pitch-div').html('');

            $('#btn_'+id).addClass('btn-success');
            if (selected_button != 0) {
              $('#btn_'+selected_button).removeClass('btn-success');
            }
            window.selected_button = id;

            var reference = $('#btn_'+id);
            window.date = reference.attr('name');
            window.day_id = reference.val();

            var turf_id = $('#turf').val();

            $.ajax({
              method: "POST",
              url: "<?=site_url('admin/dashboard/getPitches');?>",
              data : { turf_id : turf_id },
              dataType : "json",
              success : function( data ){
                $('#pitch-div').html(data);
              }
            });
          }
          function getSlots(id){
            $("#fee-div").css("display", "none");
            $('#pitch_'+id).addClass('btn-success');
            if (selected_pitch != 0) {
              $('#pitch_'+selected_pitch).removeClass('btn-success');
            }
            selected_pitch = id;

            var reference = $('#pitch_'+id);
            window.tp_id = reference.attr('name');
            var turf_id = $('#turf').val();

            $.ajax({
              method: "POST",
              url: "<?=site_url('admin/dashboard/getTimeSlots');?>",
              data : { turf_id : turf_id , tp_id : tp_id , date : date},
              dataType : "json",
              success : function( data ){
                $('#slot-div').html(data);
              }
            });

          }
        </script>
    </body>
</html>
