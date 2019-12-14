<?php  

    if($_SESSION['user_type']=='1')
    {
      $r=$db->get_results("SELECT * FROM dw_employee_master as a LEFT JOIN dw_user_login as b ON a.DEM_EMP_ID=b.DEM_EMP_ID ORDER BY DEM_ID DESC");
    }
?>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
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
        <div class="box-header">
          <?php  if($_SESSION['user_type']=='1') { ?>

            <a href='index.php?folder=employees&file=add_employee' class='btn btn-primary btn-round' style="float: right;"><i class="fa fa-plus"></i> <b>Add New Employee</b></a>

          <?php } ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center">Sr.No</th>
                <th class="text-center">Profile</th> 
                <th class="text-center">EMP. ID.</th>
                <th class="text-center">Name</th>
                <th class="text-center">Mobile No.</th>
                <th class="text-center">E-Mail</th>
                <!-- <th class="text-center">Login Detail</th> -->
                <th class="text-center">Status</th> 
                <th style="width: 15%;" class="text-center">Action</th>
              </tr>
            </thead> 
            <tbody>
            <?php  
            if(isset($r)){
            $emp = 0;
            foreach ($r as $row){
            $emp++;                        
            ?>
              <tr>
                <?php $get_role = $db->get_row("SELECT * FROM user_type WHERE usr_id='$row->user_type_id'"); ?>
                <td><?php echo $emp; ?></td>
                <td class="text-center"><img class="img-rounded" src="./images/user_profile/<?php echo $row->DEM_EMP_ID.'.jpg'; ?>" onerror="this.src='images/user.jpg'" style="height: 80px;width: 70px;"></td>
                
                <td><?php echo $row->DEM_EMP_ID; ?></td>
                <td>
                  <?php echo $row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME; ?>                      
                </td>
                <td>
                  <?php echo $row->DEM_MOBILE_NUMBER; ?>               
                </td>                    
                <td><?php echo $row->DEM_PERSONAL_EMAIL_ID; ?></td>                    
                <td>
                  <?php if ($row->DUL_ACTIVE_FLAG=="ACTIVE") { ?>
                  <span style="color:green;">ACTIVE</span>
                  <?php } else
                  {  ?>
                  <span style="color:red;">INACTIVE</span>
                  <?php } ?>                      
                </td>
                <td  align="center">
                  <button title="View More Details"  data-target="#view-modal"  data-toggle="modal"  id="getUserdemo" data-id="<?php echo $row->DEM_EMP_ID; ?>" class="btn btn-info getUserdemo"><i class="fa fa-search"></i> </button>

                  <a title="Edit Employee" href="?folder=employees&file=add_employee&edit_user=<?php echo $row->DEM_EMP_ID; ?>" class="btn btn-primary" style="margin: 2px;"><i class="fa fa-pencil"></i> </a>

                  <!-- <a title="Delete Employee" onclick="return confirm('Are You Sure To Delete This Record..!?')" href="?folder=employees&file=employee_list&delete_user=<?php echo $row->DEM_EMP_ID; ?>" class="btn btn-danger" style="margin: 2px;"><i class="fa fa-trash-o"></i></a> -->

                  <?php if ($row->DUL_ACTIVE_FLAG=="ACTIVE") { ?>
                  <!-- <a title="Deactivate Employee" href="?folder=employees&file=employee_list&deactiveemp_id=<?php echo $row->DEM_EMP_ID; ?>" class="btn btn-warning" style="margin: 2px;"><i class="fa fa-eye-slash"></i></a> -->
                  <?php } else
                  {  ?>
                  <!-- <a title="Activate Employee" href="?folder=employees&file=employee_list&activeemp_id=<?php echo $row->DEM_EMP_ID; ?>" class="btn btn-success" style="margin: 2px;"><i class="fa fa-eye"></i></a> -->
                  <?php 
                  }
                  ?>                        
                </td>
              </tr>
            <?php } 
            }
            else { ?>
              <tr>                      
                <td colspan='8' class="pull-center" style="text-align: center;">
                  <b>No Record Available</b>
                </td>
              </tr>
            <?php }  ?> 
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
    </div>
      <!-- /.box -->
  </div>
</section>
<!-- /.content -->

<!-- Modal code for Employee Details-->
<div class="row">
  <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"> 
      <div class="modal-content">            
        <div class="modal-header"> 
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button> 
          <h4 class="modal-title">
            Employee Details
          </h4> 
        </div> 
        <div class="modal-body">                  
          <div id="modal-loader" style="display: none; text-align: center;">
            <img src="ajax-loader.gif">
          </div>                         
          <div id="dynamic-content"></div>     
        </div> 
        <div class="modal-footer"> 
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
        </div>                   
      </div> 
    </div>
  </div><!-- /.modal -->   
</div>
  
<!-- End  Modal code for Employee Details -->


<script>
$(document).ready(function(){
  
  $(document).on('click', '#getUserdemo', function(e){    
    e.preventDefault();     
    var DEM_EMP_ID = $(this).data('id');   // it will get id of clicked row
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {DEM_EMP_ID:DEM_EMP_ID,view_emp_details:1},
      dataType: 'html'
    })
    .done(function(data){
      console.log(data);  
      $('#dynamic-content').html('');    
      $('#dynamic-content').html(data); // load response 
      $('#modal-loader').hide();      // hide ajax loader 
    })
    .fail(function(){
      $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
      $('#modal-loader').hide();
    });
    
  });
}); 
</script>