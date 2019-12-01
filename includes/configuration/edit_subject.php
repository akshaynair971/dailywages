<?php

    if(isset($_GET['ed_sub'])) 
    {
        $ed_id = $_GET['ed_sub'];

        $sub_edit = $db->get_row("SELECT * FROM subject WHERE sub_id='$ed_id'");
    }
?>  

<?php  
    $classes=$db->get_results("SELECT * FROM course WHERE inst_id='".$_SESSION['ad_id']."'");
    
    $board=$db->get_results("SELECT * FROM board WHERE inst_id='".$_SESSION['ad_id']."'");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<script type="text/javascript">
  var rowCount = 0; 
</script>


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
                 
                    <h5 style="font-size:18px; color:red; margin-left:15px; font-weight:700;"><b>Sorry This Subject Already Exist</b> </h5>

              <?php header("Refresh:2.5; url=index.php?folder=configuration&file=add_subject"); } ?>

              <h3>Add New Subject</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
              <form method="POST" action="" enctype="multipart/form-data">

                <div class="col-md-12 col-sm-12 col-xs-12">
                   &nbsp;&nbsp;&nbsp;<div id="status"></div>


                  <div class="form-group">
                        <label for="exampleInputEmail1">Class <span style="color: #e22b0e;">*</span></label>
                        <select class="form-control" id='c_name' name='sub_class' onchange="check_subject();" required>
                          <option value="">Select Class</option>
                          <?php
                              if ($classes) {
                                foreach ($classes as $class_key) {
                          ?>
                          <option value="<?php echo $class_key->class_id; ?>"<?php if($class_key->class_id==$sub_edit->class){ echo "selected";} ?>><?php echo $class_key->class_name; ?></option>
                        <?php }} ?>
                        </select>
                          
                  </div>
                  <div class="form-group">
                        <label for="exampleInputEmail1">Board <span style="color: #e22b0e;">*</span></label>
                        <select class="form-control" id='b_name' name='board' onchange="check_subject();" required>
                          <option value="">Select Board</option>
                          <?php
                              if ($board) {
                                foreach ($board as $board_key) {
                                   
                          ?>
                          <option value="<?php echo $board_key->board_id; ?>"<?php if($board_key->board_id==$sub_edit->board){ echo "selected";} ?>><?php echo $board_key->board_name; ?></option>
                          <?php }} ?>
                        </select>
                          
                  </div>
                  <div class="form-group">
                        <label for="exampleInputEmail1">Subject <span style="color: #e22b0e;">*</span></label>
                        <input type="text" class="form-control" id='s_name' name='subject' placeholder="Enter Class" onkeyup="check_subject();" value="<?php if(isset($sub_edit)){ echo $sub_edit->subject; } ?>" required>
                          
                  </div>
                  <div class="form-group">
                        <input type="submit" value="Submit" id="subject_btn" class="btn btn-primary btn-round" name="save_subject_list">
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
    function check_subject()
    {
      // alert('helo');
      var c_name = $('#c_name option:selected').val();
      var b_name = $('#b_name option:selected').val();
      var s_name = $('#s_name').val();

      // alert(s_name);

      $.ajax({ 
        type:'POST',
        url:'./check_data.php',
        data:{c_name:c_name,b_name:b_name,s_name:s_name},
        success:function(reply)
        {
          $('#status').html(reply);
        }
      });
    }
</script>      