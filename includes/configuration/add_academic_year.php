<?php 

    if(isset($_GET['edit_ay']) && $_GET['edit_ay']!='')
    {
        $ed_id = $_GET['edit_ay'];
        $ay_edit = $db->get_row("SELECT * FROM academic_year WHERE ay_id='$ed_id'");
    }

?>

<!-- Main content -->
    <section class="content">  
      <div class="row">
        <div class="col-md-2 col-lg-2"></div>
        <div class="col-md-7 col-lg-7">
          
          <div class="box">
            <div class="box-header">
              <?php  
                if(isset($msg))
                {
                  echo"<div style='font-size:18px; color:red; margin-left:15px; font-weight:700;'>".$msg."</div>";
                }
                if(isset($succ))
                {
                  echo"<div style='font-size:18px; color:green; margin-left:15px; font-weight:700;'>".$succ."</div>";
                }
              ?>
              <h3>Add Academic Year</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="col-md-12 col-sm-12 col-xs-12">
                 &nbsp;&nbsp;&nbsp;<div id="status"></div>
                  <div class="form-group">
                      <label for="exampleInputEmail1">Start Year <span style="color: #e22b0e;">*</span></label>
                      <input type="text" class="form-control" id='datepicker' placeholder="Enter Start Year Only" name='start_year' onchange="check_acd_yr();" value="<?php if(isset($ay_edit)){ echo $ay_edit->start_year; } ?>" required>
                          
                  </div>
                  <div class="form-group">
                      <label for="exampleInputEmail1">End Year <span style="color: #e22b0e;">*</span></label>
                      <input type="text" class="form-control" id='datepicker1' name='end_year' placeholder="Enter End Year Only" onchange="check_acd_yr();" value="<?php if(isset($ay_edit)){ echo $ay_edit->end_year; } ?>" required>
                          
                  </div>
                  
                  <div class="form-group">
                        <input type="submit" value="Submit" id="academic_btn" class="btn btn-primary btn-round" name="save_ay"> &nbsp;
                        <a href="?folder=configuration&file=academic_years" class="btn btn-primary btn-round">Go Back</a>

                  </div>
                </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

    <script src="dist/js/jquery-1.10.2.js"></script>

    <script>
    $(function() {
      $( "#datepicker,#datepicker1" ).datepicker({
        dateFormat: 'yy-mm',
        changeMonth: true,
        changeYear: true,
        yearRange: "1950:2050"
      });
    });
    </script>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
    function check_acd_yr()
    {
      var datepicker = $('#datepicker').val();
      var datepicker1 = $('#datepicker1').val();

      // alert(datepicker1);

      $.ajax({ 
        type:'POST',
        url:'./check_data.php',
        data:{datepicker:datepicker,datepicker1:datepicker1},
        success:function(reply)
        {
          $('#status').html(reply);
        }
      });
    }
    </script> 