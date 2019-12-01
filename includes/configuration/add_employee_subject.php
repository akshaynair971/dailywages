<?php
  
    if(isset($_GET['edit_emp_sub']) && $_GET['edit_emp_sub']!='')    
    {
        $ed_id = $_GET['edit_emp_sub'];
        $emp_sub_edit = $db->get_row("SELECT * FROM employee_subject WHERE emp_id='$ed_id'");
    }
?>  

<?php  
    $classes=$db->get_results("SELECT * FROM course WHERE inst_id='".$_SESSION['ad_id']."'");
    $board=$db->get_results("SELECT * FROM board WHERE inst_id='".$_SESSION['ad_id']."'");
    $emp=$db->get_results("SELECT * FROM user WHERE inst_id='".$_SESSION['ad_id']."' AND user_type_id='3'");
    $subject=$db->get_results("SELECT * FROM subject WHERE inst_id='".$_SESSION['ad_id']."'");
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
                      <h3 class="box-title"><b>Add New Employee Subject</b><br> &nbsp;&nbsp;&nbsp;<div id="status"></div></h3>
                      
                    </div>
                 <div class="box-body">

    <div class="row">
     
     
          <div class="col-lg-12 col-md-12 col-sm-12">

                  <div class="table-responsive"><br><br>
                   <span id="error"></span>
                   <table class="table table-bordered" id="item_table">
                    <tr>
                     <th class="text-center" style="width:24%; font-size: 13px;">Class Name <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:24%; font-size: 13px;">Board Name <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:24%; font-size: 13px;">Subject Name <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:24%; font-size: 13px;">Employee Name <span style="color: red;font-size: 15px;">*</span></th>

                     <th class="text-center" style="width:4%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus"></span></button><br>
                      <span style="font-size: 10px; color: red;">Click..</span></th>
                    </tr>
                   </table>
                  </div>

                  <table class="table table-bordered" id="item_table">
                        <tbody>
                          <?php 
                           $json = json_decode($emp_sub_edit->teach_subject_all_details);
                           if($json){
                            $rowCount=0;
                             for ($i=0; $i < count($json->class); $i++){
                              $rowCount++; 
                           
                          ?>
                         
                          <tr>
                              <th style="width:24%; font-size: 13px;">
                                <select class="form-control" id="class_id<?php echo $rowCount; ?>" name="class[]" onchange="load_emp(<?php echo $rowCount; ?>);" required>
                                  <option value="">Select Class</option>
                                  <?php
                                      if($classes) {
                                        foreach ($classes as $class_key) {
                                  ?>
                                  <option value="<?php echo $class_key->class_id; ?>"<?php if($class_key->class_id==$json->class[$i]){ echo "selected";} ?>><?php echo $class_key->class_name; ?></option>
                                  <?php }} ?>
                                </select>

                              </th>
                            
                              <th style="width:24%; font-size: 13px;">
                                <select class="form-control" id='board_id<?php echo $rowCount; ?>' name='board_name[]' onchange="load_emp(<?php echo $rowCount; ?>);" required>
                                    <option value="">Select Board</option>
                                    <?php
                                        if ($board) {
                                          foreach ($board as $board_key) {
                                             
                                    ?>
                                    <option value="<?php echo $board_key->board_id; ?>"<?php if($board_key->board_id==$json->board_name[$i]){ echo "selected";} ?>><?php echo $board_key->board_name; ?></option>
                                    <?php }} ?>
                                </select>
                              </th>

                              <th style="width:24%; font-size: 13px;">
                                <select class="form-control" id='subject' name='subject[]' required>
                                    <option value="">Select Subject</option>
                                    <?php
                                        if ($subject) {
                                          foreach ($subject as $sub_key) {
                                             
                                    ?>
                                    <option value="<?php echo $sub_key->sub_id; ?>"<?php if($sub_key->sub_id==$json->subject[$i]){ echo "selected";} ?>><?php echo $sub_key->subject; ?></option>
                                    <?php }} ?>
                                </select>
                              </th>

                              <th style="width:24%; font-size: 13px;">
                                <select class="form-control" id='emp_name' name='emp_name[]' required>
                                  <option value="">Select Employee Name</option>
                                    <?php
                                        if ($emp) {
                                          foreach ($emp as $emp_key) {
                                             
                                    ?>
                                  <option value="<?php echo $emp_key->user_id; ?>"<?php if($emp_key->user_id==$json->emp_name[$i]){ echo "selected";} ?>><?php echo $emp_key->user_name; ?></option>
                                    <?php }} ?>
                                </select>
                              </th>

                                                        
                              <th style="width:4%;">
                                  <button type="button" name="remove" class="btn btn-danger btn-sm remove" onclick="setValue()"><span class="glyphicon glyphicon-minus"></span></button><br><span style="font-size: 10px; color: red;">Click Here..</span>
                              </th>
                          </tr>
                     <?php }  } ?>
                    </tbody>
                </table>
            </div>


              <div class="form-group col-md-6">
                   
                  <input type="submit" name="save_emp_sub" id="save_emp" value="Create Employee Subject" class="btn btn-primary btn-round">&nbsp;
                  <a href="?folder=configuration&file=employee_subjects_view" class="btn btn-primary btn-round">Go Back</a>
             

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

      html += '<td><select class="form-control" id="class_id'+rowCount+'" name="class[]" onchange="load_emp('+rowCount+'); "required>                                                                                <option value="">Select Class</option>                                                <?php
              if($classes){
                foreach ($classes as $class_key){
          ?><option value="<?php echo $class_key->class_id; ?>"<?php if($class_key->class_id==$emp_sub_edit->class){ echo "selected";} ?>><?php echo $class_key->class_name; ?></option><?php }} ?></select></td>';


      html += '<td><select class="form-control" id="board_id'+rowCount+'" name="board_name[]" onchange="load_emp('+rowCount+');" required>                                                                                                                                           <option value="">Select Board</option>                                                 <?php
          if ($board){
            foreach ($board as $board_key){         
        ?>
        <option value="<?php echo $board_key->board_id; ?>"<?php if($board_key->board_id==$emp_sub_edit->board){ echo "selected";} ?>><?php echo $board_key->board_name; ?></option><?php }} ?></select></td>';


    html += '<td><div id="subject'+rowCount+'"></div></td>';


      
      html += '<td><select class="form-control" id="emp_name'+rowCount+'" name="emp_name[]" onchange="check_tech_sub('+rowCount+');" required>                                        <option value="">Select Employee Name</option>                                         <?php
            if ($emp){
              foreach ($emp as $emp_key){         
          ?>
          <option value="<?php echo $emp_key->user_id; ?>"<?php if($emp_key->user_id==$emp_sub_edit->emp_name){ echo "selected";} ?>><?php echo $emp_key->user_name; ?></option><?php }} ?>
          </select></td>';


      html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus"></span></button><br><span style="font-size: 10px; color: red;">Click..</span></td></tr>';


      $('#item_table').append(html);
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
  data:{class_name:class_name,board_name:board_name,identi:identify},
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

    function check_sub_assign(check_sub)
    {
      // alert(check_sub);
      var cl_name = $('#class_id'+check_sub+' option:selected').val();
      var bat_name = $('#board_id'+check_sub+' option:selected').val();
      var sub_name = $('#subject'+check_sub+' option:selected').val();
      

      // alert(b_name);

      $.ajax({ 
        type:'POST',
        url:'./check_teach_sub.php',
        data:{cl_name:cl_name,bat_name:bat_name,sub_name:sub_name,chassteacher:1},
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