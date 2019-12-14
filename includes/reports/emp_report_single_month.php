
<?php
if(isset($_POST['report_sub_sin_mon']) || isset($_POST['report_sub_mul_mon']))
{
  extract($_POST);
  $datearray = explode("-",$select_pay_month);
  $fulldate = date('F-Y',strtotime($select_pay_month));
  if($_SESSION['user_type']=="2"){
    $r=$db->get_results("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."'");  
  }else{
    $r=$db->get_results("SELECT * FROM dw_employee_master");
  }


}
?>

<div class="col-md-12">
  <div class="box box-primary">
        
    <div class="box-header">
      <h3 class="box-title"><b>Employee Attendance Report of Month <?php echo $fulldate; ?></b></h3>
      <div class="box-tools">
        <a href="?folder=reports&file=emp_report_filter_by_date" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
      </div>
    </div>
    <div class="box-body table-responsive"> 
      <table id="example" class="table table-bordered table-striped example table-responsive" role="grid" aria-describedby="example1_info">
        <thead class="table-border">
        <tr>
          <th class="text-center">Sr. No.</th>
          <th class="text-center">EMPLOYEE NAME</th>
          <th class="text-center">AGE</th>
          <th class="text-center">TOTAL DAYS WORKED</th>
          <th class="text-center">RATE</th>
          <th class="text-center">TOTAL GW HRS.</th>
          <th class="text-center">BASIC</th>
          <th class="text-center">HRA</th>
          <th class="text-center">OTHER ALLOWANCES</th>
          <th class="text-center">GROSS WAGES PAYABLE</th>
          <th class="text-center">PROFF. TAX</th>
          <th class="text-center">P.F. (12%)</th>
          <th class="text-center">PF (12%)</th>
          <th class="text-center">ESIC (.75%)</th>
          <th class="text-center">ESIC (3.25%)</th>
          <th class="text-center">TOTAL DEDUCTION</th>
          <th class="text-center">NET WAGES PAID</th>
          <th class="text-center">PAYMENT REFERENCE</th>
          <th class="text-center">SIGN</th>
        </tr>
        
        </thead>
        <tbody>
        <?php
          $i=0;
          if($r)
          { 
            $basictotal = $hratotal = $otherallowancestotal = $grosswagespayabletotal = $proftaxtotal = $ep_pftotal = $er_pftotal = $ep_esictotal = $er_esictotal = $totaldeductionsum = $netwagespaidsum = 0;
            foreach($r as $rw){

              $payroll_det=$db->get_row("SELECT * FROM dw_payroll_master WHERE DEM_EMP_ID='$rw->DEM_EMP_ID'");
              $pay_track=$db->get_row("SELECT * FROM dw_payment_tracker WHERE DEM_EMP_ID='$rw->DEM_EMP_ID' AND DPT_PAYMENT_YEAR='".$datearray[0]."' AND DPT_PAYMENT_MONTH='".$datearray[1]."'");
              // prnt($pay_track);
            
            $i++;
         ?>
            <tr>
              <td class="text-center"><?php echo $i;  ?></td>
              <td class="text-center"><?php echo strtoupper($rw->DEM_EMP_NAME_PREFIX." ".$rw->DEM_EMP_FIRST_NAME." ".$rw->DEM_EMP_MIDDLE_NAME." ".$rw->DEM_EMP_LAST_NAME); ?></td>
              <td class="text-center"><?php echo $rw->DEM_EMP_AGE; ?></td>
              <td class="text-center"><?php if($pay_track->DPT_TOTAL_DAYS_WORKED){ echo $pay_track->DPT_TOTAL_DAYS_WORKED; }else{ echo "-"; } ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_RATE; ?></td>
              <td class="text-center"><?php if($pay_track->DPT_TOTAL_GW_HRS){ echo $pay_track->DPT_TOTAL_GW_HRS; }else{ echo "-"; } ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_BASIC_SALARY; $basictotal+= $payroll_det->DPM_BASIC_SALARY; ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_HRA; $hratotal += $payroll_det->DPM_HRA; ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_OTHER_ALLOWANCE; $otherallowancestotal += $payroll_det->DPM_OTHER_ALLOWANCE; ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_GROSS_WAGES_PAYABLE; $grosswagespayabletotal += $payroll_det->DPM_GROSS_WAGES_PAYABLE; ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_PROFESSIONAL_TAX; $proftaxtotal += $payroll_det->DPM_PROFESSIONAL_TAX; ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_PF_EMPLOYEE; $ep_pftotal += $payroll_det->DPM_PF_EMPLOYEE; ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_PF_EMPLOYER;  $er_pftotal += $payroll_det->DPM_PF_EMPLOYER; ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_ESIC_EMPLOYEE; $ep_esictotal += $payroll_det->DPM_ESIC_EMPLOYEE; ?></td>
              <td class="text-center"><?php echo $payroll_det->DPM_ESIC_EMPLOYER; $er_esictotal += $payroll_det->DPM_ESIC_EMPLOYER; ?></td>
              <td class="text-center"><?php if($pay_track->TOTAL_DEDUCTION){ $totaldeductionsum += $pay_track->TOTAL_DEDUCTION; echo $pay_track->TOTAL_DEDUCTION; }else{ echo "-"; } ?></td>
              <td class="text-center"><?php if($pay_track->DPT_NET_WAGES_PAID){ $netwagespaidsum += $pay_track->DPT_NET_WAGES_PAID; echo $pay_track->DPT_NET_WAGES_PAID; }else{ echo "-"; }  ?></td>
              <td class="text-center"><?php if($pay_track->DPT_INVOICE_NO){ echo $pay_track->DPT_INVOICE_NO; }else{ echo "-"; } ?></td>
              <td class="text-center"><?php echo "-"; ?></td>
                   
            </tr>
            <?php 
            } 
          } ?>
        </tbody>
        <tfoot>
          <tr>
            <td class="text-center"></td>
            <td class="text-center">Total</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><?php echo $basictotal;  ?></td>
            <td class="text-center"><?php echo $hratotal;  ?></td>
            <td class="text-center"><?php echo $otherallowancestotal;  ?></td>
            <td class="text-center"><?php echo $grosswagespayabletotal; ?></td>
            <td class="text-center"><?php echo $proftaxtotal; ?></td>
            <td class="text-center"><?php echo $ep_pftotal; ?></td>
            <td class="text-center"><?php echo $er_pftotal; ?></td>
            <td class="text-center"><?php echo $ep_esictotal; ?></td>
            <td class="text-center"><?php echo $er_esictotal;  ?></td>
            <td class="text-center"><?php echo $totaldeductionsum; ?></td>
            <td class="text-center"><?php echo $netwagespaidsum; ?></td>
            <td class="text-center"><?php  ?></td>
            <td class="text-center"><?php  ?></td>            
          </tr>          
        </tfoot>
      </table>
       
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            // 'copyHtml5',
            'colvis',
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true, title: '<?php if (isset($title)){echo $title->ins_name." (".$fulldate." )";}   ?>' ,messageTop: 'FORM II M.W. RULES 1963 Rule 27' },
            // { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true, title: '<?php if (isset($title)){echo $title->ins_name." (".$fulldate." )";}   ?>' , messageTop: 'FORM II M.W. RULES 1963 Rule 27', orientation: 'landscape',pageSize: 'A3' }
        ]
    } );

} );

</script>