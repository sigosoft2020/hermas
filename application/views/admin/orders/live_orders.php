<!DOCTYPE html>
<html>
  <head>
    <?php $this->load->view('admin/includes/includes.php'); ?>
    <?php $this->load->view('admin/includes/table-css.php'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('admin/includes/sidebar.php'); ?>
      <div class="content-page">
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="page-title-box">
                  <h4 class="page-title float-left">Live Orders</h4>
                  
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
                          <th width="10%">Order No</th>
                          <th width="10%">Invoice No</th>
                          <th width="25%">Name</th>
                          <th width="10%">Email</th>
                          <th width="15%">Mobile</th>
                          <th width="10%">Status</th>
                          <th width="10%">View</th>
                          <th width="10%">Update</th>
                      </tr>
                    </thead>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('admin/includes/footer.php'); ?>

     <div id="edit-salesman" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
          <div class="modal-dialog">
              <div class="modal-content">

                  <div class="modal-body">
                      <h2 class="text-uppercase text-center m-b-30">
                          <span><h4>Edit Salesman</h4></span>
                      </h2>
                      <form class="form-horizontal" action="<?=site_url('admin/salesman/update')?>" method="post">
                           <input type="hidden" name="salesman_id" id="salesman_id" class="form-control">
                          <div class="form-group m-b-25">
                              <div class="col-12">
                                  <label for="select">Salesman Name</label>
                                  <input type="text" name="salesman" id="salesman" class="form-control" required>
                              </div>
                          </div>
                        
                          <div class="form-group account-btn text-center m-t-10">
                              <div class="col-12">
                                  <button type="reset" class="btn btn-primary btn-rounded waves-light waves-effect w-md " data-dismiss="modal">Back</button>
                                  <button class="btn btn-success btn-rounded waves-light waves-effect w-md " type="submit">Update</button>
                              </div>
                          </div>
                      </form>
                 </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div>

    </div>
  </body>
  <?php $this->load->view('admin/includes/scripts.php'); ?>
  <?php $this->load->view('admin/includes/table-script.php'); ?>
  <script type="text/javascript">
    $(document).ready(function(){
      var dataTable = $('#user_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url:"<?=site_url('admin/orders/get')?>",
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
  <script>
    function del()
    {
      if (confirm('Are you sure to delete this banner ?')) {
        return true;
      }
      else {
        return false;
      }
    }

    function edit(id)
    {
      $('#salesman_id').val(id);
      // alert(id);
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('admin/salesman/getsalesmanById');?>",
          dataType : "json",
          data : { id : id },
          success : function( data ){
            $('#salesman').val(data.salesman_name);
            $('#edit-salesman').modal('show');
            // alert(data);
          }
        });
    }

  </script>
</html>
