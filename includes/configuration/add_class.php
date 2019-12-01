<?php 
  $r=$db->get_results("SELECT * FROM institute");  
?>
<?php

    if(isset($_GET['edit_stud']) && $_GET['edit_stud']!='')
    {
        $ed_id = $_GET['edit_stud'];
        $stud_edit = $db->get_row("SELECT * FROM course WHERE class_id='$ed_id'");
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
                 
                    <h5 style="font-size:18px; color:red; margin-left:15px; font-weight:700;"><b>Sorry This Class Already Exist</b> </h5>

              <?php header("Refresh:1.5; url=index.php?folder=configuration&file=add_class"); } ?>


              <h3>Add New Class</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="form-group">
                        <label for="exampleInputEmail1">Class <span style="color: #e22b0e;">*</span>  &nbsp;&nbsp;&nbsp;<div id="status"></div></label>
                        <input type="text" class="form-control" id='class_name' name='class_name' placeholder="Enter Class" onkeyup="load_state();" required="" value="<?php if(isset($stud_edit)){ echo $stud_edit->class_name; } ?>">
                          
                  </div>
                  
                  <div class="form-group">
                        <input type="submit" value="Submit" id="class_btn" class="btn btn-primary btn-round" name="save_class">&nbsp;
                        <a href="?folder=configuration&file=class_view" class="btn btn-primary btn-round">Go Back</a>
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
function load_state()
{
  var class_name = $('#class_name').val();
  $.ajax({ 
    type:'POST',
    url:'./check_data.php',
    data:'class_name='+class_name,
    success:function(reply)
    {
      $('#status').html(reply);
    }
  });
}
</script> 