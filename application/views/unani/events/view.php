<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('unani/includes/includes.php'); ?>
    <?php $this->load->view('unani/includes/table-css.php'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('unani/includes/sidebar.php'); ?>
      <div class="content-page">
        <div class="content">

          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="page-title-box">
                  <h4 class="page-title float-left">Events</h4>
                  <!-- <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Add amenity</button>
                  </ol> -->
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <table id="user_data" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th width="20%">Title</th>
                          <th width="35%">Description</th>
                          <th width="10%">Date</th>
                          <th width="10%">Time</th>
                          <th width="5%">Days</th>
                          <th width="10%">Venue</th>
                          <th width="5%">Status</th>
                          <th width="5%">Edit</th>

                      </tr>
                    </thead>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('unani/includes/footer.php'); ?>
    </div>
   
  </body>
  <?php $this->load->view('unani/includes/scripts.php'); ?>
  <?php $this->load->view('unani/includes/table-script.php'); ?>
  <script type="text/javascript">
    $(document).ready(function(){
      var dataTable = $('#user_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url:"<?=site_url('unani/events/get')?>",
          type:"POST"
        },
        "columnDefs":[
          {
            "target":[0,3,4],
            "orderable":true
          }
        ]

      });

    });
  </script>
 
</html>
