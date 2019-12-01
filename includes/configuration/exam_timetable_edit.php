
<form method="POST" enctype="multipart/form-data">
<section class="content">
          <div class="row">
            
    <!---kyc details-->
    <div class="col-md-8 col-sm-8">
      <div class="box box-primary">
    
        <div class="box-header">
          <h3 class="box-title">User Registration</h3>
            <div class="box-tools">
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
          </div>
        </div>
    
        <div class="box-body">

          <?php
          if(isset($_GET['ed_sub']))
            {
              $id=$_GET['ed_sub'];

              $r=$db->get_row("SELECT * FROM exam_time_tabledb WHERE exam_id='$id'");
            }

            
                $classes=$db->get_results("SELECT * FROM course WHERE inst_id='".$_SESSION['ad_id']."'");
                $board=$db->get_results("SELECT * FROM board WHERE inst_id='".$_SESSION['ad_id']."'");
                $emp=$db->get_results("SELECT * FROM user WHERE inst_id='".$_SESSION['ad_id']."' AND user_type_id='3'");

                $get_section = $db->get_results("SELECT * FROM section WHERE inst_id='".$_SESSION['ad_id']."'");
                $get_acdemic_yr = $db->get_results("SELECT * FROM academic_year WHERE inst_id='".$_SESSION['ad_id']."'");

                $subject=$db->get_results("SELECT * FROM subject WHERE inst_id='".$_SESSION['ad_id']."'");
            

          ?>
              <div class="card">
                <div class="card-body">
                  
                    <div class="form-group">
                      <label >Standard (<span style="color:#f30505;">*</span>) </label>
                      <select class="form-control" id="class_id" name="standard_name" required onchange="load_emp();">
                        <option value="">Select Standard</option>
                        <?php
                           if ($classes){
                              foreach ($classes as $class_key){         
                        ?>
                        <option value="<?php echo $class_key->class_id; ?>"<?php if($class_key->class_id==$r->class_id){ echo "selected";} ?>><?php echo $class_key->class_name; ?></option>
                      <?php } } ?>
                      </select>
                    </div>


                    <div class="form-group">
                      <label>Board (<span style="color:#f30505;">*</span>) </label>
                          <select class="form-control" id="board_id" name="board_name" required onchange="load_emp();">
                            <option>Select Board</option>
                            <?php
                               if ($board){
                                  foreach ($board as $board_key){ 
                            ?>
                            <option value="<?php echo $board_key->board_id; ?>"<?php if($board_key->board_id==$r->board_id){ echo "selected";} ?>><?php echo $board_key->board_name; ?></option>
                          <?php } } ?>
                          </select>
                    </div>

                    <div class="form-group">
                      <label>Section (<span style="color:#f30505;">*</span>) </label>
                          <select class="form-control" name="section" required>
                            <option>Select Section</option>
                            <?php
                            if ($get_section){
                              foreach ($get_section as $sec){ 
                            ?>
                            <option value="<?php echo $sec->sec_id; ?>"<?php if($sec->sec_id==$r->sec_id){ echo "selected";} ?>><?php echo $sec->sec_name; ?></option>
                          <?php } } ?>
                          </select>
                    </div>

                    <div class="form-group">
                      <label>Academic Year (<span style="color:#f30505;">*</span>) </label>
                         <select class="form-control" name="acd_yr" required>
                           <option>Select Academin Year</option>
                           <?php
                              if ($get_acdemic_yr){
                                foreach ($get_acdemic_yr as $a_yr){  
                           ?>
                           <option value="<?php echo $a_yr->ay_id; ?>" <?php if($a_yr->ay_id==$r->ay_id){ echo "selected";} ?>><?php echo $a_yr->start_year; ?> - <?php echo $a_yr->end_year; ?></option>
                         <?php } } ?>
                         </select>
                    </div>

                    <div class="form-group">
                      <label>Subject Name (<span style="color:#f30505;">*</span>) </label>
                          <select class="form-control" name="subject" id="subject" required>
                            <option>Select Subject Name</option>
                            <?php 
                              if($subject){
                                foreach($subject as $sbjct){
                            ?>
                            <option value="<?php echo $sbjct->sub_id; ?>" <?php if($sbjct->sub_id==$r->sub_id){ echo "selected";} ?>><?php echo $sbjct->subject; ?></option>
                          <?php } } ?>
                          </select>
                    </div>

                    <div class="form-group">
                      <label>Date (<span style="color:#f30505;">*</span>) </label>
                          <input type="text" id="datepicker" name="exam_date" class="form-control" placeholder="Enter Date" value="<?php if(isset($r)){echo $r->exam_date; }?>" required >
                    </div>

                    <div class="form-group">
                      <label>Exam Start Time (<span style="color:#f30505;">*</span>) </label>
                          <input type="text" id="mobileno" name="start_exam_time" class="form-control" placeholder="Enter Exam Start Time" value="<?php if(isset($r)){echo $r->exam_start_time; }?>" required >
                    </div>

                    <div class="form-group">
                      <label>Exam End Time (<span style="color:#f30505;">*</span>) </label>
                          <input type="text" id="mobileno" name="end_exam_time" class="form-control" placeholder="Enter Exam End Time" value="<?php if(isset($r)){echo $r->exam_end_time; }?>" required >
                    </div>

                   
                    
                    
                     
                  
                    <input type="hidden" value="<?php echo $r->exam_id ;?>" name="exam_id">

                    <input type="submit" name="add_exam_time_table" class="btn btn-primary form-control" value="Submit">
              
                  </form>
                </div>
            
              </div>
      <!---end-->
    </div>
    

      </div>
          
         
        </div>
</section>

        </form>
      
        

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
  $( "#datepicker" ).datepicker({
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true,
    yearRange: "1950:2050"
  });
});
</script>
<script>
function load_emp() 
{
  var gsubclass_name = $('#class_id option:selected').val();
  var gsubboard_name = $('#board_id option:selected').val();

// alert(board_name);

$.ajax({ 
  type:'POST',
  url:'./load_subject.php',
  data:{gsubclass_name:gsubclass_name,gsubboard_name:gsubboard_name},
  success:function(reply)
  {
    console.log(reply);
    $('#subject').html(reply);
  }
})
}
</script> 

<?php if(isset($_GET['ed_sub'])){ ?> <script> load_emp(); </script> <?php } ?>