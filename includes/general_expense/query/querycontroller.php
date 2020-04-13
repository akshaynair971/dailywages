<?php
include_once 'num_to_word_converter.php';
$title =$db->get_row("SELECT * FROM general_setting WHERE gs_id=1");

// DELETE GENERAL EXPENSE
if(isset($_GET['DEL_DGE_ID']))
{
  extract($_GET);
  $delgxp= $db->query("DELETE FROM dw_general_expenses WHERE DGE_ID='$DEL_DGE_ID'");

  if($delgxp)
  {
    echo "<script> window.location='?folder=general_expense&file=general_expense_list';</script>";
  }
}

// END OF DELETE GENERAL EXPENSE


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
  $voucherref = $userid->DEM_EMP_ID.$finyear.$getmaxtrid."E";
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

if(isset($_GET['overall_gen_exp_xl']))
{
  extract($_GET);
  

  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  $filter='';

  if(empty($_GET['gexp_single_month']) && empty($_GET['gexp_start_date']) && empty($_GET['gexp_end_date']) && empty($_GET['DEM_ID']) && $_GET['expense_for']=="all")
  {
    $filter .= "";
  }
  else
  {
    $filter .= " WHERE";
  }
  if($_GET['gexp_single_month'])
  {
    $datearray = explode("-",$gexp_single_month);
    $filter .= " YEAR(a.DGE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DGE_VOUCHER_DATE)=$datearray[1] AND";
    $headertitle = " (Month ".date('M-Y',strtotime($gexp_single_month)).")";
  }
  if($_GET['gexp_start_date'] && $_GET['gexp_end_date'])
  {
    $filter .= " a.DGE_VOUCHER_DATE>'$gexp_start_date' AND a.DGE_VOUCHER_DATE<'$gexp_end_date' AND";
    $headertitle = " (From ".date('d-M-Y',strtotime($gexp_start_date))." To ".date('d-M-Y',strtotime($gexp_end_date)).")";
  }
  if($_GET['DEM_ID'])
  {
    $filter .= " a.DEM_ID = '".$DEM_ID."' AND";
  }
  $filter = rtrim($filter," AND");
  
  $filter .= " ORDER BY a.DGE_ID DESC";


  $r=$db->get_results("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_general_expenses as a LEFT JOIN dw_employee_master as b ON a.DEM_ID=b.DEM_ID $filter");
  // $db->debug();
  // die();

  $objPHPExcel->setActiveSheetIndex(0);  

  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(13);
  $rowtitleCount=1;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount,strtoupper($title->ins_name)); 
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount, $title->ins_address);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount, "General Expense Statement".$headertitle);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  
  $objPHPExcel->getActiveSheet()->setCellValue("A4","Sr No.")->getColumnDimension('A')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("B4","Engineer Code")->getColumnDimension('B')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("C4","Engineer Name")->getColumnDimension('C')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("D4","Voucher Ref.")->getColumnDimension('D')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("E4","Voucher Date")->getColumnDimension('E')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("F4","Invocie No.")->getColumnDimension('F')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("G4","Invoice Date")->getColumnDimension('G')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("H4","Location")->getColumnDimension('H')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("I4","Total")->getColumnDimension('I')->setAutoSize(true);
  $rowtitleCount++;

  if(isset($r)){
    $emp = 0;

    $rc=$rowtitleCount;
    $grand_subtotal = 0;
    foreach ($r as $row)
    {
      $emp++;

      $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,$emp)->getColumnDimension('A')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,$row->DEM_EMP_ID)->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME)->getColumnDimension('C')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,$row->DGE_VOUCHER_REF)->getColumnDimension('D')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("E".$rc,date("d-M-Y",strtotime($row->DGE_VOUCHER_DATE)))->getColumnDimension('E')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,$row->DGE_INVOICE_NO)->getColumnDimension('F')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("G".$rc,$row->DGE_LOCATION)->getColumnDimension('G')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,date("d-M-Y",strtotime($row->DGE_INVOICE_DATE)))->getColumnDimension('H')->setAutoSize(true);

      $json = json_decode($row->DGE_EXPENSE_SUMMARY);
      if($json)
      {    
        $subtotal = 0;
        
        for ($i=0; $i < count($json->DGE_ITEM); $i++)
        {
          $main_total = 0;  
          $subtotal += $json->DGE_AMOUNT[$i]; 
        }
        $grand_subtotal += $subtotal;
      }
      $objPHPExcel->getActiveSheet()->setCellValue("I".$rc,$subtotal)->getColumnDimension('I')->setAutoSize(true);

      $rc++;  
    }
    

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Total");
    $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(7);
    $objPHPExcel->getActiveSheet()->mergeCells("B".$rc.":".$adjustedColumn.$rc);
    $objPHPExcel->getActiveSheet()->setCellValue("I".$rc,$grand_subtotal);
    
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

    // $objPHPExcel->getActiveSheet()->setCellValue("I".$rc," ");
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    // $objPHPExcel->getActiveSheet()->mergeCells("I".$rc.":".$adjustedColumn.$rc);

    // $objPHPExcel->getActiveSheet()->setCellValue("J".$rc,"Grand Total");  
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(10);
    // $objPHPExcel->getActiveSheet()->mergeCells("J".$rc.":".$adjustedColumn.$rc);
    // $objPHPExcel->getActiveSheet()->setCellValue("L".$rc,$grand_subtotal);  

    // $rc++;

    // $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Signature");
    // $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
    // $objPHPExcel->getActiveSheet()->mergeCells("B".$rc.":".$adjustedColumn.$rc);
      
    // $objPHPExcel->getActiveSheet()->setCellValue("C".$rc," ");
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
    // $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

    // $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Approved By");
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
    // $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
    
    // $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    // $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

    // $rc++; 

    // $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Date");
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
    // $objPHPExcel->getActiveSheet()->mergeCells("B".$rc.":".$adjustedColumn.$rc);
      
    // $objPHPExcel->getActiveSheet()->setCellValue("C".$rc," ");
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
    // $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

    // $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Date");
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
    // $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
    
    // $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    // $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

    // $rc++;

    // $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Place");  
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
    // $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
    // $objPHPExcel->getActiveSheet()->setCellValue("G".$rc," ");  
    // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
    // $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);  
  }

  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod("general_expense_report.xlsx", 0777);
  $objWriter->save('general_expense_report.xlsx'); 
  header('location:download.php?file_url=general_expense_report.xlsx');
  echo('<script>window.open("'.site_root.'general_expense_report.xlsx", "_blank","",true);</script>');


  echo "<script>window.location='?folder=travel_expense&file=travel_expense_list';</script>";
}
// End of Generate Excel for Overall Expense

// Generate PDF for Overall Expense

if(isset($_GET['overall_gen_exp_pdf']))
{
  extract($_GET);
  
  include_once('./dompdf/dompdf_config.inc.php');

  $filter='';

  if(empty($_GET['gexp_single_month']) && empty($_GET['gexp_start_date']) && empty($_GET['gexp_end_date']) && empty($_GET['DEM_ID']) && $_GET['expense_for']=="all")
  {
    $filter .= "";
  }
  else
  {
    $filter .= " WHERE";
  }
  if($_GET['gexp_single_month'])
  {
    $datearray = explode("-",$gexp_single_month);
    $filter .= " YEAR(a.DGE_VOUCHER_DATE)=$datearray[0] AND MONTH(a.DGE_VOUCHER_DATE)=$datearray[1] AND";
    $headertitle = " (Month ".date('M-Y',strtotime($gexp_single_month)).")";
  }
  if($_GET['gexp_start_date'] && $_GET['gexp_end_date'])
  {
    $filter .= " a.DGE_VOUCHER_DATE>'$gexp_start_date' AND a.DGE_VOUCHER_DATE<'$gexp_end_date' AND";
    $headertitle = " (From ".date('d-M-Y',strtotime($gexp_start_date))." To ".date('d-M-Y',strtotime($gexp_end_date)).")";
  }
  if($_GET['DEM_ID'])
  {
    $filter .= " a.DEM_ID = '".$DEM_ID."' AND";
  }
  $filter = rtrim($filter," AND");
  
  $filter .= " ORDER BY a.DGE_ID DESC";

  $r=$db->get_results("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_general_expenses as a LEFT JOIN dw_employee_master as b ON a.DEM_ID=b.DEM_ID $filter");
  // $db->debug();
  // die();
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

  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> General Expense Statement '.$headertitle.'</p>';
  $html.='<hr>';
  $html.='<br>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid">
  <thead>
    <tr>
      <th>Sr. No.</th>
      <th style="text-align:center;"> Engineer Code</th>
      <th style="text-align:center;"> Engineer Name</th>
      <th style="text-align:center;"> Cash Voucher Ref.</th>
      <th style="text-align:center;"> Voucher Date</th>
      <th style="text-align:center;"> Invoice No.</th>
      <th style="text-align:center;"> Invoice Date</th>
      <th style="text-align:center;"> Location</th>
      <th style="text-align:center;"> Total</th>
    </tr>  
  </thead>
  <tbody>';
  if(isset($r)){
    $emp = 0;
    $grand_subtotal = 0;
    foreach ($r as $row)
    {
      $emp++;
      $html.='<tr>'; 
      $html.='<td style="text-align:center;">'.$emp.'</td>'; 
      $html.='<td style="text-align:center;">'.$row->DEM_EMP_ID.'</td>'; 
      $html.='<td style="text-align:center;">'.$row->DEM_EMP_NAME_PREFIX." ".$row->DEM_EMP_FIRST_NAME." ".$row->DEM_EMP_MIDDLE_NAME." ".$row->DEM_EMP_LAST_NAME.'</td>'; 
      $html.='<td style="text-align:center;">'.$row->DGE_VOUCHER_REF.'</td>'; 
      $html.='<td style="text-align:center;">'.date("d-M-Y",strtotime($row->DGE_VOUCHER_DATE)).'</td>'; 
      $html.='<td style="text-align:center;">'.$row->DGE_INVOICE_NO.'</td>'; 
      $html.='<td style="text-align:center;">'.date("d-M-Y",strtotime($row->DGE_INVOICE_DATE)).'</td>'; 
      $html.='<td style="text-align:center;">'.$row->DGE_LOCATION.'</td>'; 
         
      $json = json_decode($row->DGE_EXPENSE_SUMMARY);

      if($json)
      {    
        $subtotal = 0;
        
        for ($i=0; $i < count($json->DGE_ITEM); $i++)
        {          
          $subtotal += $json->DGE_AMOUNT[$i]; 
        }   
        $grand_subtotal += $subtotal;    
      }
      
      $html.='<td style="text-align:center;">'.$subtotal.'</td>';      
      $html.='</tr>'; 
    }
    $html.='</tbody>';

    $html.='<tfoot>';
    $html.='<tr>';
    // $html.='<th></th>';
    $html.='<th  style="text-align:right;" colspan="8">Total</th>';
  
    $html.='<th style="text-align:center;">'.$grand_subtotal.'</th>';
    
    $html.='</tr>';
    $html.='</tfoot>';
    $html.='</table>';

    // $html.='<table id="example1" class="table" style="border:none !important;">';
    // $html.='<tr>';
    // $html.='<th colspan="2" style="border:none !important;"></th>';
    // $html.='<th class="text-right" style="text-align:right;border:none !important;"> Grand Total</th>';
    // $html.='<th style="text-align:left;border:none !important;">'.$grand_subtotal.'</th>';
    // $html.='</tr>';

    // $html.='<tr>';
    // $html.='<th style="width:25%;text-align:right;border:none !important;">Signature</th>';
    // $html.='<td style="width:25%;border:none !important;"></td>';
    // $html.='<th style="width:25%;text-align:right;border:none !important;">Approved By</th>';
    // $html.='<td style="width:25%;border:none !important;"></td>';
    // $html.='</tr>';

    // $html.='<tr>';
    // $html.='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
    // $html.='<td style="width:25%;border:none !important;"></td>';
    // $html.='<th style="width:25%;text-align:right;border:none !important;">Date</th>';
    // $html.='<td style="width:25%;border:none !important;"></td>';
    // $html.='</tr>';

    // $html.='<tr>';
    // $html.='<th style="width:25%;text-align:right;border:none !important;"></th>';
    // $html.='<td style="width:25%;border:none !important;"></td>';
    // $html.='<th style="width:25%;text-align:right;border:none !important;">Place</th>';
    // $html.='<td style="width:25%;border:none !important;"></td>';
    // $html.='</tr>';
    
    // $html.='</table>';
    }

    $dompdf = new DOMPDF();  
    $dompdf->set_paper('a3', 'portrait');  
    $dompdf->load_html($html);
    $dompdf->render();
    $pdf = $dompdf->output();

    $fp = fopen("reports/general_expense_report.pdf", 'w');
    fclose($fp);
    chmod("reports/general_expense_report.pdf", 0777); 
    file_put_contents("reports/general_expense_report.pdf", $pdf);  
    
    header('location:download.php?file_url=reports/general_expense_report.pdf');
    echo('<script>window.open("'.site_root.'reports/general_expense_report.pdf", "_blank","",true);</script>');
  

  echo "<script>window.location='?folder=travel_expense&file=travel_expense_list';</script>";
}
// End of Generate PDF for Overall Attendance


// START Generate PDF for Detailed Attendance

if(isset($_GET['exppdfdge_id']))
{
  extract($_GET);
  include_once('./dompdf/dompdf_config.inc.php');

  $r=$db->get_row("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_general_expenses as a LEFT JOIN dw_employee_master as b ON a.DEM_ID=b.DEM_ID WHERE a.DGE_ID='$exppdfdge_id' ORDER BY a.DGE_ID DESC");
  // $db->debug();
  // die();

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

  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> General Expense Statement </p>';
  $html.='<hr>';
  $html.='<br>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid" style="border-bottom:solid 1px;">';

  $html.='<tr>';
  $html.='<th style="text-align:left;">Cash Voucher Ref.</th>';
  $html.='<td>'.$r->DGE_VOUCHER_REF.'</td>';
  $html.='<th style="text-align:left;">Voucher Date</th>';
  $html.='<td>'.date("d-M-Y",strtotime($r->DGE_VOUCHER_DATE)).' </td>';
  $html.='</tr>';

  $html.='<tr>';
  $html.='<th style="text-align:left;">Engineer Name</th>';
  $html.='<td>'.$r->DEM_EMP_NAME_PREFIX." ".$r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME." (".$r->DEM_EMP_ID.")".'</td>';
  $html.='<th style="text-align:left;">Location</th>';
  $html.='<td>'.$r->DGE_LOCATION.' </td>';
  $html.='</tr>'; 

  $html.='<tr>';
  $html.='<th style="text-align:left;">Invoice No.</th>';
  $html.='<td>'.$r->DGE_INVOICE_NO.'</td>';
  $html.='<th style="text-align:left;">Invoice Date</th>';
  $html.='<td>'.date("d-M-Y",strtotime($r->DGE_INVOICE_DATE)).' </td>';
  $html.='</tr>';
  
  $html.='</table>';

  $html.='<p>Expense Details</p>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid" style="border-top:solid 1px;">
  <thead>
    <tr>
      <th>Sr. No.</th>
      <th>Item</th>
      <th>Amount</th>
      <th>Remarks</th>
    </tr>  
  </thead>
  <tbody>';
  if(isset($r)){
    $emp = 0;
    $json = json_decode($r->DGE_EXPENSE_SUMMARY);
    if($json)
    {
      $subtotal = 0;
      for ($i=0; $i < count($json->DGE_ITEM); $i++)
      {
       
        $emp++;
        $html.='<tr>'; 
        $html.='<td style="text-align:center;">'.$emp.'</td>'; 
        $html.='<td style="text-align:center;">'.$json->DGE_ITEM[$i].'</td>'; 
        $html.='<td class="text-center" style="text-align:center;">'.$json->DGE_AMOUNT[$i].'</td>'; 
        $subtotal += $json->DGE_AMOUNT[$i];
        
        $html.='<td>'.$json->DGE_REMARKS[$i].'</td>';
        $html.='</tr>';

        $rc++;
        $cnt++;
                 
      }  
    }
      
    $html.='</tbody>';

    $html.='<tfoot>';
    $html.='<tr>';  
    $html.='<th colspan="2" class="text-right" style="text-align:right;">Total</th>'; 
    
    $html.='<th class="text-left" >'.$subtotal.'</th>';
    $html.='<th></th>';
    $html.='</tr>';
    $html.='</tfoot>';
    $html.='</table>';

    $html.='<br>';

    $html.='<table id="example1" class="table" style="border:none !important;">';
    $html.='<tr>';
    $html.='<th colspan="2" style="border:none !important;text-align:left;">Received with thanks from  '.$title->ins_name.' a sum of Rs. </th>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<th colspan="2" style="border:none !important;text-align:left;">Rupees in words: '.numberTowords($subtotal).'</th>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;text-align:left;border:none !important;">Approved By</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<th style="width:25%;text-align:left;border:none !important;">Received By</th>';
    $html.='<td style="width:25%;border:none !important;"></td>';
    $html.='</tr>';
    
    $html.='</table>';

  }
  $dompdf = new DOMPDF();  
  $dompdf->set_paper('a4', 'portrait');  
  $dompdf->load_html($html);
  $dompdf->render();
  $pdf = $dompdf->output();

  $fp = fopen("reports/general_expense_report.pdf", 'w');
  fclose($fp);
  chmod("reports/general_expense_report.pdf", 0777); 
  file_put_contents("reports/general_expense_report.pdf", $pdf);  
  
  header('location:download.php?file_url=reports/general_expense_report.pdf');
  echo('<script>window.open("'.site_root.'reports/general_expense_report.pdf", "_blank","",true);</script>');
  


}
// END Generate PDF for Detailed Attendance

// Generate Excel for Detailed Attendance

if(isset($_GET['expxldge_id']))
{
  extract($_GET);

  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  $r=$db->get_row("SELECT a.*,b.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_general_expenses as a LEFT JOIN dw_employee_master as b ON a.DEM_ID=b.DEM_ID WHERE a.DGE_ID='$expxldge_id' ORDER BY a.DGE_ID DESC");

  $objPHPExcel->setActiveSheetIndex(0);  

  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $rowtitleCount=1;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount,strtoupper($title->ins_name)); 
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount, $title->ins_address);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowtitleCount, "General Expense Statement");
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount); 
  $rowtitleCount++;

  
  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Cash Voucher Ref.");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
    
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rowtitleCount,$r->DGE_VOUCHER_REF);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rowtitleCount,"Voucher Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rowtitleCount,date("d-M-Y",strtotime($r->DGE_VOUCHER_DATE)));
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
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rowtitleCount,$r->DGE_LOCATION);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Invoice No.");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);

  $objPHPExcel->getActiveSheet()->setCellValue("C".$rowtitleCount,$r->DGE_INVOICE_NO);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  $objPHPExcel->getActiveSheet()->mergeCells("C".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);

  $objPHPExcel->getActiveSheet()->setCellValue("F".$rowtitleCount,"Invoice Date");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  $objPHPExcel->getActiveSheet()->mergeCells("F".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  
  $objPHPExcel->getActiveSheet()->setCellValue("H".$rowtitleCount,date("d-M-Y",strtotime($r->DGE_INVOICE_DATE)));
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("H".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  $rowtitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Expense Details");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rowtitleCount.":".$adjustedColumn.$rowtitleCount);
  $rowtitleCount++;

  
  $objPHPExcel->getActiveSheet()->setCellValue("A".$rowtitleCount,"Sr. No.")->getColumnDimension('A')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("B".$rowtitleCount,"Item")->getColumnDimension('B')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rowtitleCount,"Amount")->getColumnDimension('C')->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setCellValue("D".$rowtitleCount,"Remarks")->getColumnDimension('D')->setAutoSize(true);
  $rowtitleCount++;
 
  $rc=$rowtitleCount;  

  $json = json_decode($r->DGE_EXPENSE_SUMMARY);
  if($json)
  {
    $cnt=1;
    $subtotal = 0;
    for ($i=0; $i < count($json->DGE_ITEM); $i++)
    {
      $main_total = 0;      
      
      $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,$cnt)->getColumnDimension('A')->setAutoSize(true);

      $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,$json->DGE_ITEM[$i])->getColumnDimension('B')->setAutoSize(true);

      $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$json->DGE_AMOUNT[$i])->getColumnDimension('C')->setAutoSize(true);
      $subtotal += $json->DGE_AMOUNT[$i];                

      $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,$json->DGE_REMARKS[$i])->getColumnDimension('D')->setAutoSize(true);

      $rc++;
      $cnt++;
               
    }  
  }

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Total");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);
  $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$subtotal);
  $rc++;
  $rc++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Received with thanks from  ".$title->ins_name." a sum of Rs.");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);

  $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('B1:B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('H1:H'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $rc++;

  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Rupees in words: ".numberTowords($subtotal));
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);    
  $rc++;  
  $rc++; 


  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Approved By");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);

  $rc++;  
  $rc++;  



  $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Received By");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);

  $rc++;  
  $rc++;  


    
  // $objPHPExcel->getActiveSheet()->setCellValue("C".$rc," ");
  // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  // $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

  // $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Date");
  // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  // $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
  
  // $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
  // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  // $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

  // $rc++;

  // $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,"Advance in hand");
  // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(1);
  // $objPHPExcel->getActiveSheet()->mergeCells("A".$rc.":".$adjustedColumn.$rc);
    
  // $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$r->DTE_ADVANCE_IN_HAND);
  // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(4);
  // $objPHPExcel->getActiveSheet()->mergeCells("C".$rc.":".$adjustedColumn.$rc);

  // $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,"Place");
  // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);
  // $objPHPExcel->getActiveSheet()->mergeCells("F".$rc.":".$adjustedColumn.$rc);
  
  // $objPHPExcel->getActiveSheet()->setCellValue("H".$rc," ");
  // $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  // $objPHPExcel->getActiveSheet()->mergeCells("H".$rc.":".$adjustedColumn.$rc);

  // $rc++;

  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod("general_expense_report.xlsx", 0777);
  $objWriter->save('general_expense_report.xlsx'); 
  header('location:download.php?file_url=general_expense_report.xlsx');
  echo('<script>window.open("'.site_root.'general_expense_report.xlsx", "_blank","",true);</script>');


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



