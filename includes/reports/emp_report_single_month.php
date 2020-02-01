
<?php
if(isset($_POST['report_sub_sin_mon']) || isset($_POST['report_sub_sin_cur_mon']))
{
  extract($_POST);
  // prnt($_POST);
  if(isset($_POST['report_sub_sin_cur_mon'])){
    $select_pay_month= $curr_month_date;
  }
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
      <h3 class="box-title"><b>Employee Payment Report of Month <?php echo $fulldate; ?></b></h3>
      <div class="box-tools">
        <a href="?folder=reports&file=emp_report_single_month&exppdfselect_pay_month=<?php echo $select_pay_month; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>
        <a href="?folder=reports&file=emp_report_single_month&expxlselect_pay_month=<?php echo $select_pay_month; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a>
        <a href="?folder=reports&file=emp_report_filter_by_date" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
      </div>
    </div>
    <div class="box-body table-responsive"> 
      <table id="example" class="table table-bordered table-striped example table-responsive" role="grid" aria-describedby="example1_info" style="border: 1px solid black !important;">
        <thead class="table-border">
        <tr>
          <th style="border: 1px solid black !important; text-align: left;">Sr. No.</th>
          <th style="border: 1px solid black !important; width: 30% !important; text-align: left;">EMPLOYEE NAME</th>
          <th style="border: 1px solid black !important; text-align: left;">AGE</th>
          <th style="border: 1px solid black !important; text-align: left;">TOTAL DAYS WORKED</th>
          <th style="border: 1px solid black !important; text-align: left;">RATE</th>
          <th style="border: 1px solid black !important; text-align: left;">TOTAL GW HRS.</th>
          <th style="border: 1px solid black !important; text-align: left;">BASIC</th>
          <th style="border: 1px solid black !important; text-align: left;">HRA</th>
          <th style="border: 1px solid black !important; text-align: left;">OTHER ALLOWANCES</th>
          <th style="border: 1px solid black !important; text-align: left;">GROSS WAGES PAYABLE</th>
          <th style="border: 1px solid black !important; text-align: left;">PROFF. TAX</th>
          <th style="border: 1px solid black !important; text-align: left;">P.F. (12%)</th>
          <th style="border: 1px solid black !important; text-align: left;">PF (12%)</th>
          <th style="border: 1px solid black !important; text-align: left;">ESIC (.75%)</th>
          <th style="border: 1px solid black !important; text-align: left;">ESIC (3.25%)</th>
          <th style="border: 1px solid black !important; text-align: left;">TOTAL DEDUCTION</th>
          <th style="border: 1px solid black !important; text-align: left;">NET WAGES PAID</th>
          <th style="border: 1px solid black !important; text-align: left;">PAYMENT REFERENCE</th>
          <th style="border: 1px solid black !important; text-align: left;">SIGN</th>
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
              <td style="border: 1px solid black !important;" ><?php echo $i;  ?></td>
              <td style="border: 1px solid black !important; width: 30% !important;" ><?php echo strtoupper($rw->DEM_EMP_NAME_PREFIX." ".$rw->DEM_EMP_FIRST_NAME." ".$rw->DEM_EMP_MIDDLE_NAME." ".$rw->DEM_EMP_LAST_NAME); ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $rw->DEM_EMP_AGE; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php if($pay_track->DPT_TOTAL_DAYS_WORKED){ echo $pay_track->DPT_TOTAL_DAYS_WORKED; }else{ echo "-"; } ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_RATE; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php if($pay_track->DPT_TOTAL_GW_HRS){ echo $pay_track->DPT_TOTAL_GW_HRS; }else{ echo "-"; } ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_BASIC_SALARY; $basictotal+= $payroll_det->DPM_BASIC_SALARY; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_HRA; $hratotal += $payroll_det->DPM_HRA; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_OTHER_ALLOWANCE; $otherallowancestotal += $payroll_det->DPM_OTHER_ALLOWANCE; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_GROSS_WAGES_PAYABLE; $grosswagespayabletotal += $payroll_det->DPM_GROSS_WAGES_PAYABLE; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_PROFESSIONAL_TAX; $proftaxtotal += $payroll_det->DPM_PROFESSIONAL_TAX; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_PF_EMPLOYEE; $ep_pftotal += $payroll_det->DPM_PF_EMPLOYEE; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_PF_EMPLOYER;  $er_pftotal += $payroll_det->DPM_PF_EMPLOYER; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_ESIC_EMPLOYEE; $ep_esictotal += $payroll_det->DPM_ESIC_EMPLOYEE; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php echo $payroll_det->DPM_ESIC_EMPLOYER; $er_esictotal += $payroll_det->DPM_ESIC_EMPLOYER; ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php if($pay_track->TOTAL_DEDUCTION){ $totaldeductionsum += $pay_track->TOTAL_DEDUCTION; echo $pay_track->TOTAL_DEDUCTION; }else{ echo "-"; } ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php if($pay_track->DPT_NET_WAGES_PAID){ $netwagespaidsum += $pay_track->DPT_NET_WAGES_PAID; echo $pay_track->DPT_NET_WAGES_PAID; }else{ echo "-"; }  ?></td>
              <td style="border: 1px solid black !important; text-align: center;" ><?php if($pay_track->DPT_INVOICE_NO){ echo $pay_track->DPT_INVOICE_NO; }else{ echo "-"; } ?></td>
              <td style="border: 1px solid black !important;" ><?php echo "-"; ?></td>
                   
            </tr>
            <?php 
            } 
          } ?>
        </tbody>
        <tfoot>
          <tr>
            <td style="border: 1px solid black !important; text-align: right;" ><b></b></td>
            <td style="border: 1px solid black !important; text-align: right;" ><b>Total</b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $basictotal;  ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $hratotal;  ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $otherallowancestotal;  ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $grosswagespayabletotal; ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $proftaxtotal; ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $ep_pftotal; ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $er_pftotal; ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $ep_esictotal; ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $er_esictotal;  ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $totaldeductionsum; ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php echo $netwagespaidsum; ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php  ?></b></td>
            <td style="border: 1px solid black !important; text-align: center;" ><b><?php  ?></b></td>            
          </tr>          
        </tfoot>
      </table>
      <table class="table table-bordered" style="width:30%;border: 1px solid black !important;">
        <tr style="border: 1px solid black !important;">
          <td style="border: 1px solid black !important;"> PF CHALLAN AMOUNT</td>
          <td style="border: 1px solid black !important; text-align: right;"> <?php echo $ep_pftotal + $er_pftotal; ?></td>
        </tr>

        <tr style="border: 1px solid black !important;">
          <td style="border: 1px solid black !important;"> ESIC CHALLAN AMOUNT </td>
          <td style="border: 1px solid black !important; text-align: right;"> <?php echo $ep_esictotal + $er_esictotal; ?></td>
        </tr>

        <tr style="border: 1px solid black !important;">
          <td style="border: 1px solid black !important;"> TOTAL AMOUNT </td>
          <td style="border: 1px solid black !important; text-align: right;"> <?php echo  $ep_pftotal + $er_pftotal + $ep_esictotal + $er_esictotal; ?></td>
        </tr>        
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
            { extend: 'excelHtml5', footer: true, title: '<?php if (isset($title)){echo $title->ins_name." (".$fulldate." )";}   ?>' ,messageTop: 'FORM II M.W. RULES 1963 Rule 27'
            },
            // // { extend: 'csvHtml5', footer: true },
            // { extend: 'pdfHtml5', footer: true, title: '<?php if (isset($title)){echo $title->ins_name." (".$fulldate." )";}   ?>' , messageTop: 'FORM II M.W. RULES 1963 Rule 27', orientation: 'landscape',pageSize: 'A3' }
            
        ]

    } );


} );

</script>