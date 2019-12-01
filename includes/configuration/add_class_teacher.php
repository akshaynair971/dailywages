<?php 
  $r=$db->get_results("SELECT * FROM institute");  
?>
<?php

    if(isset($_GET['edit_teach']) && $_GET['edit_teach']!='')
    {
        $ed_id = $_GET['edit_teach'];
        $r=$db->get_row("SELECT * FROM class_teacher_assign WHERE teacher_id='$ed_id'");
    }
?>  

<?php  
  $classes=$db->get_results("SELECT * FROM course WHERE inst_id='".$_SESSION['inst_id']."'");
  $board=$db->get_results("SELECT * FROM board WHERE inst_id='".$_SESSION['inst_id']."'");
  $section=$db->get_results("SELECT * FROM section WHERE inst_id='".$_SESSION['inst_id']."'");
  $acd_year=$db->get_results("SELECT * FROM academic_year WHERE inst_id='".$_SESSION['inst_id']."'");
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

              <h4><b>Assign Class Teacher</b></h4>
              <div id="status"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="form-group">
                    <label> Class Name <span style="color: red;">*</span></label>
                    <select class="form-control" name="cl_name" id="cl_name" onchange="load_teach_assign();" required>
                      <option value="">Select Class Name</option>
                        <?php
                            if ($classes){
                              foreach ($classes as $class_key){
                        ?>
                        <option value="<?php echo $class_key->class_id;?>" <?php if($class_key->class_id==$r->class_id){ echo 'selected'; }?>><?php echo $class_key->class_name; ?></option>
                      <?php } } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label> Board Name <span style="color: red;">*</span></label>
                    <select class="form-control" name="bo_name" id="bo_name" onchange="load_teach_assign();" required>
                      <option value="">Select Board Name</option>
                      <?php
                          if ($board) {
                            foreach ($board as $board_key) {
                               
                      ?>
                      <option value="<?php echo $board_key->board_id; ?>" <?php if($board_key->board_id==$r->board_id){ echo 'selected'; }?>><?php echo $board_key->board_name; ?></option>
                      <?php }} ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label> Class Section <span style="color: red;">*</span></label>
                     <select class="form-control" name="cl_section" id="cl_section" onchange="load_teach_assign();" required>
                        <option value="">Select Class Section</option>
                        <?php
                            if ($section) {
                              foreach ($section as $section_key) {
                        ?>
                        <option value="<?php echo $section_key->sec_id; ?>" <?php if($section_key->sec_id==$r->sec_id){ echo 'selected'; }?>><?php echo $section_key->sec_name; ?></option>
                        <?php }} ?>
                      </select>
                  </div>



                  <div class="form-group">
                    <label> Academic Year <span style="color: red;">*</span></label>
                      <select class="form-control" name="ac_year" id="ac_year" onchange="load_teach_assign();" required>
                        <option value="">Select Academic Year</option>
                        <?php
                            if ($acd_year) {
                              foreach ($acd_year as $acd_yr_key) {       
                        ?>
                        <option value="<?php echo $acd_yr_key->ay_id; ?>" <?php if($acd_yr_key->ay_id==$r->ay_id){ echo 'selected'; }?>><?php echo $acd_yr_key->start_year; ?> - <?php echo $acd_yr_key->end_year; ?></option>
                        <?php }} ?>
                      </select>
                  </div>


                  <div class="form-group">
                        <label>Teacher Name <span style="color: #e22b0e;">*</span> &nbsp;&nbsp;&nbsp;<div id="status"></div></label>

                        <select class="form-control" name="teach_name" id="teach_name" onchange="load_teach_assign();" required>
                          <option value="">Select Teacher Name</option>
                          <?php 
                            $get_teach = $db->get_results("SELECT * From user WHERE inst_id='".$_SESSION['inst_id']."' AND user_type_id='3'");
                            foreach($get_teach as $teacher){
                          ?>
                          <option value="<?php echo $teacher->user_id; ?>" <?php if($teacher->user_id==$r->user_id){ echo 'selected'; }?>><?php echo $teacher->user_name; ?></option>
                          <?php } ?>
                        </select>
                  </div>
                  
                  <div class="form-group">
                        <input type="submit" id="class_teacher_assign" value="Submit" class="btn btn-primary btn-round" name="class_teacher_assign">&nbsp;

                        <a href="?folder=configuration&file=teacher_assign_view" class="btn btn-primary btn-round">Go Back</a>
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
function load_teach_assign()
{
  var cl_name = $('#cl_name').val();
  var bo_name = $('#bo_name').val();
  var cl_section = $('#cl_section').val();
  var ac_year = $('#ac_year').val();
  var teach_name = $('#teach_name').val();

  $.ajax({ 
    type:'POST',
    url:'./check_data.php',
    data:{cl_name:cl_name,bo_name:bo_name,cl_section:cl_section,ac_year:ac_year,teach_name:teach_name},
    success:function(reply)
    {
      $('#status').html(reply);
    }
  });
}
</script>     