<?php
  
    if(isset($_GET['edit_emp_sub']) && $_GET['edit_emp_sub']!='')    
    {
     echo $ed_id = $_GET['edit_emp_sub'];
     
        $emp_sub_edit = $db->get_row("SELECT * FROM employee_subject WHERE emp_id='$ed_id'");
        
        
        // echo "<pre>";
        // print_r($emp_sub_edit);
        // echo "</pre>";
    }
?>  

<?php  
    $classes=$db->get_results("SELECT * FROM course WHERE inst_id='".$_SESSION['inst_id']."'");
    $board=$db->get_results("SELECT * FROM board WHERE inst_id='".$_SESSION['inst_id']."'");
    $emp=$db->get_results("SELECT * FROM user WHERE inst_id='".$_SESSION['inst_id']."' AND user_type_id='3'");

    $get_section = $db->get_results("SELECT * FROM section WHERE inst_id='".$_SESSION['inst_id']."'");
    $get_acdemic_yr = $db->get_results("SELECT * FROM academic_year WHERE inst_id='".$_SESSION['inst_id']."'");

    $subject=$db->get_results("SELECT * FROM subject WHERE inst_id='".$_SESSION['inst_id']."'");
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
                      <h3 class="box-title"><b>Add New Exam Time Table</b><br> &nbsp;&nbsp;&nbsp;<div id="status"></div></h3>
                      
                    </div>
                 <div class="box-body">

    <div class="row">
     
     
          <div class="col-lg-12 col-md-12 col-sm-12">

                  <div class="table-responsive"><br><br>
                   <span id="error"></span>
                   <table class="table table-bordered" id="item_table">
                    <tr>
                     <th class="text-center" style="width:12%; font-size: 13px;"> Standard<span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:12%; font-size: 13px;"> Board<span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:12%; font-size: 13px;"> Section<span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:12%; font-size: 13px;"> Academic Year<span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:12%; font-size: 13px;">Subject Name <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:12%; font-size: 13px;"> Date<span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:12%; font-size: 13px;"> Start Time<span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:12%; font-size: 13px;"> End Time<span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:4%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus"></span></button><br>
                      <span style="font-size: 10px; color: red;">Click..</span></th>
                    </tr>
                   </table>
                  </div> 
                </div>


              <div class="form-group col-md-6">
                   
                  <input type="submit" name="add_exam_time_table" id="save_emp" value="Create Exam Time Table" class="btn btn-primary btn-round">&nbsp;

                  <a href="?folder=configuration&file=all_exam_time_table_view" class="btn btn-primary btn-round">Go Back</a>
             

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

      html += '<td><select class="form-control" id="class_id'+rowCount+'" name="standard_name[]" onchange="load_emp('+rowCount+'); "required>                                                                          <option value="">Standard</option>                                                          <?php
              if($classes){
                foreach ($classes as $class_key){
          ?><option value="<?php echo $class_key->class_id; ?>"<?php if($class_key->class_id==$emp_sub_edit->class){ echo "selected";} ?>><?php echo $class_key->class_name; ?></option><?php }} ?></select></td>';


      html += '<td><select class="form-control" id="board_id'+rowCount+'" name="board_name[]" onchange="load_emp('+rowCount+');" required>                                                                                                                                           <option value="">Board</option>                                                 <?php
          if ($board){
            foreach ($board as $board_key){         
        ?>
        <option value="<?php echo $board_key->board_id; ?>"<?php if($board_key->board_id==$emp_sub_edit->board){ echo "selected";} ?>><?php echo $board_key->board_name; ?></option><?php }} ?></select></td>'; 





        html += '<td><select class="form-control" id="section" name="section[]" required>                                                                         <option value="">Section</option>                                                 <?php
          if ($get_section){
            foreach ($get_section as $sec){         
          ?>
        <option value="<?php echo $sec->sec_id; ?>"><?php echo $sec->sec_name; ?></option><?php }} ?></select></td>';

        html += '<td><select class="form-control" id="acd_yr" name="acd_yr[]" required>                                                                         <option value="">Academic Year</option>                                                 <?php
          if ($get_acdemic_yr){
            foreach ($get_acdemic_yr as $a_yr){         
        ?>
        <option value="<?php echo $a_yr->ay_id; ?>"><?php echo $a_yr->start_year; ?> - <?php echo $a_yr->end_year; ?></option><?php }} ?></select></td>';


      html += '<td><div id="subject'+rowCount+'"></div></td>';


      
      html += '<td><input type="text" class="form-control" id="datepicker1'+rowCount+'" placeholder="Date" name="exam_date[]"></td>';
      html += '<td><input type="text" name="start_exam_time[]" class="form-control" placeholder="Start Time"></td>';
      html += '<td><input type="text" name="end_exam_time[]" class="form-control" placeholder="End Time"></td>';


      html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus"></span></button><br><span style="font-size: 10px; color: red;">Click..</span></td></tr>';


      $('#item_table').append(html);
      $( "#datepicker1"+rowCount).datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: "1990:2050"
    });
     });

     
     $(document).on('click', '.remove', function(){
      $(this).closest('tr').remove();
        rowCount--;
     });
     
    });
    </script>

<script>
function load_emp(identify)
{
  var class_name = $('#class_id'+identify+' option:selected').val();
  var board_name = $('#board_id'+identify+' option:selected').val();

// alert(board_name);

$.ajax({ 
  type:'POST',
  url:'./load_subject.php',
  data:{class_name:class_name,board_name:board_name,identi:identify },
  success:function(reply)
  {
    $('#subject'+identify+'').html(reply);
  }
})
}
</script> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    function check_tech_sub(check_sub)
    {
      // alert(check_sub);
      var c_name = $('#class_id'+check_sub+' option:selected').val();
      var b_name = $('#board_id'+check_sub+' option:selected').val();
      var s_name = $('#subject'+check_sub+' option:selected').val();
      var e_name = $('#emp_name'+check_sub+' option:selected').val();

      // alert(b_name);

      $.ajax({ 
        type:'POST',
        url:'./check_teach_sub.php',
        data:{c_name:c_name,b_name:b_name,s_name:s_name,e_name:e_name},
        success:function(reply)
        {
          // alert(reply);
          $('#status').html(reply);
        }
      });
    }
</script> 


<script>
   $(document).ready(function(ckeck_data){
        $('#save_emp').on('click',function(event){
          event.preventDefault();

          var n = $( "[name='class[]']" ).length+ckeck_data+;
          
          // if(n==0)
          // {
          //   $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Add At Least One Row<span>');
          // }
          // else
          // {
          //   if($( "[name='class[]']" ).val()=='')
          //   {
          //     $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Please Select Class Name<span>');
          //   }
          //   else if($( "[name='board_name[]']" ).val()=='')
          //   {
          //      $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Please Select Board Name<span>');
          //   }
          //    else if($( "[name='subject[]']" ).val()=='')
          //   {
          //      $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Please Select Subject Name<span>');
          //   }
          //    else if($( "[name='emp_name[]']" ).val()=='')
          //   {
          //      $('#row_msg').html('<span style="color:red; font-weight:700; margin-left:20px; font-size:18px;">Please Select Employee Name<span>');
          //   }
          //   else
          //   {
          //     $('#insert_form').submit();
          //   }
          // }
        });
    });
</script>