<?php 
  $r=$db->get_results("SELECT * FROM institute");  
?>
<?php
 
    if(isset($_GET['edit_dept']) && $_GET['edit_dept']!='')
    {
        $ed_id = $_GET['edit_dept'];
        $dept_edit = $db->get_row("SELECT * FROM department WHERE dept_id='$ed_id'");
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

              <?php if ($isexist>0) { ?>
                 
                    <h5 style="font-size:18px; color:red; margin-left:15px; font-weight:700;"><b>Sorry This Department Already Exist</b> </h5>

              <?php header("Refresh:2.5; url=index.php?folder=configuration&file=add_department"); } ?>

              <h3>Add Department</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="form-group">
                        <label for="exampleInputEmail1">Department <span style="color: #e22b0e;">*</span> &nbsp;&nbsp;&nbsp;<div id="status"></div></label>
                        <input type="text" class="form-control" id='depart_name' name='dept_name' placeholder="Enter Department" onkeyup="check_department();" value="<?php if(isset($dept_edit)){ echo $dept_edit->dept_name; } ?>" required>
                          
                  </div>
                  
                  <div class="form-group">
                        <input type="submit" value="Submit" id="depart_btn" class="btn btn-primary btn-round" name="save_department">&nbsp;
                        <a href="?folder=configuration&file=departments_view" class="btn btn-primary btn-round">Go Back</a>
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


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
function check_department()
{
  var depart_name = $('#depart_name').val();
  $.ajax({ 
    type:'POST',
    url:'./check_data.php',
    data:'depart_name='+depart_name,
    success:function(reply)
    {
      $('#status').html(reply);
    }
  });
}
</script>     