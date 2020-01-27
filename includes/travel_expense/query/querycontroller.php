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

if(isset($_POST['SAVE_TRAVEL_EXP']) || isset($_POST['SAVE_LOCK_TRAVEL_EXP']))
{
  extract($_POST);
  prnt($_POST);
  

  $userid = $db->get_var("SELECT DEM_ID FROM dw_employee_master WHERE DEM_EMP_ID='$DEM_EMP_ID'");
  $getmaxtrid = $db->get_var("SELECT max(DTE_ID) FROM dw_travel_expense");
    
  if(date('M')>date('M',strtotime('March')))
  {
    $finyear = date('y').date('y',strtotime('+1 Years'));
  }else{
    $finyear = date('y',strtotime('-1 Years')).date('y');
  }
  $voucherref = "DE00".$userid.$finyear.$getmaxtrid."T";
  
  if(isset($_POST['SAVE_TRAVEL_EXP']))
  {
    $DTE_STATUS=1;
  }
  if(isset($_POST['SAVE_LOCK_TRAVEL_EXP']))
  {
    $DTE_STATUS=0;
  }
  
  $DTE_TRAVEL_SUMMARY = json_encode($DTE_TRAVEL_SUMMARY);
  
  if(isset($_GET['DTE_ID'])){
    $update_trexp = $db->query("UPDATE dw_travel_expense SET DEM_EMP_ID='$DEM_EMP_ID',DTE_VOUCHER_REF='$voucherref',DTE_VOUCHER_DATE='$DTE_VOUCHER_DATE',DTE_DEPARTED_DATE='$DTE_DEPARTED_DATE',DTE_RETURNED_DATE='$DTE_RETURNED_DATE',DTE_LOCATION='$DTE_LOCATION',DTE_TRAVEL_SUMMARY='$DTE_TRAVEL_SUMMARY',DTE_STATUS='$DTE_STATUS',DTE_UPDATED_DATE=NOW(),DTE_UPDATED_BY='".$_SESSION['ad_id']."' WHERE DTE_ID='".$_GET['DTE_ID']."'");

    if($update_trexp)
    {
      echo "<script> alert('Travel & Expense Updated Successfully..!'); window.location='?folder=travel_expense&file=travel_expense_list';</script>";
    }

  }else{
    $insert_trexp= $db->query("INSERT INTO dw_travel_expense (DEM_EMP_ID,DTE_VOUCHER_REF,DTE_VOUCHER_DATE,DTE_DEPARTED_DATE,DTE_RETURNED_DATE,DTE_LOCATION,DTE_TRAVEL_SUMMARY,DTE_CREATED_DATE,DTE_UPDATED_DATE,DTE_CREATED_BY,DTE_UPDATED_BY,DTE_STATUS) VALUES('$DEM_EMP_ID','$voucherref','$DTE_VOUCHER_DATE','$DTE_DEPARTED_DATE','$DTE_RETURNED_DATE','$DTE_LOCATION','$DTE_TRAVEL_SUMMARY',NOW(),NOW(),'".$_SESSION['ad_id']."','".$_SESSION['ad_id']."','$DTE_STATUS')"); 
    $db->debug();
    if($insert_trexp)
    {
      echo "<script> alert('Travel & Expense Saved Successfully..!'); window.location='?folder=travel_expense&file=travel_expense_list';</script>";
    }  

  }
  
}

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

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1,strtoupper($title->ins_name)); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Travelling Expense Statement".$headertitle);
  $objPHPExcel->getActiveSheet()->mergeCells("A1:".$adjustedColumn."1");
  $objPHPExcel->getActiveSheet()->mergeCells("A2:".$adjustedColumn."2");
  $objPHPExcel->getActiveSheet()->mergeCells("A3:".$adjustedColumn."3");
  
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

  if(isset($r)){
    $emp = 0;

    $rc=5;
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

    $objPHPExcel->getActiveSheet()->setCellValue("I".$rc," ");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    $objPHPExcel->getActiveSheet()->mergeCells("I".$rc.":".$adjustedColumn.$rc);

    $objPHPExcel->getActiveSheet()->setCellValue("J".$rc,"Grand Total");  
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(10);
    $objPHPExcel->getActiveSheet()->mergeCells("J".$rc.":".$adjustedColumn.$rc);
    $objPHPExcel->getActiveSheet()->setCellValue("L".$rc,$grand_subtotal);  

    $rc++;

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Signature");
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
    <td><center><h1 style="color:#9c4d55; font-size:22px; font-weight:900;">'.$title->ins_name.'</h1><center></td>
    <td>'.date('d/m/Y').'</td>
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
      <th> Engineer Name</th>
      <th> Place</th>
      <th> Voucher Date</th>
      <th> Voucher Ref.</th>
      <th> Date From</th>
      <th> Date to</th>
      <th> Travel</th>
      <th> Conveyance</th>
      <th> L/B</th>
      <th> Extra</th>
      <th> Total</th>
      <th> Status</th>
      <th> Paid Date</th>
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
      $html.='<td>'.$emp.'</td>'; 
      $html.='<td>'.$row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME.'</td>'; 
      $html.='<td>'.$row->DTE_LOCATION.'</td>'; 
      $html.='<td>'.date("d-M-Y",strtotime($row->DTE_VOUCHER_DATE)).'</td>'; 
      $html.='<td>'.$row->DTE_VOUCHER_REF.'</td>'; 
      $html.='<td>'.date("d-M-Y",strtotime($row->DTE_DEPARTED_DATE)).'</td>'; 
      $html.='<td>'.date("d-M-Y",strtotime($row->DTE_RETURNED_DATE)).'</td>'; 
   
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

      $html.='<td>'.$travel_total.'</td>'; 
      $html.='<td>'.$conveyance_total.'</td>'; 
      $html.='<td>'.$lb_total.'</td>'; 
      $html.='<td>'.$extra_total.'</td>'; 
      $html.='<td>'.$subtotal.'</td>'; 
      $html.='<td>'.$paystat.'</td>'; 
      $html.='<td>'.$DTE_PAID_DATE.'</td>'; 
      $html.='</tr>'; 
    }
    $html.='</tbody>';

    $html.='<tfoot>';
    $html.='<tr>';
    $html.='<th></th>';
    $html.='<th>Total</th>';
    $html.='<th></th>';
    $html.='<th></th>';
    $html.='<th></th>';
    $html.='<th></th>';
    $html.='<th></th>';
    $html.='<th>'.$grand_travel_total.'</th>';
    $html.='<th>'.$grand_conveyance_total.'</th>';
    $html.='<th>'.$grand_lb_total.'</th>';
    $html.='<th>'.$grand_extra_total.'</th>';
    $html.='<th>'.$grand_subtotal.'</th>';
    $html.='<th></th>';
    $html.='<th></th>';
    $html.='</tr>';
    $html.='</tfoot>';
    $html.='</table>';

    $html.='<table class="table table-bordered table-striped" role="grid">';
    $html.='<tr>';
    $html.='<th></th>';
    $html.='<th style="width:20%;"></th>';
    $html.='<th>Grand Total</th>';
    $html.='<th>'.$grand_subtotal.'</th>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th>Signature</th>';
    $html.='<th></th>';
    $html.='<th>Approved By</th>';
    $html.='<th></th>';
    $html.='</tr>'; 

    $html.='<tr>';
    $html.='<th>Place</th>';
    $html.='<th colspan="3"></th>';
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
    <td><center><h1 style="color:#9c4d55; font-size:22px; font-weight:900;">'.$title->ins_name.'</h1><center></td>
    <td>'.date('d/m/Y').'</td>
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
        $html.='<td>'.$emp.'</td>'; 
        $html.='<td>'.date("d-M-Y",strtotime($json->JOURNEY_DATE[$i])).'</td>'; 
        $html.='<td>'.$json->JOURNEY_PLACE[$i].'</td>'; 

        $html.='<td>'.$json->TRAVEL_CHRG[$i].'</td>'; 
        $travel_total += $json->TRAVEL_CHRG[$i];

        $html.='<td>'.$json->CONVEY_CHRG[$i].'</td>'; 
        $conveyance_total += $json->CONVEY_CHRG[$i];

        $html.='<td>'.$json->L_B_CHRG[$i].'</td>'; 
        $lb_total += $json->L_B_CHRG[$i];  

        $html.='<td>'.$json->EXTRA_CHRG[$i].'</td>'; 
        $extra_total += $json->EXTRA_CHRG[$i]; 


        $html.='<td>'.$json->TOTAL_CHRG[$i].'</td>'; 
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
    $html.='<th colspan="3">Total</th>';  
    $html.='<th>'.$travel_total.'</th>';
    $html.='<th>'.$conveyance_total.'</th>';
    $html.='<th>'.$lb_total.'</th>';
    $html.='<th>'.$extra_total.'</th>';
    $html.='<th>'.$subtotal.'</th>';
    $html.='<th></th>';
    $html.='</tr>';
    $html.='</tfoot>';
    $html.='</table>';

    $html.='<br>';

    $html.='<table id="example1" class="table table-bordered table-striped" role="grid" style="border-top:solid 1px;">';
    $html.='<tr>';
    $html.='<th colspan="2"></th>';
    $html.='<th> Grand Total</th>';
    $html.='<td>'.$subtotal.'</td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;">Signature</th>';
    $html.='<td style="width:25%;"></td>';
    $html.='<th style="width:25%;">Approved By</th>';
    $html.='<td style="width:25%;"></td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;">Advance in Hand</th>';
    $html.='<td style="width:25%;"></td>';
    $html.='<th style="width:25%;">Place</th>';
    $html.='<td style="width:25%;"></td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th colspan="2"></th>';   
    $html.='<th>Date</th>';
    $html.='<td></td>';
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

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1,strtoupper($title->ins_name)); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Travelling Expense Statement");
  $objPHPExcel->getActiveSheet()->mergeCells("A1:".$adjustedColumn."1");
  $objPHPExcel->getActiveSheet()->mergeCells("A2:".$adjustedColumn."2");
  $objPHPExcel->getActiveSheet()->mergeCells("A3:".$adjustedColumn."3");
  
  $objPHPExcel->getActiveSheet()->setCellValue("A4","Voucher Ref.");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A4:".$adjustedColumn."4");
    
  $objPHPExcel->getActiveSheet()->setCellValue("C4",$r->DTE_VOUCHER_REF);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C4:".$adjustedColumn."4");

  $objPHPExcel->getActiveSheet()->setCellValue("F4","Voucher Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F4:".$adjustedColumn."4");
  
  $objPHPExcel->getActiveSheet()->setCellValue("H4",date("d-M-Y",strtotime($r->DTE_VOUCHER_DATE)));
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H4:".$adjustedColumn."4");
  
  $objPHPExcel->getActiveSheet()->setCellValue("A5","Departed Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A5:".$adjustedColumn."5");
    
  $objPHPExcel->getActiveSheet()->setCellValue("C5",date("d-M-Y",strtotime($r->DTE_DEPARTED_DATE)));
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C5:".$adjustedColumn."5");

  $objPHPExcel->getActiveSheet()->setCellValue("F5","Returned Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F5:".$adjustedColumn."5");
  
  $objPHPExcel->getActiveSheet()->setCellValue("H5",date("d-M-Y",strtotime($r->DTE_RETURNED_DATE)));
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H5:".$adjustedColumn."5");

  $objPHPExcel->getActiveSheet()->setCellValue("A6","Engineer Name");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A6:".$adjustedColumn."6");

  $objPHPExcel->getActiveSheet()->setCellValue("C6",$r->DEM_EMP_NAME_PREFIX." ".$r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME." (".$r->DEM_EMP_ID.")");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C6:".$adjustedColumn."6");

  $objPHPExcel->getActiveSheet()->setCellValue("F6","Location");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F6:".$adjustedColumn."6");
  
  $objPHPExcel->getActiveSheet()->setCellValue("H6",$r->DTE_LOCATION);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H6:".$adjustedColumn."6");

  $objPHPExcel->getActiveSheet()->setCellValue("A7","Travelling Details");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("A7:".$adjustedColumn."7");
  
  $objPHPExcel->getActiveSheet()->setCellValue("A8","Sr. No.")->getColumnDimension('A')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("B8","Date")->getColumnDimension('B')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("C8","Place")->getColumnDimension('C')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("D8","Travel")->getColumnDimension('D')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("E8","Conveyance")->getColumnDimension('E')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("F8","L/B")->getColumnDimension('F')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("G8","Extra")->getColumnDimension('G')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("H8","Total")->getColumnDimension('H')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("I8","Remarks")->getColumnDimension('I')->setAutoSize(true);

 
  $rc=9;  

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
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(5);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);

  $objPHPExcel->getActiveSheet()->setCellValue("G".$rc,"Grand Total");  
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(7);
  $objPHPExcel->getActiveSheet()->mergeCells("G".$rc.":".$adjustedColumn.$rc);
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,$subtotal);  

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

  $objPHPExcel->getActiveSheet()->setCellValue("G".$rc,"Place");  
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(7);
  $objPHPExcel->getActiveSheet()->mergeCells("G".$rc.":".$adjustedColumn.$rc);
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");  

  $rc++;

  $objPHPExcel->getActiveSheet()->setCellValue("G".$rc,"Date");  
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(7);
  $objPHPExcel->getActiveSheet()->mergeCells("G".$rc.":".$adjustedColumn.$rc);
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,date('d-M-Y',strtotime($r->DTE_VOUCHER_DATE)));  

  $rc++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Advance in Hand");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(2);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);
  $objPHPExcel->getActiveSheet()->setCellValue("D".$rc," ");
  
 
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
  $addpayment = $db->query("UPDATE dw_travel_expense SET DTE_PAYMENT_STATUS='$DTE_PAYMENT_STATUS',DTE_PAID_DATE='$DTE_PAID_DATE' WHERE DTE_ID='$DTE_ID'");
  if($addpayment)
  {
    echo "<script>alert('Payment Status Added Successfully..!'); window.location='index.php?folder=travel_expense&file=travel_expense_list';</script>";
  }
}




?>



