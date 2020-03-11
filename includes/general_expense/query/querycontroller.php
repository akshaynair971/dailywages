<?php
$title =$db->get_row("SELECT * FROM general_setting WHERE gs_id=1");
if(isset($_GET['del_DTE_ID']))
{
  extract($_GET);
  $deltxp= $db->query("DELETE FROM dw_travel_expense WHERE DTE_ID='$del_DTE_ID'");

  if($deltxp)
  {
    echo "<script> window.location='?folder=travel_expense&file=travel_expense_list';</script>";
  }
}


// ADD GENERAL EXPENSE 
if(isset($_POST['SAVE_GENERAL_EXP']) || isset($_POST['SAVE_LOCK_GENERAL_EXP']))
{
  extract($_POST);
  
  // prnt($_POST);
  // die();

  $userid = $db->get_row("SELECT DEM_ID,DEM_EMP_ID FROM dw_employee_master WHERE DEM_ID='$DEM_ID'");
  $getmaxtrid = $db->get_var("SELECT count(DEM_ID) FROM dw_general_expenses WHERE DEM_ID='$DEM_ID'");
  $getmaxtrid +=1;
  if(date('M')>date('M',strtotime('March')))
  {
    $finyear = date('y').date('y',strtotime('+1 Years'));
  }else{
    $finyear = date('y',strtotime('-1 Years')).date('y');
  }
  $voucherref = $userid->DEM_EMP_ID.$finyear.$getmaxtrid."T";
  // prnt($voucherref);
  // die();
  if(isset($_POST['SAVE_GENERAL_EXP']))
  {
    $DGE_STATUS=1;
  }
  if(isset($_POST['SAVE_LOCK_GENERAL_EXP']))
  {
    $DGE_STATUS=0;
  }
  
  $DGE_EXPENSE_SUMMARY = json_encode($DGE_EXPENSE_SUMMARY);
  
  if(isset($_GET['DGE_ID'])){
    $update_trexp = $db->query("UPDATE dw_general_expenses SET DEM_ID='$DEM_ID',DGE_VOUCHER_REF='$voucherref',DGE_VOUCHER_DATE='$DGE_VOUCHER_DATE',DGE_LOCATION='$DGE_LOCATION',DGE_INVOICE_NO='$DGE_INVOICE_NO',DGE_INVOICE_DATE='$DGE_INVOICE_DATE',DGE_EXPENSE_SUMMARY='$DGE_EXPENSE_SUMMARY',DGE_TOTAL='$DGE_TOTAL',DGE_STATUS='$DGE_STATUS',DGE_UPDATED_DATE=NOW() WHERE DGE_ID='".$_GET['DGE_ID']."'");

    if($update_trexp)
    {
      echo "<script> alert('General Expense Updated Successfully..!'); window.location='?folder=general_expense&file=general_expense_list';</script>";
    }

  }else{
    $insert_trexp= $db->query("INSERT INTO dw_general_expenses (DEM_ID,DGE_VOUCHER_REF,DGE_VOUCHER_DATE,DGE_LOCATION,DGE_INVOICE_NO,DGE_INVOICE_DATE,DGE_EXPENSE_SUMMARY,DGE_TOTAL,DGE_CREATED_DATE,DGE_UPDATED_DATE,DGE_STATUS) VALUES('$DEM_ID','$voucherref','$DGE_VOUCHER_DATE','$DGE_LOCATION','$DGE_INVOICE_NO','$DGE_INVOICE_DATE','$DGE_EXPENSE_SUMMARY','$DGE_TOTAL',NOW(),NOW(),'$DGE_STATUS')"); 
    // $db->debug();
    
    if($insert_trexp)
    {
      echo "<script> alert('General Expense Saved Successfully..!'); window.location='?folder=general_expense&file=general_expense_list';</script>";
    }  

  }
  
}

// END OF ADD GENERAL EXPENSE 


// Generate Excel for Overall Expense

if(isset($_GET['overall_trexp_xl']))
{
  extract($_GET);
  

  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  if($_SESSION['user_type']=='2')
  {
    if($_GET['texp_start_date'] && $_GET['texp_end_date'])
    {
      $filter = "a.DTE_VOUCHER_DATE>'$texp_start_date' AND a.DTE_VOUCHER_DATE<'$texp_end_date' AND a.DEM_EMP_ID = '".$_SESSION['DEM_EMP_ID']."' ORDER BY a.DTE_ID DESC";

      $headertitle = " (From ".$texp_start_date." To ".$texp_end_date.")";
    } 
    if($_GET['curr_month_texp_date'])
    {
      $datearray = explode("-",$curr_month_texp_date);
      $filter = "YEAR(a.DTE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DTE_VOUCHER_DATE)=$datearray[1] AND a.DEM_EMP_ID = '".$_SESSION['DEM_EMP_ID']."' ORDER BY a.DTE_ID DESC";
      $headertitle = " of ".date('M Y',strtotime($curr_month_texp_date));
    } 
  }else
  {
    if($_GET['texp_start_date'] && $_GET['texp_end_date'])
    {
      $filter = "a.DTE_VOUCHER_DATE>'$texp_start_date' AND a.DTE_VOUCHER_DATE<'$texp_end_date' ORDER BY a.DTE_ID DESC";
      $headertitle = " (From ".$texp_start_date." To".$texp_end_date.")";
    }
    if($_GET['curr_month_texp_date'])
    {
      $datearray = explode("-",$curr_month_texp_date);
      $filter = "YEAR(a.DTE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DTE_VOUCHER_DATE)=$datearray[1] ORDER BY a.DTE_ID DESC";
      $headertitle = " of ".date('M Y',strtotime($curr_month_texp_date));
    } 
  }
  $r=$db->get_results("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID WHERE $filter");
  

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

if(isset($_GET['overall_trexp_pdf']))
{
  extract($_GET);
  
  include_once('./dompdf/dompdf_config.inc.php');

  if($_SESSION['user_type']=='2')
  {
    if($_GET['texp_start_date'] && $_GET['texp_end_date'])
    {
      $filter = "a.DTE_VOUCHER_DATE>'$texp_start_date' AND a.DTE_VOUCHER_DATE<'$texp_end_date' AND a.DEM_EMP_ID = '".$_SESSION['DEM_EMP_ID']."' ORDER BY a.DTE_ID DESC";

      $headertitle = " (From ".$texp_start_date." To ".$texp_end_date.")";
    } 
    if($_GET['curr_month_texp_date'])
    {
      $datearray = explode("-",$curr_month_texp_date);
      $filter = "YEAR(a.DTE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DTE_VOUCHER_DATE)=$datearray[1] AND a.DEM_EMP_ID = '".$_SESSION['DEM_EMP_ID']."' ORDER BY a.DTE_ID DESC";
      $headertitle = " of ".date('M Y',strtotime($curr_month_texp_date));
    } 
  }else
  {
    if($_GET['texp_start_date'] && $_GET['texp_end_date'])
    {
      $filter = "a.DTE_VOUCHER_DATE>'$texp_start_date' AND a.DTE_VOUCHER_DATE<'$texp_end_date' ORDER BY a.DTE_ID DESC";
      $headertitle = " (From ".$texp_start_date." To".$texp_end_date.")";
    }
    if($_GET['curr_month_texp_date'])
    {
      $datearray = explode("-",$curr_month_texp_date);
      $filter = "YEAR(a.DTE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DTE_VOUCHER_DATE)=$datearray[1] ORDER BY a.DTE_ID DESC";
      $headertitle = " of ".date('M Y',strtotime($curr_month_texp_date));
    } 
  }

  $r=$db->get_results("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID WHERE $filter");

  $html='';


  $html .='<style>
  p,h5
  {
    margin:0px;
    padding:0px;
  }

  .table strong {
    padding-top: 12px;
    padding-bottom: 12px;
    border-collapse: collapse;
    width: 100%;  
  }

  img
  {
    height:70px;
  }

  .table
  {
    cell-padding:0px;
    cell-spacing:0px;
    border-collapse:collapse;
    width:100%;
    border:1px solid #000000;
    font-size: 12px;
  }

  .table td,.table th
  {
    padding:5px;
    border:1px solid #000000;
  }

  p
  {
    font-size: 12px;
  }

  body
  {
    font-family:verdana;
  }

  @page {
    margin: 0.5cm;
  }

  .footer{
    position: absolute;
  }

  .footer{
    bottom:0;
    text-align:center;   
  }
  </style>';

  $html.='<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
  $html.='<div style="border: 1px solid;padding:2%;">
  <table style="width: 100%;border-bottom:1px solid;">
  <tr>
    <td><img src="images/logo/'.$title->inst_id.'.jpg"></td>
    <td><center><h5 style="color:#9c4d55; font-size:22px; font-weight:900;">'.$title->ins_name.'</h5><span>'.$title->ins_address.'</span><center></td>
    <td>'.date('d-M-Y').'</td>
  </tr>
  ';
  $html.='</table>';

  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> Travel Expense Statement '.$headertitle.'</p>';
  $html.='<hr>';
  $html.='<br>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid">
  <thead>
    <tr>
      <th>Sr. No.</th>
      <th style="text-align:center;"> Engineer Name</th>
      <th style="text-align:center;"> Place</th>
      <th style="text-align:center;"> Voucher Date</th>
      <th style="text-align:center;"> Voucher Ref.</th>
      <th style="text-align:center;"> Date From</th>
      <th style="text-align:center;"> Date to</th>
      <th style="text-align:center;"> Travel</th>
      <th style="text-align:center;"> Conveyance</th>
      <th style="text-align:center;"> L/B</th>
      <th style="text-align:center;"> Extra</th>
      <th style="text-align:center;"> Total</th>
      <th style="text-align:center;"> Status</th>
      <th style="text-align:center;"> Paid Date</th>
    </tr>  
  </thead>
  <tbody>';
  if(isset($r)){
    $emp = 0;
    $grand_travel_total = $grand_conveyance_total = $grand_lb_total = $grand_extra_total = $grand_subtotal = 0;
    foreach ($r as $row)
    {
      $emp++;
      $html.='<tr>'; 
      $html.='<td style="text-align:center;">'.$emp.'</td>'; 
      $html.='<td style="text-align:center;">'.$row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME.'</td>'; 
      $html.='<td style="text-align:center;">'.$row->DTE_LOCATION.'</td>'; 
      $html.='<td style="text-align:center;">'.date("d-M-Y",strtotime($row->DTE_VOUCHER_DATE)).'</td>'; 
      $html.='<td style="text-align:center;">'.$row->DTE_VOUCHER_REF.'</td>'; 
      $html.='<td style="text-align:center;">'.date("d-M-Y",strtotime($row->DTE_DEPARTED_DATE)).'</td>'; 
      $html.='<td style="text-align:center;">'.date("d-M-Y",strtotime($row->DTE_RETURNED_DATE)).'</td>'; 
   
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
      if($row->DTE_PAYMENT_STATUS==1){ $paystat= "PAID"; }else{ $paystat= "UNPAID"; }
      if($row->DTE_PAID_DATE!=0){ $DTE_PAID_DATE= date("d-M-Y",strtotime($row->DTE_PAID_DATE)); }else{ $DTE_PAID_DATE= "--"; }

      $html.='<td style="text-align:center;">'.$travel_total.'</td>'; 
      $html.='<td style="text-align:center;">'.$conveyance_total.'</td>'; 
      $html.='<td style="text-align:center;">'.$lb_total.'</td>'; 
      $html.='<td style="text-align:center;">'.$extra_total.'</td>'; 
      $html.='<td style="text-align:center;">'.$subtotal.'</td>'; 
      $html.='<td style="text-align:center;">'.$paystat.'</td>'; 
      $html.='<td style="text-align:center;">'.$DTE_PAID_DATE.'</td>'; 
      $html.='</tr>'; 
    }
    $html.='</tbody>';

    $html.='<tfoot>';
    $html.='<tr>';
    $html.='<th></th>';
    $html.='<th  style="text-align:right;" colspan="6">Total</th>';
   
    $html.='<th style="text-align:center;">'.$grand_travel_total.'</th>';
    $html.='<th style="text-align:center;">'.$grand_conveyance_total.'</th>';
    $html.='<th style="text-align:center;">'.$grand_lb_total.'</th>';
    $html.='<th style="text-align:center;">'.$grand_extra_total.'</th>';
    $html.='<th style="text-align:center;">'.$grand_subtotal.'</th>';
    $html.='<th></th>';
    $html.='<th></th>';
    $html.='</tr>';
    $html.='</tfoot>';
    $html.='</table>';

    $html.='<table id="example1" class="table" style="border:none !important;">';
    $html.='<tr>';
    $html.='<th colspan="2" style="border:none !important;"></th>';
    $html.='<th class="text-right" style="text-align:right;border:none !important;"> Grand Total</th>';
    $html.='<th style="text-align:left;border:none !important;">'.$grand_subtotal.'</th>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Signature</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Approved By</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;text-align:right;border:none !important;"></th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Place</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='</tr>';
    
    $html.='</table>';
    }

    $dompdf = new DOMPDF();  
    $dompdf->set_paper('a3', 'landscape');  
    $dompdf->load_html($html);
    $dompdf->render();
    $pdf = $dompdf->output();

    $fp = fopen("reports/travel_expense_report.pdf", 'w');
    fclose($fp);
    chmod("reports/travel_expense_report.pdf", 0777); 
    file_put_contents("reports/travel_expense_report.pdf", $pdf);  
    
    header('location:download.php?file_url=reports/travel_expense_report.pdf');
    echo('<script>window.open("'.site_root.'reports/travel_expense_report.pdf", "_blank","",true);</script>');
  

  echo "<script>window.location='?folder=travel_expense&file=travel_expense_list';</script>";
}
// End of Generate PDF for Overall Attendance


// START Generate PDF for Detailed Attendance

if(isset($_GET['exppdfdte_id']))
{
  extract($_GET);
  include_once('./dompdf/dompdf_config.inc.php');

  $r=$db->get_row("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_travel_expense as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID WHERE a.DTE_ID='$exppdfdte_id' ORDER BY a.DTE_ID DESC");

  $html='';


  $html .='<style>
  p,h5
  {
    margin:0px;
    padding:0px;
  }

  .table strong {
    padding-top: 12px;
    padding-bottom: 12px;
    border-collapse: collapse;
    width: 100%;  
  }

  img
  {
    height:70px;
  }

  .table
  {
    cell-padding:0px;
    cell-spacing:0px;
    border-collapse:collapse;
    width:100%;
    border:1px solid #000000;
    font-size: 12px;
  }

  .table td,.table th
  {
    padding:5px;
    border:1px solid #000000;
  }

  p
  {
    font-size: 12px;
  }

  body
  {
    font-family:verdana;
  }

  @page {
    margin: 0.5cm;
  }

  .footer{
    position: absolute;
  }

  .footer{
    bottom:0;
    text-align:center;   
  }
  </style>';

  $html.='<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
  $html.='<div style="border: 1px solid;padding:2%;">
  <table style="width: 100%;border-bottom:1px solid;">
  <tr>
    <td><img src="images/logo/'.$title->inst_id.'.jpg"></td>
    <td><center><h5 style="color:#9c4d55; font-size:22px; font-weight:900;">'.$title->ins_name.'</h5><span>'.$title->ins_address.'</span><center></td>
    <td>'.date('d-M-Y').'</td>
  </tr>
  ';
  $html.='</table>';

  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> Travel Expense Statement </p>';
  $html.='<hr>';
  $html.='<br>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid" style="border-bottom:solid 1px;">';
  $html.='<tr>';
  $html.='<th>Voucher Ref.</th>';
  $html.='<td>'.$r->DTE_VOUCHER_REF.'</td>';
  $html.='<th>Voucher Date</th>';
  $html.='<td>'.date("d-M-Y",strtotime($r->DTE_VOUCHER_DATE)).' </td>';
  $html.='</tr>';
  $html.='<tr>';
  $html.='<th>Departed Date</th>';
  $html.='<td>'.date("d-M-Y",strtotime($r->DTE_DEPARTED_DATE)).'</td>';
  $html.='<th>Returned Date</th>';
  $html.='<td>'.date("d-M-Y",strtotime($r->DTE_RETURNED_DATE)).' </td>';
  $html.='</tr>';
  $html.='<tr>';
  $html.='<th>Engineer Name</th>';
  $html.='<td>'.$r->DEM_EMP_NAME_PREFIX." ".$r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME." (".$r->DEM_EMP_ID.")".'</td>';
  $html.='<th>Location</th>';
  $html.='<td>'.$r->DTE_LOCATION.' </td>';
  $html.='</tr>';
  $html.='</table>';

  $html.='<p>Travelling Details</p>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid" style="border-top:solid 1px;">
  <thead>
    <tr>
      <th>Sr. No.</th>
      <th> Date</th>
      <th> Place</th>      
      <th> Travel</th>
      <th> Conveyance</th>
      <th> L/B</th>
      <th> Extra</th>
      <th> Total</th>
      <th> Remarks</th>
    </tr>  
  </thead>
  <tbody>';
  if(isset($r)){
    $emp = 0;
    $json = json_decode($r->DTE_TRAVEL_SUMMARY);
    if($json)
    {
      $travel_total = $conveyance_total = $lb_total = $extra_total = $subtotal = 0;
      for ($i=0; $i < count($json->JOURNEY_DATE); $i++)
      {
       
        $emp++;
        $html.='<tr>'; 
        $html.='<td style="text-align:center;">'.$emp.'</td>'; 
        $html.='<td style="text-align:center;">'.date("d-M-Y",strtotime($json->JOURNEY_DATE[$i])).'</td>'; 
        $html.='<td style="text-align:center;">'.$json->JOURNEY_PLACE[$i].'</td>'; 

        $html.='<td class="text-center" style="text-align:center;">'.$json->TRAVEL_CHRG[$i].'</td>'; 
        $travel_total += $json->TRAVEL_CHRG[$i];

        $html.='<td class="text-center" style="text-align:center;">'.$json->CONVEY_CHRG[$i].'</td>'; 
        $conveyance_total += $json->CONVEY_CHRG[$i];

        $html.='<td class="text-center" style="text-align:center;">'.$json->L_B_CHRG[$i].'</td>'; 
        $lb_total += $json->L_B_CHRG[$i];  

        $html.='<td class="text-center" style="text-align:center;">'.$json->EXTRA_CHRG[$i].'</td>'; 
        $extra_total += $json->EXTRA_CHRG[$i]; 


        $html.='<td class="text-center" style="text-align:center;">'.$json->TOTAL_CHRG[$i].'</td>'; 
        $subtotal += $json->TOTAL_CHRG[$i];  
        
        $html.='<td>'.$json->REMARKS[$i].'</td>';
        $html.='</tr>';

        $rc++;
        $cnt++;
                 
      }  
    }
      
    $html.='</tbody>';

    $html.='<tfoot>';
    $html.='<tr>';  
    $html.='<th colspan="3" class="text-right" style="text-align:right;">Total</th>';  
    $html.='<th class="text-center" style="text-align:center;">'.$travel_total.'</th>';
    $html.='<th class="text-center" style="text-align:center;">'.$conveyance_total.'</th>';
    $html.='<th class="text-center" style="text-align:center;">'.$lb_total.'</th>';
    $html.='<th class="text-center" style="text-align:center;">'.$extra_total.'</th>';
    $html.='<th class="text-center" style="text-align:center;">'.$subtotal.'</th>';
    $html.='<th></th>';
    $html.='</tr>';
    $html.='</tfoot>';
    $html.='</table>';

    $html.='<br>';

    $html.='<table id="example1" class="table" style="border:none !important;">';
    $html.='<tr>';
    $html.='<th colspan="2" style="border:none !important;"></th>';
    $html.='<th class="text-right" style="text-align:right;border:none !important;"> Grand Total</th>';
    $html.='<th style="text-align:left;border:none !important;">'.$subtotal.'</th>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Signature</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Approved By</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Advance in Hand</th>';
    $html.='<th style="width:25%;border:none !important;">'.$r->DTE_ADVANCE_IN_HAND.'</th>';
    $html.='<th style="width:25%;text-align:right;border:none !important;">Place</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='</tr>';
    
    $html.='</table>';

  }
  $dompdf = new DOMPDF();  
  $dompdf->set_paper('a4', 'landscape');  
  $dompdf->load_html($html);
  $dompdf->render();
  $pdf = $dompdf->output();

  $fp = fopen("reports/travel_expense_report.pdf", 'w');
  fclose($fp);
  chmod("reports/travel_expense_report.pdf", 0777); 
  file_put_contents("reports/travel_expense_report.pdf", $pdf);  
  
  header('location:download.php?file_url=reports/travel_expense_report.pdf');
  echo('<script>window.open("'.site_root.'reports/travel_expense_report.pdf", "_blank","",true);</script>');
  


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



