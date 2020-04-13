<?php  

    if($_SESSION['user_type']=='1')
    {
      $r=$db->get_results("SELECT * FROM dw_employee_master as a LEFT JOIN dw_user_login as b ON a.DEM_EMP_ID=b.DEM_EMP_ID ORDER BY DEM_ID DESC");

    }

    if(date('M')>date('M',strtotime('March')))
    {
      $initial_year = date('Y');
      $initial_fin_year =  $initial_year."-04";

      $final_year = date('Y',strtotime('+1 Years'));
      $final_fin_year =  $final_year."-03";

    }else{
      $initial_year = date('Y',strtotime('-1 Years'));
      $initial_fin_year =  $initial_year."-04";

      $final_year = date('Y');
      $final_fin_year =  $final_year."-03";

    }
    // prnt($final_fin_year);
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
          <h3>Leave Reports (<?php echo date('M-Y',strtotime($initial_fin_year))." ~ ".date('M-Y',strtotime($final_fin_year)); ?>)</h3>
          
          <div class="box-tools">
            <a href="?folder=leave_report&file=leave_report_list&overall_leave_rep_xl=1" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>

            <a href="?folder=leave_report&file=leave_report_list&overall_leave_rep_pdf=1" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive  table-striped" style="border: 1px solid black !important;">
            <thead>
              <tr>
                <th style="border: 1px solid black !important;" class="text-center">Sr.No</th>
                <th style="border: 1px solid black !important;" class="text-center">EMP. ID.</th>
                <th style="border: 1px solid black !important;" class="text-center">EMP. NAME</th>
                <th style="border: 1px solid black !important;" class="text-center">AT OFFICE</th>
                <th style="border: 1px solid black !important;" class="text-center">AT CUSTOMER SITE</th>
                <th style="border: 1px solid black !important;" class="text-center">PRIVILAGE LEAVES</th>
                <th style="border: 1px solid black !important;" class="text-center">CASUAL LEAVES</th>
                <th style="border: 1px solid black !important;" class="text-center">SICK LEAVES</th>
                <th style="border: 1px solid black !important;" class="text-center">COMPENSATORY OFFS</th>
                <th style="border: 1px solid black !important;" class="text-center">PUBLIC HOLIDAYS</th>
                <th style="border: 1px solid black !important;" style="width: 15%;" class="text-center">ACTION</th>
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
                
                <td class="text-center" style="border: 1px solid black !important;"><?php echo $emp; ?></td>
                
                <td class="text-center" style="border: 1px solid black !important;"><?php echo $row->DEM_EMP_ID; ?></td>

                <td class="text-center" style="border: 1px solid black !important;">
                  <?php echo $row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME; ?>                      
                </td>

                <?php 
                $at_office = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='OFFICE'");
                // $db->debug();
                 ?>
                <td class="text-center" style="border: 1px solid black !important;">
                 <?php echo $at_office; ?>                
                </td>

                <?php 
                $at_customer_site = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='CUSTOMER SITE'");
                // $db->debug();
                 ?>

                <td class="text-center" style="border: 1px solid black !important;">
                 <?php echo $at_customer_site; ?>                
                </td>

                <?php 
                $privilage_leaves = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='PRIVILAGE LEAVE'");
                // $db->debug();
                 ?>

                <td class="text-center" style="border: 1px solid black !important;">
                 <?php echo $privilage_leaves; ?>                
                </td>                    
               
                <?php 
                $casual_leaves = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='CASUAL LEAVE'");
                // $db->debug();
                 ?>

                <td class="text-center" style="border: 1px solid black !important;">
                 <?php echo $casual_leaves; ?>                
                </td>             
               
                <?php 
                $sick_leaves = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='SICK LEAVE'");
                // $db->debug();
                 ?>

                <td class="text-center" style="border: 1px solid black !important;">
                 <?php echo $sick_leaves; ?>                
                </td>                    
               
                <?php 
                $compensatory_offs = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='COMPENSATORY OFF'");
                // $db->debug();
                 ?>

                <td class="text-center" style="border: 1px solid black !important;">
                 <?php echo $compensatory_offs; ?>                
                </td>                    
               
                <?php 
                $public_holidays = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='PUBLIC HOLIDAY'");
                // $db->debug();
                 ?>

                <td class="text-center" style="border: 1px solid black !important;">
                 <?php echo $public_holidays; ?>                
                </td>                    
               
                <td class="text-center" style="border: 1px solid black !important;"  >

                  <a title="View Leave Details" href="?folder=leave_report&file=leave_report_details&DEM_EMP_ID=<?php echo $row->DEM_EMP_ID; ?>" class="btn btn-primary" style="margin: 2px;"><i class="fa fa-eye"></i> </a>
                  
                </td>
              </tr>
            <?php } 
            }
            else { ?>
              <tr>                      
                <td style="border: 1px solid black !important;text-align: center;" colspan='8' class="pull-center" >
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
      // console.log(data);  
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
