<?php

    if(isset($_GET['edit_sub'])) 
    {
        $ed_id = $_GET['edit_sub'];

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

                   <div class="col-lg-12 col-md-12 col-sm-12">

                           <div class="table-responsive">
                            <table class="table table-bordered" id="item_table">
                             <tr>
                              <th class="text-center" style="width:32%; font-size: 13px;">Class Name <span style="color: red;font-size: 15px;">*</span></th>

                              <th class="text-center" style="width:32%; font-size: 13px;">Board Name <span style="color: red;font-size: 15px;">*</span></th>

                              <th class="text-center" style="width:32%; font-size: 13px;">Subject <span style="color: red;font-size: 15px;">*</span></th>

                              <th class="text-center" style="width:4%"><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus"></span></button><br>
                               <span style="font-size: 10px; color: red;">Click..</span></th>
                             </tr>
                            </table>
                           </div> 
                     </div>
                    <div class="form-group">
                        <input type="submit" value="Submit" id="subject_btn" class="btn btn-primary btn-round" name="save_subject_list">&nbsp;
                        <a href="?folder=configuration&file=subjects_view" class="btn btn-primary btn-round">Go Back</a>
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
    $(document).ready(function(){
      
     $(document).on('click','.add', function(){
      rowCount++;
       // alert(rowCount);
      var html = '';
      html += '<tr>';

      html += '<td><select class="form-control" id="c_name'+rowCount+'" name="sub_class[]" onchange="check_sub_data('+rowCount+');" required>                                                                                 <option value="">Select Class</option>                                                    <?php
            if ($classes){
              foreach ($classes as $class_key) {
            ?>
          <option value="<?php echo $class_key->class_id; ?>"><?php echo $class_key->class_name; ?></option><?php } } ?>
        </select></td>';


      html += '<td> <select class="form-control" id="b_name'+rowCount+'" name="board[]" onchange="check_sub_data('+rowCount+');" required>                                        <option value="">Select Board</option>                                                                             <?php
            if ($board) {
              foreach ($board as $board_key) {   
        ?>
        <option value="<?php echo $board_key->board_id; ?>"><?php echo $board_key->board_name; ?></option><?php } } ?>
      </select></td>';


      html += '<td> <input type="text" class="form-control" id="s_name'+rowCount+'" name="subject[]" placeholder="Enter Subject Name" oninput="check_sub_data('+rowCount+');" required></td>';


      html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus"></span></button><br><span style="font-size: 10px; color: red;">Click Here..</span></td></tr>';


      $('#item_table').append(html);
     });

     $(document).on('click', '.remove', function(){
      $(this).closest('tr').remove();
        rowCount--;
     });
     
    });
</script>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    function check_sub_data(check_cnt)
    {
      // alert(check_cnt);
      var cls_name = $('#c_name'+check_cnt+' option:selected').val();
      var brd_name = $('#b_name'+check_cnt+' option:selected').val();
      var sub_name = $('#s_name'+check_cnt+'').val();

      // alert(sub_name);

      $.ajax({ 
        type:'POST',
        url:'./check_data.php',
        data:{cls_name:cls_name,brd_name:brd_name,sub_name:sub_name},
        success:function(reply)
        {
          $('#status').html(reply);
        }
      });
    }
</script>