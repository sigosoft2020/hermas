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
                  <h4 class="page-title float-left">ADD EVENTS</h4>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card-box">
                <form action="<?=site_url('unani/events/addEvent')?>" method="post" id="add-form" onsubmit="return finalize()">


                  <div class="row">
                      <div class="col-md-6">
                         <div class="">
                            <div>
                                <p class="mb-1 mt-4 font-weight-bold">Title <span style="color:red">*</span></p>
                                <input type="text" maxlength="50" name="name" class="form-control" required>
                             </div>

                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Description <span style="color:red">*</span></p>
                                  <textarea name="description" rows="4" cols="80" class="form-control" required></textarea>
                              </div>

                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Date <span style="color:red">*</span></p>
                                  <input type="date" maxlength="10" name="date" id="date" class="form-control" required>
                                  <p id="date_error" style="display:none;color:red">Invalid date</p>
                              </div>

                              <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Time</p>
                                  <input type="time" name="time" id="time" class="form-control" required>
                              </div>

                               <div>
                                  <p class="mb-1 mt-4 font-weight-bold">Venue</p>
                                  <input type="text" maxlength="100" name="venue" id="venue" class="form-control" required>
                               </div>

                               <div>
                                  <p class="mb-1 mt-4 font-weight-bold">No of days</p>
                                  <input type="number" min="1" name="no_of_days" id="no_of_days" class="form-control" required>
                              </div>  
                          </div>
                        </div>

                      <div class="col-md-12 mt-4">
                        <button type="submit" class="btn btn-success btn-rounded waves-light waves-effect w-md pull-right" id="submit-button">Add</button>
                      </div>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('unani/includes/footer.php'); ?>
    </div>
  </body>
  <?php $this->load->view('unani/includes/scripts.php'); ?>
 
  <script type="text/javascript">

    function finalize()
      {
        var end    = $('#date').val();
        var myDate = new Date(end);
        var today  = new Date();
        
        if (myDate > today) {
          $('#date_error').text('Please select valid date');
          $('#date_error').fadeIn().delay(1500).fadeOut(1200);
          return false;
        }
        else {
          $('#date_error').text('');
          return true;
          
          }
      }
  </script>
</html>