<?php  
  if(isset($_GET['DEM_EMP_ID']) && isset($_GET['SAL_SUM_REP_FROM_DATE']) && isset($_GET['SAL_SUM_REP_TO_DATE']))
  {
    extract($_GET);
    // prnt($_GET);
    $yearly_array =[];
    $r=$db->get_row("SELECT * FROM dw_employee_master as a LEFT JOIN dw_payroll_master as b ON a.DEM_EMP_ID= b.DEM_EMP_ID WHERE a.DEM_EMP_ID='$DEM_EMP_ID'");
    // prnt($db->debug());
    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
    {      
      
      $month_selector = date('m',strtotime($mon_iterator));
      $year_selector = date('Y',strtotime($mon_iterator));
      $get_payments = $db->get_row("SELECT * FROM dw_payment_tracker as b  WHERE b.DPT_PAYMENT_MONTH ='$month_selector' AND b.DPT_PAYMENT_YEAR='$year_selector'");

      $yearly_array[$mon_iterator]['DPM_BASIC_SALARY'] = $r->DPM_BASIC_SALARY;
      $yearly_array[$mon_iterator]['DPM_HRA'] = $r->DPM_HRA;
      $yearly_array[$mon_iterator]['DPM_SPECIAL_ALLOWANCE'] = $r->DPM_SPECIAL_ALLOWANCE;
      $yearly_array[$mon_iterator]['DPM_OTHER_ALLOWANCE'] = $r->DPM_OTHER_ALLOWANCE;
      $yearly_array[$mon_iterator]['DPM_GROSS_WAGES_PAYABLE'] = $r->DPM_GROSS_WAGES_PAYABLE;
      $yearly_array[$mon_iterator]['DPM_PF_EMPLOYEE'] = $r->DPM_PF_EMPLOYEE;
      $yearly_array[$mon_iterator]['DPM_ESIC_EMPLOYEE'] = $r->DPM_ESIC_EMPLOYEE;
      $yearly_array[$mon_iterator]['DPM_PROFESSIONAL_TAX'] = $r->DPM_PROFESSIONAL_TAX;

      $DPM_TOTAL_DEDUCTION = $r->DPM_PF_EMPLOYEE + $r->DPM_ESIC_EMPLOYEE + $r->DPM_PROFESSIONAL_TAX;

      $yearly_array[$mon_iterator]['DPM_TOTAL_DEDUCTION'] = isset($DPM_TOTAL_DEDUCTION)?$DPM_TOTAL_DEDUCTION:'0';

      $yearly_array[$mon_iterator]['DPM_CALCULATED_AMOUNT'] = $r->DPM_CALCULATED_AMOUNT;

      $yearly_array[$mon_iterator]['DPT_TOTAL_DAYS_WORKED'] = $get_payments->DPT_TOTAL_DAYS_WORKED!=''?$get_payments->DPT_TOTAL_DAYS_WORKED:'0';

      $yearly_array[$mon_iterator]['NET_INHAND'] = $get_payments->NET_INHAND!=''?$get_payments->NET_INHAND:'0';

      $yearly_array[$mon_iterator]['DPM_EPS'] = $r->DPM_ESIC_EMPLOYER!=''? round((8.33 *  $r->DPM_ESIC_EMPLOYER ) / 100) :'0';

      $yearly_array[$mon_iterator]['DPM_PF_EMPLOYER'] = $r->DPM_PF_EMPLOYER -  $yearly_array[$mon_iterator]['DPM_EPS'];

      $yearly_array[$mon_iterator]['DPM_ESIC_EMPLOYER'] = $r->DPM_ESIC_EMPLOYER!=''?$r->DPM_ESIC_EMPLOYER:'0';

      $yearly_array[$mon_iterator]['TOTAL_INDIRECT'] =  $yearly_array[$mon_iterator]['DPM_EPS']  + $yearly_array[$mon_iterator]['DPM_PF_EMPLOYER'] + $yearly_array[$mon_iterator]['DPM_ESIC_EMPLOYER'];
      
      $yearly_array[$mon_iterator]['CASH_REIMBURSEMENT_MOBILE'] = $get_payments->CASH_REIMBURSEMENT_MOBILE!=''?$get_payments->CASH_REIMBURSEMENT_MOBILE:'0';

      $yearly_array[$mon_iterator]['CASH_REIMBURSEMENT_PETROL'] = $get_payments->CASH_REIMBURSEMENT_PETROL!=''?$get_payments->CASH_REIMBURSEMENT_PETROL:'0';

      $yearly_array[$mon_iterator]['TOTAL_CASH_REIMBURSEMENT'] = $get_payments->TOTAL_CASH_REIMBURSEMENT!=''?$get_payments->TOTAL_CASH_REIMBURSEMENT:'0';
      $yearly_array[$mon_iterator]['CTC'] =  $yearly_array[$mon_iterator]['DPM_GROSS_WAGES_PAYABLE'] + $yearly_array[$mon_iterator]['TOTAL_INDIRECT'] + $yearly_array[$mon_iterator]['TOTAL_CASH_REIMBURSEMENT'];

      $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

    }
                  
      // prnt($yearly_array);
    // prnt($r);
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
          <h3>Salary Summary Report</h3>
          <div class="box-tools">
            <a href="?folder=reports&file=salary_summary_report_list&exppdfsal_summary=1&DEM_EMP_ID=<?php echo $_GET['DEM_EMP_ID']; ?>&SAL_SUM_REP_FROM_DATE=<?php echo $_GET['SAL_SUM_REP_FROM_DATE']; ?>&SAL_SUM_REP_TO_DATE=<?php echo $_GET['SAL_SUM_REP_TO_DATE']; ?>" class="btn btn-info btn-round"><i class="fa fa-file"></i> PDF</a>
            <!-- <a href="?folder=travel_expense&file=view_travel_expense&expxldte_id=<?php echo $DTE_ID; ?>" class="btn btn-warning btn-round"><i class="fa fa-file"></i> Excel</a> -->
            <a href="?folder=reports&file=emp_report_filter_by_date" class="btn btn-default btn-round"><i class="fa fa-share"></i> Back</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <?php 
          if($r)
          { ?>
            <table  class="table table-bordered table-striped table-responsive" style="border: 1px solid black !important;">
              <tr>                
                <th style="border: 1px solid black !important;" >Engineer Name</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DEM_EMP_NAME_PREFIX." ".$r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME." (".$r->DEM_EMP_ID.")"; ?></td>

                <th style="border: 1px solid black !important;" >PAN</th> 
                <td style="border: 1px solid black !important;" ><?php echo $r->DEM_PAN_ID; ?></td>                              
              </tr>  

              <tr>                
                <th style="border: 1px solid black !important;" >DOJ</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("d-M-Y",strtotime($r->DEM_START_DATE)); ?></td>

                <th style="border: 1px solid black !important;" >Location</th> 
                <td style="border: 1px solid black !important;" ></td>                              
              </tr>
              <tr>                
                <th style="border: 1px solid black !important;" >Salary Summary From</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("M-Y",strtotime($SAL_SUM_REP_FROM_DATE)); ?></td>

                <th style="border: 1px solid black !important;" >To Month</th> 
                <td style="border: 1px solid black !important;" ><?php echo date("M-Y",strtotime($SAL_SUM_REP_TO_DATE)); ?></td>                              
              </tr>
              
            </table>
            <br>
            <br>
            <h4>This is salary slip only. This should not be treated as salary certificate</h4>
            <table class="table table-bordered table-striped table-responsive"> 
              <thead>
                <tr>
                  <th class="text-left" style="border: 1px solid black !important;font-size: 13px;">Heading</th>
                  <?php 
                  $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                  while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                  {
                  ?>
                    <th class="text-center" style="border: 1px solid black !important;font-size: 13px;"><?php echo date('M-Y',strtotime($mon_iterator)); ?></th>
                  <?php
                  $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));
                  }
                  ?>
                  
                </tr>
              </thead> 
              <tbody>
                  <tr>
                    <td  style="border: 1px solid black !important;text-align:left;">Basic Salary</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_BASIC_SALARY'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">HRA @ 25% of Basic Salary</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_HRA'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">Spl. Allowance</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_SPECIAL_ALLOWANCE'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">Incentive</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_OTHER_ALLOWANCE'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;"><b>Gross Earning(Rs) (A)</b></td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <b>
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_GROSS_WAGES_PAYABLE'];
                         ?>
                       </b>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">PF</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_PF_EMPLOYEE'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">ESIC</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_ESIC_EMPLOYEE'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">PT</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_PROFESSIONAL_TAX'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">Total deduction (B)</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_TOTAL_DEDUCTION'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;"><b>Net salary(Rs)=A-B</b></td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <b>
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_CALCULATED_AMOUNT'];
                         ?>
                       </b>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">Days Worked</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPT_TOTAL_DAYS_WORKED'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">Net In-Hand</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['NET_INHAND'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">PF contribution - Employer</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_PF_EMPLOYER'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">EPS</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_EPS'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">ESI Fees - Employer</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['DPM_ESIC_EMPLOYER'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;"><b>Total Indirects (C)</b></td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <b></b>
                        <?php 
                        echo $yearly_array[$mon_iterator]['TOTAL_INDIRECT'];
                         ?>
                         </b>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">Cash Reimbursement Mobile</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['CASH_REIMBURSEMENT_MOBILE'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">Cash Reimbursement Petrol</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['CASH_REIMBURSEMENT_PETROL'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;">Total cash Reimbursements (D)</td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <?php 
                        echo $yearly_array[$mon_iterator]['TOTAL_CASH_REIMBURSEMENT'];
                         ?>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>

                  <tr>
                    <td style="border: 1px solid black !important;text-align:left;"><b>CTC for the Month = A+C+D</b></td>
                    <?php 
                    $mon_iterator= $SAL_SUM_REP_FROM_DATE;
                    while($mon_iterator<=$SAL_SUM_REP_TO_DATE)
                    {

                    ?>
                      <td style="border: 1px solid black !important;text-align:center;">
                        <b>
                        <?php 
                        echo $yearly_array[$mon_iterator]['CTC'];
                         ?>
                       </b>
                      </td>
                    <?php
                    $mon_iterator = date('Y-m', strtotime("+1 month", strtotime($mon_iterator)));

                    }
                    ?>
                  </tr>
              </tbody>
              
            </table>
          <?php 
          } 
          ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

