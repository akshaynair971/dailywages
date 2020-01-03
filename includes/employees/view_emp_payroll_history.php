<?php  

    if($_SESSION['user_type']=='1')
    {
      $r=$db->get_results("SELECT * FROM dw_payroll_history ORDER BY DPM_ID DESC");
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
          <div class="box-tools">
            <a href="index.php?folder=employees&file=employee_list" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          </div> 
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped display" style="width:100%;">
            <thead>
              <tr>
                <th>SR.NO</th>
                <th>PAYROLL RATE</th> 
                <th>VALID FROM</th>
                <th>VALID TO</th>
                <th>BASIC SALARY</th>
                <th>HRA</th>
                <th>OTHER ALLOWANCE</th>
                <th>SPECIAL ALLOWANCE</th>
                <th>GROSS WAGES PAYABLE</th>
                <th>PROFESSIONAL TAX</th>
                <th>PF EMPLOYEE</th>
                <th>PF EMPLOYER</th>
                <th>ESIC EMPLOYEE</th>
                <th>ESIC EMPLOYER</th>
                <th>NET WAGES PAYABLE</th>
                <th>ENTRY CREATED</th>
                <th>LAST UPDATAED DATE</th>
                
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
                <td class="text-center"><?php echo $emp; ?></td>
                <td class="text-center"><?php echo $row->DPM_RATE; ?></td> 
                <td class="text-center"><?php echo $row->DPM_VALID_FROM; ?></td>
                <td class="text-center"><?php echo $row->DPM_VALID_TO; ?></td>
                <td class="text-center"><?php echo $row->DPM_BASIC_SALARY; ?></td>
                <td class="text-center"><?php echo $row->DPM_HRA; ?></td>
                <td class="text-center"><?php echo $row->DPM_OtdER_ALLOWANCE; ?></td>
                <td class="text-center"><?php echo $row->DPM_SPECIAL_ALLOWANCE; ?></td>
                <td class="text-center"><?php echo $row->DPM_GROSS_WAGES_PAYABLE; ?></td>
                <td class="text-center"><?php echo $row->DPM_PROFESSIONAL_TAX; ?></td>
                <td class="text-center"><?php echo $row->DPM_PF_EMPLOYEE; ?></td>
                <td class="text-center"><?php echo $row->DPM_PF_EMPLOYER; ?></td>
                <td class="text-center"><?php echo $row->DPM_ESIC_EMPLOYEE; ?></td>
                <td class="text-center"><?php echo $row->DPM_ESIC_EMPLOYER; ?></td>
                <td class="text-center"><?php echo $row->DPM_CALCULATED_AMOUNT; ?></td>
                <td class="text-center"><?php echo $row->DPM_CREATION_DATE; ?></td>
                <td class="text-center"><?php echo $row->DPM_LAST_UPDATAED_DATE; ?></td>
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