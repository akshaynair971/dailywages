<?php
$title =$db->get_row("SELECT * FROM general_setting WHERE gs_id=1");

// Generate Excel for Overall Expense

if(isset($_GET['overall_trexp_xl']))
{
  extract($_GET);
  

  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  $filter='';

    if(empty($_GET['texp_single_month']) && empty($_GET['texp_start_date']) && empty($_GET['texp_end_date']) && empty($_GET['DEM_EMP_ID']) && $_GET['expense_for']=="all")
    {
      $filter .= "";
    }
    else
    {
      $filter .= " WHERE";
    }
    if($_GET['texp_single_month'])
    {
      $datearray = explode("-",$texp_single_month);
      $filter .= " YEAR(a.DTE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DTE_VOUCHER_DATE)=$datearray[1] AND";
    }
    if($_GET['texp_start_date'] && $_GET['texp_end_date'])
    {
      $filter .= " DATE(a.DTE_VOUCHER_DATE)>='$texp_start_date' AND DATE(a.DTE_VOUCHER_DATE)<='$texp_end_date' AND";
    }
    if($_GET['DEM_EMP_ID'])
    {
      $filter .= " a.DEM_EMP_ID = '".$DEM_EMP_ID."' AND";
    }
    $filter = rtrim($filter," AND");
      // prnt($filter);
    
    $filter .= " ORDER BY a.DTE_ID DESC";

    $r=$db->get_results("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID $filter");
  

  $objPHPExcel->setActiveSheetIndex(0);  

  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(13);
  $rowtitleCount=1;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount,strtoupper($title->ins_name)); 
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount, $title->ins_address);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount, "Travelling Expense Statement".$headertitle);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  
  $objPHPExcel->getActiveSheet()->setCellValue("A4","Sr No.")->getColumnDimension('A')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("B4","Engineer Name")->getColumnDimension('B')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("C4","Place")->getColumnDimension('C')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("D4","Voucher Date")->getColumnDimension('D')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("E4","Voucher Ref.")->getColumnDimension('E')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("F4","Date From")->getColumnDimension('F')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("G4","Date To")->getColumnDimension('G')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("H4","Travel")->getColumnDimension('H')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("I4","Conveyance")->getColumnDimension('I')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("J4","L/B")->getColumnDimension('J')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("K4","Extra")->getColumnDimension('K')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("L4","Total for Visit")->getColumnDimension('L')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("M4","Status")->getColumnDimension('M')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("N4","Paid Date")->getColumnDimension('N')->setAutoSize(true);
  $rowtitleCount++;

  if(isset($r)){
    $emp = 0;

    $rc=$rowtitleCount;
    $grand_travel_total = $grand_conveyance_total = $grand_lb_total = $grand_extra_total = $grand_subtotal = 0;
    foreach ($r as $row)
    {
      $emp++;

      $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,$emp)->getColumnDimension('A')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,$row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME)->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$row->DTE_LOCATION)->getColumnDimension('C')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,date("d-M-Y",strtotime($row->DTE_VOUCHER_DATE)))->getColumnDimension('D')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("E".$rc,$row->DTE_VOUCHER_REF)->getColumnDimension('E')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,date("d-M-Y",strtotime($row->DTE_DEPARTED_DATE)))->getColumnDimension('F')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("G".$rc,date("d-M-Y",strtotime($row->DTE_RETURNED_DATE)))->getColumnDimension('G')->setAutoSize(true);

      $json = json_decode($row->DTE_TRAVEL_SUMMARY);
      if($json)
      {    
        $travel_total = $conveyance_total = $lb_total = $extra_total = $subtotal = 0;
        
        for ($i=0; $i < count($json->JOURNEY_DATE); $i++)
        {
          $main_total = 0;  
          $travel_total += $json->TRAVEL_CHRG[$i];
          $conveyance_total += $json->CONVEY_CHRG[$i];
          $lb_total += $json->L_B_CHRG[$i];
          $extra_total += $json->EXTRA_CHRG[$i];  
          $subtotal += $json->TOTAL_CHRG[$i]; 
        }
        $grand_travel_total += $travel_total;
        $grand_conveyance_total += $conveyance_total;
        $grand_lb_total += $lb_total;
        $grand_extra_total += $extra_total;
        $grand_subtotal += $subtotal;
      }
      $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,$travel_total)->getColumnDimension('H')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("I".$rc,$conveyance_total)->getColumnDimension('I')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("J".$rc,$lb_total)->getColumnDimension('J')->setAutoSize(true);      
      $objPHPExcel->getActiveSheet()->setCellValue("K".$rc,$extra_total)->getColumnDimension('K')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("L".$rc,$subtotal)->getColumnDimension('L')->setAutoSize(true);


      if($row->DTE_PAYMENT_STATUS==1){ $paystat= "PAID"; }else{ $paystat= "UNPAID"; }
      if($row->DTE_PAID_DATE!=0){ $DTE_PAID_DATE= date("d-M-Y",strtotime($row->DTE_PAID_DATE)); }else{ $DTE_PAID_DATE= "--"; }

      $objPHPExcel->getActiveSheet()->setCellValue("M".$rc,$paystat)->getColumnDimension('M')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("N".$rc,$DTE_PAID_DATE)->getColumnDimension('N')->setAutoSize(true);

      $rc++;  
    }
    

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Total");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
    $objPHPExcel->getActiveSheet()->mergeCells("B".$rc.":".$adjustedColumn.$rc);
    $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,$grand_travel_total);
    $objPHPExcel->getActiveSheet()->setCellValue("I".$rc,$grand_conveyance_total);
    $objPHPExcel->getActiveSheet()->setCellValue("J".$rc,$grand_lb_total);
    $objPHPExcel->getActiveSheet()->setCellValue("K".$rc,$grand_extra_total);
    $objPHPExcel->getActiveSheet()->setCellValue("L".$rc,$grand_subtotal);
    $rc++;
    $rc++;

    $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B1:B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H1:H'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('I1:I'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('J1:J'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('K1:K'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('L1:L'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('M1:M'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('N1:N'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->setCellValue("I".$rc," ");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    $objPHPExcel->getActiveSheet()->mergeCells("I".$rc.":".$adjustedColumn.$rc);

    $objPHPExcel->getActiveSheet()->setCellValue("J".$rc,"Grand Total");  
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(10);
    $objPHPExcel->getActiveSheet()->mergeCells("J".$rc.":".$adjustedColumn.$rc);
    $objPHPExcel->getActiveSheet()->setCellValue("L".$rc,$grand_subtotal);  

    $rc++;

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Signature");
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
    $objPHPExcel->getActiveSheet()->mergeCells("B".$rc.":".$adjustedColumn.$rc);
      
    $objPHPExcel->getActiveSheet()->setCellValue("C".$rc," ");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
    $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

    $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Approved By");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
    $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
    
    $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

    $rc++; 

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Date");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
    $objPHPExcel->getActiveSheet()->mergeCells("B".$rc.":".$adjustedColumn.$rc);
      
    $objPHPExcel->getActiveSheet()->setCellValue("C".$rc," ");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
    $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

    $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Date");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
    $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
    
    $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

    $rc++;

    $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Place");  
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
    $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
    $objPHPExcel->getActiveSheet()->setCellValue("G".$rc," ");  
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);  
  }

  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod("travelexpense_report.xlsx", 0777);
  $objWriter->save('travelexpense_report.xlsx'); 
  header('location:download.php?file_url=travelexpense_report.xlsx');
  echo('<script>window.open("'.site_root.'travelexpense_report.xlsx", "_blank","",true);</script>');


  echo "<script>window.location='?folder=travel_expense&file=travel_expense_list';</script>";
}
// End of Generate Excel for Overall Expense

// Generate PDF for Overall Expense

if(isset($_GET['overall_leave_rep_pdf']))
{
  extract($_GET);
  
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


  $html='';

  $html .='<table id="example1" class="table table-bordered table-striped" role="grid">
  <thead>
    <tr>
      <th style="text-align:center;">Sr.No</th>
      <th style="text-align:center;">EMP. ID.</th>
      <th style="text-align:center;">EMP. NAME</th>
      <th style="text-align:center;">AT OFFICE</th>
      <th style="text-align:center;">AT CUSTOMER SITE</th>
      <th style="text-align:center;">PRIVILAGE LEAVES</th>
      <th style="text-align:center;">CASUAL LEAVES</th>
      <th style="text-align:center;">SICK LEAVES</th>
      <th style="text-align:center;">COMPENSATORY OFFS</th>
      <th style="text-align:center;">PUBLIC HOLIDAYS</th>
    </tr>  
  </thead>
  <tbody>'; 

  if(isset($r)){
    $emp = 0;
    foreach ($r as $row){
      $emp++;
      
      $html .= '<tr>';
      $html .="<td style='text-align:center;'>".$emp."</td>          
      <td style='text-align:center;'>".$row->DEM_EMP_ID."</td>   
      <td style='text-align:center;'>".$row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME."</td>";

      $at_office = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='OFFICE'");

      $html .="<td style='text-align:center;'>".$at_office."</td>";
      

      $at_customer_site = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='CUSTOMER SITE'");

      $html .="<td style='text-align:center;'>".$at_customer_site."</td>";

      
      $privilage_leaves = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='PRIVILAGE LEAVE'");
      
      $html .="<td style='text-align:center;'>".$privilage_leaves."</td>";                    
     
      $casual_leaves = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='CASUAL LEAVE'");
      
      $html .="<td style='text-align:center;'>".$casual_leaves."</td>";             
     
      $sick_leaves = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='SICK LEAVE'");
      
      $html .="<td style='text-align:center;'>".$sick_leaves."</td>";                    
     
      $compensatory_offs = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='COMPENSATORY OFF'");
      
      $html .="<td style='text-align:center;'>".$compensatory_offs."</td>";                    
     
      $public_holidays = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$row->DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' AND DEA_CURRENT_LOCATION='PUBLIC HOLIDAY'");
      
      $html .="<td style='text-align:center;'>".$public_holidays."</td>";
      $html .= '</tr>';
    } 
  }

  $html .= '</tbody>';
  $html .= '</table>';
  $html .= '<br>';

  $html .='<table id="example1" class="table" style="border:none !important;">';
  
  $html .='<tr>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Signature</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Approved By</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='</tr>';

  $html .='<tr>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='</tr>';

  $html .='<tr>';
  $html .='<th style="width:25%;text-align:right;border:none !important;"></th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Place</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='</tr>';
  
  $html .='</table>'; 

  $pdf_title ="Leave Reports (".date('M-Y',strtotime($initial_fin_year))." ~ ".date('M-Y',strtotime($final_fin_year)).")";

  $pdf_stat = createPdf($db,$pdf_title,$html,"a4","landscape","leave_reports"); 
  // prnt($pdf_stat);

}
// End of Generate PDF for Overall Attendance


// START Generate PDF for Detailed Attendance

if(isset($_GET['exp_pdf_DEM_EMP_ID']))
{
  extract($_GET);
  
  $user_details=$db->get_row("SELECT b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_employee_master as b WHERE b.DEM_EMP_ID='$exp_pdf_DEM_EMP_ID'");


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

  $r = $db->get_results("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$exp_pdf_DEM_EMP_ID' AND DATE(DEA_ATTD_DATE)>= '$initial_fin_year' AND DATE(DEA_ATTD_DATE)<='$final_fin_year' ORDER BY DEA_CURRENT_LOCATION ASC ");   


  $html='';

  $html .='<table id="example1" class="table table-bordered table-striped" role="grid">
  <thead>
    <tr>
      <th style="text-align:center;">SR.NO</th>
      <th style="text-align:center;">DATE</th>
      <th style="text-align:center;">DAY</th>
      <th style="text-align:center;">LEAVES/LOCATION</th>
      <th style="text-align:center;">REMARKS</th>
    </tr>  
  </thead>
  <tbody>'; 

  if(isset($r)){
    $emp = 0;
    foreach ($r as $row){
      $emp++;
      
      $html .= "<tr>
      <td style='text-align:center;'>".$emp."
      <td style='text-align:center;'>".date('d-M-Y',strtotime($row->DEA_ATTD_DATE))."
      <td style='text-align:center;'>".date('D',strtotime($row->DEA_ATTD_DATE))."
      <td style='text-align:center;'>".$row->DEA_CURRENT_LOCATION."
      <td style='text-align:center;'>".$row->DEA_REMARK."
    </tr>";
    } 
  }

  $html .= '</tbody>';
  $html .= '</table>';
  $html .= '<br>';

  $html .='<table id="example1" class="table" style="border:none !important;">';
  
  $html .='<tr>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Signature</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Approved By</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='</tr>';

  $html .='<tr>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='</tr>';

  $html .='<tr>';
  $html .='<th style="width:25%;text-align:right;border:none !important;"></th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='<th style="width:25%;text-align:right;border:none !important;">Place</th>';
  $html .='<td style="width:25%;border:none !important;"></td>';
  $html .='</tr>';
  
  $html .='</table>'; 

  $pdf_title ="Leave Report of ".$user_details->DEM_EMP_NAME_PREFIX." ".$user_details->DEM_EMP_FIRST_NAME." ".$user_details->DEM_EMP_MIDDLE_NAME." ".$user_details->DEM_EMP_LAST_NAME." (".$user_details->DEM_EMP_ID.") - (".date('M-Y',strtotime($initial_fin_year))." ~ ".date('M-Y',strtotime($final_fin_year)).")";

  $pdf_stat = createPdf($db,$pdf_title,$html,"a4","protrait","detailed_leave_reports"); 
  // prnt($pdf_stat);

}
// END Generate PDF for Detailed Attendance

// Generate Excel for Detailed Attendance

if(isset($_GET['expxldte_id']))
{
  extract($_GET);

  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  $r=$db->get_row("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID WHERE a.DTE_ID='$expxldte_id' ORDER BY a.DTE_ID DESC");

  $objPHPExcel->setActiveSheetIndex(0);  

  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $rowtitleCount=1;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount,strtoupper($title->ins_name)); 
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount, $title->ins_address);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount, "Travelling Expense Statement");
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  
  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Voucher Ref.");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
    
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rowtitleCount,$r->DTE_VOUCHER_REF);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rowtitleCount,"Voucher Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rowtitleCount,date("d-M-Y",strtotime($r->DTE_VOUCHER_DATE)));
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Departed Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
    
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rowtitleCount,date("d-M-Y",strtotime($r->DTE_DEPARTED_DATE)));
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rowtitleCount,"Returned Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rowtitleCount,date("d-M-Y",strtotime($r->DTE_RETURNED_DATE)));
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Engineer Name");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);

  $objPHPExcel->getActiveSheet()->setCellValue("C".$rowtitleCount,$r->DEM_EMP_NAME_PREFIX." ".$r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME." (".$r->DEM_EMP_ID.")");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rowtitleCount,"Location");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rowtitleCount,$r->DTE_LOCATION);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Travelling Details");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  $rowtitleCount++;

  
  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Sr. No.")->getColumnDimension('A')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("B".$rowtitleCount,"Date")->getColumnDimension('B')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rowtitleCount,"Place")->getColumnDimension('C')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("D".$rowtitleCount,"Travel")->getColumnDimension('D')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("E".$rowtitleCount,"Conveyance")->getColumnDimension('E')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("F".$rowtitleCount,"L/B")->getColumnDimension('F')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("G".$rowtitleCount,"Extra")->getColumnDimension('G')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rowtitleCount,"Total")->getColumnDimension('H')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("I".$rowtitleCount,"Remarks")->getColumnDimension('I')->setAutoSize(true);
  $rowtitleCount++;
 
  $rc=$rowtitleCount;  

  $json = json_decode($r->DTE_TRAVEL_SUMMARY);
  if($json)
  {
    $cnt=1;
    $travel_total = $conveyance_total = $lb_total = $extra_total = $subtotal = 0;
    for ($i=0; $i < count($json->JOURNEY_DATE); $i++)
    {
      $main_total = 0;      
      
      $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,$cnt)->getColumnDimension('A')->setAutoSize(true);

      $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,date("d-M-Y",strtotime($json->JOURNEY_DATE[$i])))->getColumnDimension('B')->setAutoSize(true);

      $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$json->JOURNEY_PLACE[$i])->getColumnDimension('C')->setAutoSize(true);

      $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,$json->TRAVEL_CHRG[$i])->getColumnDimension('D')->setAutoSize(true);
      $travel_total += $json->TRAVEL_CHRG[$i];

      $objPHPExcel->getActiveSheet()->setCellValue("E".$rc,$json->CONVEY_CHRG[$i])->getColumnDimension('E')->setAutoSize(true);
      $conveyance_total += $json->CONVEY_CHRG[$i];

      $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,$json->L_B_CHRG[$i])->getColumnDimension('F')->setAutoSize(true);
      $lb_total += $json->L_B_CHRG[$i];            

      $objPHPExcel->getActiveSheet()->setCellValue("G".$rc,$json->EXTRA_CHRG[$i])->getColumnDimension('G')->setAutoSize(true);
      $extra_total += $json->EXTRA_CHRG[$i];             

      $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,$json->TOTAL_CHRG[$i])->getColumnDimension('H')->setAutoSize(true);
      $subtotal += $json->TOTAL_CHRG[$i];                 

      $objPHPExcel->getActiveSheet()->setCellValue("I".$rc,$json->REMARKS[$i])->getColumnDimension('I')->setAutoSize(true);

      $rc++;
      $cnt++;
               
    }  
  }

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Total");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(2);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);
  $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,$travel_total);
  $objPHPExcel->getActiveSheet()->setCellValue("E".$rc,$conveyance_total);
  $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,$lb_total);
  $objPHPExcel->getActiveSheet()->setCellValue("G".$rc,$extra_total);
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,$subtotal);
  $rc++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Grand Total")->getColumnDimension('F')->setAutoSize(true); 
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,$subtotal);  

  $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('B1:B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('H1:H'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    

  $rc++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Signature");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);
    
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rc," ");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Approved By");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

  $rc++;  

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);
    
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rc," ");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

  $rc++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Advance in hand");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);
    
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$r->DTE_ADVANCE_IN_HAND);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Place");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

  $rc++;

  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod("travelexpense_report.xlsx", 0777);
  $objWriter->save('travelexpense_report.xlsx'); 
  header('location:download.php?file_url=travelexpense_report.xlsx');
  echo('<script>window.open("'.site_root.'travelexpense_report.xlsx", "_blank","",true);</script>');


  echo "<script>window.location='?folder=reports&file=emp_attd_detailed_single_month&DEM_EMP_ID=".$_GET['DEM_EMP_ID']."&select_attd_month=".$expxlselect_attd_month."';</script>";
}


if(isset($_POST['DTE_SUBMIT_PAYMENT_STATUS']))
{
  extract($_POST);  
  // prnt($_POST);
  $addpayment = $db->query("UPDATE dw_travel_expense SET DTE_PAYMENT_STATUS='$DTE_PAYMENT_STATUS',DTE_PAID_DATE='$DTE_PAID_DATE',DTE_PAYMENT_REFERENCE='$DTE_PAYMENT_REFERENCE' WHERE DTE_ID='$DTE_ID'");
  if($addpayment)
  {
    echo "<script>alert('Payment Status Added Successfully..!'); window.location='index.php?folder=travel_expense&file=travel_expense_list';</script>";
  }
}




?>



