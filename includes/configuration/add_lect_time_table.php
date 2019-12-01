<?php
  
    if(isset($_GET['ed_id']) && $_GET['ed_id']!='')    
    {
        $ed_id = $_GET['ed_id'];
        $r = $db->get_row("SELECT * FROM lect_time_table WHERE lt_id='$ed_id'");
        

        $subject=$db->get_results("SELECT * FROM subject WHERE class='$r->class_id' AND board='$r->board_id'");

    }else{
        $subject=$db->get_results("SELECT * FROM subject WHERE inst_id='".$_SESSION['ad_id']."'");
    }
?>  
 
<?php  
    $classes=$db->get_results("SELECT * FROM course WHERE inst_id='".$_SESSION['ad_id']."'");
    $board=$db->get_results("SELECT * FROM board WHERE inst_id='".$_SESSION['ad_id']."'");

    $section = $db->get_results("SELECT * FROM section WHERE inst_id='".$_SESSION['ad_id']."'");

    $acdemic_yr = $db->get_results("SELECT * FROM academic_year WHERE inst_id='".$_SESSION['ad_id']."'");

    
?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

    <script type="text/javascript">
      var rowCount = 0;
    </script>

    <form method="POST" enctype="multipart/form-data" id="insert_form" class="insert_form">
    <section class="content">
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">
                    <div id="row_msg"></div>
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
                       
                          <h5 style="font-size:18px; color:red; margin-left:15px; font-weight:700;"><b>Sorry This Employee Subject Already Exist</b> </h5>

                    <?php header("Refresh:2.5; url=index.php?folder=configuration&file=employee_subjects"); } ?>
                    <div class="box-header"><br>
                      <h3 class="box-title"><b>Add Lecture Time Table</b><br> &nbsp;&nbsp;&nbsp;<div id="status"></div></h3>
                      
                    </div>
                 <div class="box-body">

    <div class="row">

          <div class="form-group col-md-6">
            <label>Class Name</label>
            <select class="form-control" onchange="checklectime();" id="class_id" name="class_name">
              <option value="">Select Class Name</option>
              <?php 
                if($classes){
                  foreach($classes as $class_key){
              ?>
              <option value="<?php echo $class_key->class_id; ?>" <?php if($class_key->class_id==$r->class_id){echo 'selected';} ?>><?php echo $class_key->class_name; ?></option>
              <?php } } ?>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label>Board Name</label>
            <select class="form-control" onchange="checklectime();" id="board_id" name="board_name">
              <option value="">Select Board Name</option>
              <?php 
                if($board){
                  foreach($board as $board_key){
              ?>
              <option value="<?php echo $board_key->board_id ?>" <?php if($board_key->board_id==$r->board_id){echo 'selected';} ?>><?php echo $board_key->board_name; ?></option>
              <?php } } ?>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label>Section</label>
            <select class="form-control" onchange="checklectime();" name="sec_name" id="sec_id">
              <option value="">Select Section</option>
              <?php 
                if($section){
                  foreach($section as $sec_key){
              ?>
              <option value="<?php echo $sec_key->sec_id ?>" <?php if($sec_key->sec_id==$r->sec_id){echo 'selected';} ?>><?php echo $sec_key->sec_name; ?></option>
              <?php } } ?>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label>Academic Year</label>
            <select class="form-control" onchange="checklectime();" name="acd_year" id="ay_id">
              <option value="">Select Academic Year</option>
              <?php 
                if($acdemic_yr){
                  foreach($acdemic_yr as $acd_yr_key){
              ?>
              <option value="<?php echo $acd_yr_key->ay_id ?>" <?php if($acd_yr_key->ay_id==$r->ay_id){echo 'selected';} ?>><?php echo $acd_yr_key->start_year; ?> - <?php echo $acd_yr_key->end_year; ?></option>
              <?php } } ?>
            </select>
          </div>
     
     
          <div class="col-lg-12 col-md-12 col-sm-12">

                  <div class="table-responsive"><br><br>
                   <span id="error"></span>
                   <table class="table table-bordered" id="item_table">
                    <tr>
                     <th class="text-center" style="width:13%; font-size: 13px;"> Start & End Time <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:13%; font-size: 13px;"> Monday <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:13%; font-size: 13px;"> Tuesday <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:13%; font-size: 13px;"> Wednesday <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:13%; font-size: 13px;">Thursday <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:13%; font-size: 13px;"> Friday <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:13%; font-size: 13px;"> Saturday <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:4%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus"></span></button><br>
                      <span style="font-size: 10px; color: red;">Click..</span></th>
                    </tr>
                   </table>
                  </div> 



                    <table class="table table-bordered" id="item_table">
                          <tbody>
                            <?php 
                             $json = json_decode($r->time_table_details);
                             if($json){
                              $rowCount=0;
                               for ($i=0; $i < count($json->start_time); $i++){
                                $rowCount++; 
                            ?>
                            
                            
                           
                            <tr>
                                <th style="width:13%; font-size: 13px;">
                                    <input type="text" class="form-control" placeholder="Start Time" name="start_time[]" id="start_time<?php echo $rowCount; ?>" value="<?php echo $json->start_time[$i]; ?>"><center>To</center><input type="text" class="form-control" placeholder="End Time" name="end_time[]" id="end_time<?php echo $rowCount; ?>" value="<?php echo $json->end_time[$i]; ?>">
                                </th>


                                <th style="width:13%; font-size: 13px;">
                                    <select name="mon_subject[]" id="subject<?php echo $rowCount; ?>" class="form-control" onchange="load_emp();">          
                                     <option value="">Select Subject</option>                               
                                        <?php
                                          
                                             foreach($subject as $sub){ 
                                        ?> 
                                      <option value="<?php echo $sub->sub_id;?>" <?php if($sub->sub_id==$json->mon_subject[$i]){echo "selected";} ?>><?php echo $sub->subject;?></option>
                                      <?php } ?> 
                                    </select>
                                </th>

                                <th style="width:13%; font-size: 13px;">
                                    <select name="tue_subject[]" id="subject1<?php echo $rowCount; ?>" class="form-control" onchange="load_emp();">          
                                     <option value="">Select Subject</option>                               
                                        <?php
                                          
                                             foreach($subject as $sub){ 
                                        ?> 
                                      <option value="<?php echo $sub->sub_id;?>" <?php if($sub->sub_id==$json->tue_subject[$i]){echo "selected";} ?>><?php echo $sub->subject;?></option>
                                      <?php } ?> 
                                    </select>
                                </th>

                                <th style="width:13%; font-size: 13px;">
                                    <select name="wed_subject[]" id="subject2<?php echo $rowCount; ?>" class="form-control" onchange="load_emp();">          
                                     <option value="">Select Subject</option>                               
                                        <?php
                                          
                                             foreach($subject as $sub){ 
                                        ?> 
                                      <option value="<?php echo $sub->sub_id;?>" <?php if($sub->sub_id==$json->wed_subject[$i]){echo "selected";} ?>><?php echo $sub->subject;?></option>
                                      <?php } ?> 
                                    </select>
                                </th>


                                <th style="width:13%; font-size: 13px;">
                                    <select name="thu_subject[]" id="subject3<?php echo $rowCount; ?>" class="form-control" onchange="load_emp();">          
                                     <option value="">Select Subject</option>                               
                                        <?php
                                          
                                             foreach($subject as $sub){ 
                                        ?> 
                                      <option value="<?php echo $sub->sub_id;?>" <?php if($sub->sub_id==$json->thu_subject[$i]){echo "selected";} ?>><?php echo $sub->subject;?></option>
                                      <?php } ?> 
                                    </select>
                                </th>


                                <th style="width:13%; font-size: 13px;">
                                    <select name="fri_subject[]" id="subject4<?php echo $rowCount; ?>" class="form-control" onchange="load_emp();">          
                                     <option value="">Select Subject</option>                               
                                        <?php
                                          
                                             foreach($subject as $sub){ 
                                        ?> 
                                      <option value="<?php echo $sub->sub_id;?>" <?php if($sub->sub_id==$json->fri_subject[$i]){echo "selected";} ?>><?php echo $sub->subject;?></option>
                                      <?php } ?> 
                                    </select>
                                </th>

                                <th style="width:13%; font-size: 13px;">
                                    <select name="sat_subject[]" id="subject5<?php echo $rowCount; ?>" class="form-control" onchange="load_emp();">          
                                     <option value="">Select Subject</option>                               
                                        <?php
                                          
                                             foreach($subject as $sub){ 
                                        ?> 
                                      <option value="<?php echo $sub->sub_id;?>" <?php if($sub->sub_id==$json->sat_subject[$i]){echo "selected";} ?>><?php echo $sub->subject;?></option>
                                      <?php } ?> 
                                    </select>
                                </th>
                              

                                <th style="width:4%;">
                                    <button type="button" name="remove" class="btn btn-danger btn-sm remove" onclick="setValue()"><span class="glyphicon glyphicon-minus"></span></button><br><span style="font-size: 10px; color: red;">Click Here..</span>
                                </th>
                            </tr>
                            <?php
                              if(isset($_GET['ed_id'])){ ?>
                               <script>
                                  <?php if($_GET['ed_id']!=''){ echo "rowCount =".$rowCount.";"; } ?>
                                  // load_emp(<?php echo $rowCount; ?>);
                                          
                                    </script> 
                               <?php } 
                              ?>
                        <?php }  } ?>

                      </tbody>
                  </table>

                </div>


              <div class="form-group col-md-6">
                   <input type="hidden" name="add_lect_time_tableclk" value="1">
                  <input type="submit" name="add_lect_time_table" id="save_emp" value="Create Lecture Time Table" class="btn btn-primary btn-round">&nbsp;

                  <a href="?folder=configuration&file=lect_time_table_view" class="btn btn-primary btn-round">Go Back</a>
             

              </div>
          </div>
        </div>
      </div>
    </div>          
    </section>
    </form>

    

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
    $(document).ready(function(){
      
     $(document).on('click','.add', function(){
      
      rowCount++;
       // alert(rowCount);
      var html = '';
      html += '<tr>';

      html += '<td><input type="text" class="form-control" placeholder="Start Time" name="start_time[]" id="start_time'+rowCount+'"><center>To</center><input type="text" class="form-control" placeholder="End Time" name="end_time[]" id="end_time'+rowCount+'"> </td>'; 


      html += '<td><select name="mon_subject[]" class="form-control" id="subject'+rowCount+'"></select></td>';

      html += '<td><select name="tue_subject[]" class="form-control" id="subject1'+rowCount+'"></select></td>';

      html += '<td><select name="wed_subject[]" class="form-control" id="subject2'+rowCount+'"></select></td>';

      html += '<td><select name="thu_subject[]" class="form-control" id="subject3'+rowCount+'"></select></td>';

      html += '<td><select name="fri_subject[]" class="form-control" id="subject4'+rowCount+'"></select></td>';

      html += '<td><select name="sat_subject[]" class="form-control" id="subject5'+rowCount+'"></select></td>';

      // html += '<td><input type="text" class="form-control" placeholder="Start Time" name="tue_start_time[]"><center>To</center><input type="text" class="form-control" placeholder="End Time" name="tue_end_time[]"></td>';

      // html += '<td><input type="text" class="form-control" placeholder="Start Time" name="wed_start_time[]"><center>To</center><input type="text" class="form-control" placeholder="End Time" name="wed_end_time[]"></td>';

      // html += '<td><input type="text" class="form-control" placeholder="Start Time" name="thu_start_time[]"><center>To</center><input type="text" class="form-control" placeholder="End Time" name="thu_end_time[]"></td>';

      // html += '<td><input type="text" class="form-control" placeholder="Start Time" name="fri_start_time[]"><center>To</center><input type="text" class="form-control" placeholder="End Time" name="fri_end_time[]"></td>';

      // html += '<td><input type="text" class="form-control" placeholder="Start Time" name="sat_start_time[]"><center>To</center><input type="text" class="form-control" placeholder="End Time" name="sat_end_time[]"></td>';


      html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus"></span></button><br><span style="font-size: 10px; color: red;">Click..</span></td></tr>';


      $('#item_table').append(html);
      load_emp(rowCount);
     });

     
     $(document).on('click', '.remove', function(){
      $(this).closest('tr').remove();
        // rowCount--;
     });
     
    });
    </script>


<script>
function load_emp(identify)
{
  // alert('hi');
  var class_name = $('#class_id option:selected').val();
  var board_name = $('#board_id option:selected').val();

// alert(class_name);

$.ajax({ 
  type:'POST',
  url:'./load_subject.php',
  data:{class_name:class_name,board_name:board_name },
  success:function(reply)
  {
    $('#subject'+identify+',#subject1'+identify+',#subject2'+identify+',#subject3'+identify+',#subject4'+identify+',#subject5'+identify).html(reply);
  }
})
}
</script> 

<script>
function checklectime(identify)
{
  // alert('hi');
  var class_id = $('#class_id option:selected').val();
  var board_id = $('#board_id option:selected').val();
  var sec_id = $('#sec_id option:selected').val();
  var ay_id = $('#ay_id option:selected').val();

// alert(class_id);
// alert(board_id);
// alert(sec_id);
// alert(ay_id);

$.ajax({ 
  type:'POST',
  url:'./check_data.php',
  data:{class_id:class_id,board_id:board_id,sec_id:sec_id,ay_id:ay_id,checklectime:"1"},
  success:function(reply)
  {
    // alert(reply);

    $('#status').html(reply);
  }
})
}
</script> 

<script>
   $(document).ready(function(ckeck_data){
        $('#save_emp').on('click',function(event){
          event.preventDefault();

          var n = $( "[name='class[]']" ).length+ckeck_data;
          
          if(n==0)
          {
            $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Add At Least One Row<span>');
          }
          else
          {
            if($( "[name='class[]']" ).val()=='')
            {
              $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Please Select Class Name<span>');
            }
            else if($( "[name='board_name[]']" ).val()=='')
            {
               $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Please Select Board Name<span>');
            }
             else if($( "[name='subject[]']" ).val()=='')
            {
               $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Please Select Subject Name<span>');
            }
             else if($( "[name='emp_name[]']" ).val()=='')
            {
               $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Please Select Employee Name<span>');
            }
            else
            {
              $('#insert_form').submit();
            }
          }
        });
    });
</script>
