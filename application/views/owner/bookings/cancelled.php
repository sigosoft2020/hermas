<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('owner/includes/includes.php'); ?>
    <?php $this->load->view('owner/includes/table-css.php'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('owner/includes/sidebar.php'); ?>
      <div class="content-page">
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="page-title-box">
                  <h4 class="page-title float-left">CANCELLED BOOKINGS</h4>
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
                        <th width="15%">Turf</th>
                        <th width="15%">Customer name</th>
                        <th width="10%">Mobile number</th>
                        <th width="10%">Date</th>
                        <th width="10%">Time</th>
                        <th width="10%">Pitch</th>
                        <th width="10%">Cash recieved</th>
                        <th width="5%">Payment method</th>
                        <th width="5%">Details</th>
                        <th width="5%">Refund</th>
                      </tr>
                    </thead>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('owner/includes/footer.php'); ?>
    </div>
    <div class="modal fade" id="cancel-booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">REFUND</h4>
          </div>
          <div class="modal-body">
            <form method="post" action="<?=site_url('owner/bookings/refund')?>">
            <input type="hidden" name="book_id" id="book_id">
            <div class="form-group">
              <div id="customer-details">

              </div>
            </div>

            <div class="form-group">
              <label>Advance amount paid</label>
              <input type="text" class="form-control" id="advance" readonly>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Refunded</button>
          </form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </body>
  <?php $this->load->view('owner/includes/scripts.php'); ?>
  <?php $this->load->view('owner/includes/table-script.php'); ?>
  <script type="text/javascript">
    $(document).ready(function(){
      var dataTable = $('#user_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url:"<?=site_url('owner/bookings/getCancelled')?>",
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

    function refund(book_id)
    {
      $.ajax({
        method: "POST",
        url: "<?=site_url('owner/bookings/getBookingDetails');?>",
        data : { book_id : book_id },
        dataType : "json",
        success : function( data ){
          $('#customer-details').html(data.details);
          $('#advance').val(data.cash_received);
          $('#book_id').val(book_id);

          $('#cancel-booking').modal('show');

          console.log(data);
        }
      });
    }
  </script>
</html>