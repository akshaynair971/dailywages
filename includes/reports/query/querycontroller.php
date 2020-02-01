<?php
$title =$db->get_row("SELECT * FROM general_setting WHERE gs_id=1");

function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+7 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
}


if(isset($_POST['rep_attd_sub_sin_mon']) || isset($_POST['rep_attd_sub_sin_cur_mon']))
{
  extract($_POST);
  if(isset($_POST['rep_attd_sub_sin_cur_mon'])){
    $select_attd_month = $curr_month_attd_date;
  }
  // $select_attd_month1= date("Y-m",strtotime($select_attd_month));
  // prnt($select_attd_month1);
  echo "<script>window.location='?folder=reports&file=emp_attd_single_month_list&select_attd_month=".$select_attd_month."';</script>";
}


// Get Weekly Report 

if(isset($_POST['get_weekly_attd_report']))
{
  extract($_POST);
  // prnt($_POST);
  echo "<script>window.location='?folder=reports&file=weeklyattd_emp_list&weekly_attd_year=".$weekly_attd_year."&weekly_attd_week=".$weekly_attd_week."';</script>";
}

// End Get Weekly Report

// Generate PDF for Detailed Weekly Attendance

if(isset($_GET['DEM_EMP_ID']) && isset($_GET['exppdf_weeklyattd']))
{
  extract($_GET);
  
  include_once('./dompdf/dompdf_config.inc.php');

  $r=$db->get_row("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$DEM_EMP_ID."'"); 
  $week_array = getStartAndEndDate($weekly_attd_week,$weekly_attd_year);
  $begin = new DateTime($week_array['week_start']);
  $end = new DateTime($week_array['week_end']);
  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

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

  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> Employee Attendance Report of '.'Week '.$weekly_attd_week.' - '.$weekly_attd_year.'</p>';
  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> '.strtoupper($r->DEM_EMP_FIRST_NAME.''.$r->DEM_EMP_MIDDLE_NAME.' '.$r->DEM_EMP_LAST_NAME).' ('.$r->DEM_EMP_ID.')</p>';
  $html.='<hr>';
  $html.='<br>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid">
  <thead>
    <tr>
      <th style="text-align:center;">Sr. No.</th>
      <th style="text-align:center;"> Attendance Date</th>
      <th style="text-align:center;"> Attendance Day</th>
      <th style="text-align:center;"> In Time</th>
      <th style="text-align:center;"> Out Time</th>
      <th style="text-align:center;"> Location</th>
      <th style="text-align:center;"> Remark</th>      
    </tr>  
  </thead>
  <tbody>';
   $emp = 0;
  foreach($daterange as $date1)
  {
    $emp++;
    $convdate = $date1->format("Y-m-d");
    $convday = date("D",strtotime($convdate));

    $getattd= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ATTD_DATE='$convdate'");
    $html.='<tr>';
    $html.='<td style="text-align:center;">'.$emp.'</td>'; 
    $html.='<td style="text-align:center;">'.date("d-M-Y",strtotime($convdate)).'</td>';
    $html.='<td style="text-align:center;">'.$convday.'</td>';

    if($getattd->DEA_IN_TIME!=''){
      $DEA_IN_TIME = $getattd->DEA_IN_TIME;
    }elseif($convday=="Sun"){ 
      $DEA_IN_TIME = "9:00 AM"; 
    }else{
      $DEA_IN_TIME ='--';
    }
    $html.='<td style="text-align:center;">'.$DEA_IN_TIME.'</td>';

    $DEA_OUT_TIME = '';
    // $DEA_OUT_TIME = $getattd->DEA_OUT_TIME!=''?$getattd->DEA_OUT_TIME:'--';
    if($getattd->DEA_OUT_TIME!=''){ if(date('h:i A',strtotime($getattd->DEA_OUT_TIME))< date('h:i A',strtotime("6:00 PM")) ){ $DEA_OUT_TIME = $getattd->DEA_OUT_TIME; }else{ $DEA_OUT_TIME= "6:00 PM"; } }elseif($convday=="Sun"){ $DEA_OUT_TIME= "6:00 PM"; }else{ $DEA_OUT_TIME = "--"; }

    $html.='<td style="text-align:center;">'.$DEA_OUT_TIME.'</td>';

    if($getattd->DEA_CURRENT_LOCATION!=''){
      $DEA_CURRENT_LOCATION = $getattd->DEA_CURRENT_LOCATION;
    }elseif($convday=="Sun"){ 
      $DEA_CURRENT_LOCATION = "WEEKLY OFF"; 
    }else{
      $DEA_CURRENT_LOCATION ='--';
    }
    $html.='<td style="text-align:center;">'.$DEA_CURRENT_LOCATION.'</td>';

    $DEA_REMARK = $getattd->DEA_REMARK!=''?$getattd->DEA_REMARK:'--';
    $html.='<td style="text-align:center;">'.$DEA_REMARK.'</td>';
    $html.='</tr>';
  }

  $html.='</tbody>';
  $html.='</table>';
  $html.='<br>';
  $html.='<table id="example1" class="table" style="border:none !important;">';
  $html.='<tr style="border:none !important;">';
  $html.='<td colspan="3" style="width:75%;text-align:right;border:none !important;">Signature:</td>';
  if(file_exists('images/user_sign/'.$DEM_EMP_ID."_SIGN.jpg"))
  {
    $html.='<td style="border:none !important;"><img src="images/user_sign/'.$DEM_EMP_ID.'_SIGN.jpg" style="width:100px;height:70px;"></td>';
  }
  else
  {
    $html.='<td></td>';    
  }
  $html.='</tr>';
  $html.='</table>';


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

// END Generate PDF for Detailed Weekly Attendance

// Generate Excel for Detailed Weekly Attendance

if(isset($_GET['DEM_EMP_ID']) && isset($_GET['expxl_weeklyattd']))
{
  extract($_GET);
  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  
  $r=$db->get_row("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$DEM_EMP_ID."'"); 

  $week_array = getStartAndEndDate($weekly_attd_week,$weekly_attd_year);
  
            
  $begin = new DateTime($week_array['week_start']);
  $end = new DateTime($week_array['week_end']);

  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);


  $objPHPExcel->setActiveSheetIndex(0);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(5);

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $title->ins_name); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Employee Attendance Report of "."Week ".$weekly_attd_week." - ".$weekly_attd_year );
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, strtoupper($r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME)." (".$r->DEM_EMP_ID.")" ); 
  $objPHPExcel->getActiveSheet()->mergeCells("A1:".$adjustedColumn."1");
  $objPHPExcel->getActiveSheet()->mergeCells("A2:".$adjustedColumn."2");
  $objPHPExcel->getActiveSheet()->mergeCells("A3:".$adjustedColumn."3");

  $rowtitleCount = 4;
  $coltitleCount = 0;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Attendance Date"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Attendance Day"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "In Time"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Out Time"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Location"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Remark"); 
  $coltitleCount++;

  // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Sign"); 
  // $coltitleCount++;

  $i=1;
  $rc=5;  

  foreach($daterange as $date1)
  {
    $convdate = $date1->format("Y-m-d");
    $convday = date("D",strtotime($convdate));
    $cc=0; 
    $getattd= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ATTD_DATE='$convdate'");
    

    $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,date("d-M-Y",strtotime($convdate)))->getColumnDimension('A')->setAutoSize(true);
    

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,$convday)->getColumnDimension('B')->setAutoSize(true);
    
    if($getattd->DEA_IN_TIME!=''){
      $DEA_IN_TIME = $getattd->DEA_IN_TIME;
    }elseif($convday=="Sun"){ 
      $DEA_IN_TIME = "9:00 AM"; 
    }else{
      $DEA_IN_TIME ='--';
    }
    $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$DEA_IN_TIME)->getColumnDimension('C')->setAutoSize(true);
    

    $DEA_OUT_TIME = '';
    // $DEA_OUT_TIME = $getattd->DEA_OUT_TIME!=''?$getattd->DEA_OUT_TIME:'--';
    if($getattd->DEA_OUT_TIME!=''){ if(date('h:i A',strtotime($getattd->DEA_OUT_TIME))< date('h:i A',strtotime("6:00 PM")) ){ $DEA_OUT_TIME = $getattd->DEA_OUT_TIME; }else{ $DEA_OUT_TIME= "6:00 PM"; } }elseif($convday=="Sun"){ 
      $DEA_OUT_TIME = "6:00 PM"; 
    }else{ $DEA_OUT_TIME = "--"; }
    $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,$DEA_OUT_TIME)->getColumnDimension('D')->setAutoSize(true);
    

    if($getattd->DEA_CURRENT_LOCATION!=''){
      $DEA_CURRENT_LOCATION = $getattd->DEA_CURRENT_LOCATION;
    }elseif($convday=="Sun"){ 
      $DEA_CURRENT_LOCATION = "WEEKLY OFF"; 
    }else{
      $DEA_CURRENT_LOCATION ='--';
    }
    $objPHPExcel->getActiveSheet()->setCellValue("E".$rc,$DEA_CURRENT_LOCATION)->getColumnDimension('E')->setAutoSize(true);
    

    $DEA_REMARK = $getattd->DEA_REMARK!=''?$getattd->DEA_REMARK:'--';
    $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,$DEA_REMARK)->getColumnDimension('F')->setAutoSize(true);
    

    
    $rc++;
  }
  $rc++;
  $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Signature");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(2);
  $objPHPExcel->getActiveSheet()->mergeCells("B".$rc.":".$adjustedColumn.$rc);

  if(file_exists('images/user_sign/'.$DEM_EMP_ID."_SIGN.jpg"))
  {
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setPath('images/user_sign/'.$DEM_EMP_ID."_SIGN.jpg");
    $objDrawing->setCoordinates('D'.$rc);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    $objDrawing->setWidthAndHeight(70,120);
    $objDrawing->setResizeProportional(true);
    $objPHPExcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);

  }
  else
  {
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$rc, '');
  }
 


  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod("attd_report.xlsx", 0777);
  $objWriter->save('attd_report.xlsx'); 
  header('location:download.php?file_url=attd_report.xlsx');
  echo('<script>window.open("'.site_root.'attd_report.xlsx", "_blank","",true);</script>');


  echo "<script>window.location='?folder=reports&file=emp_attd_detailed_weekly_report&DEM_EMP_ID=".$_GET['DEM_EMP_ID']."&weekly_attd_year=".$weekly_attd_year."&weekly_attd_week=".$weekly_attd_week."';</script>";
}
// End Generate Excel for Detailed Weekly Attendance


// Generate PDF for Detailed Monthly Attendance

if(isset($_GET['DEM_EMP_ID']) && isset($_GET['exppdfselect_attd_month']))
{
  extract($_GET);
  include_once('./dompdf/dompdf_config.inc.php');

  $datearray = explode("-",$exppdfselect_attd_month);
  $fulldate = date('F-Y',strtotime($exppdfselect_attd_month));
  $r=$db->get_row("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$DEM_EMP_ID."'"); 
  $countdays =  cal_days_in_month(CAL_GREGORIAN, $datearray[1], $datearray[0]);

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

  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> Employee Attendance Report of '.$fulldate.'</p>';
  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> '.strtoupper($r->DEM_EMP_FIRST_NAME.''.$r->DEM_EMP_MIDDLE_NAME.' '.$r->DEM_EMP_LAST_NAME).' ('.$r->DEM_EMP_ID.')</p>';
  $html.='<hr>';
  $html.='<br>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid">
  <thead>
    <tr>
      <th style="text-align:center;">Sr. No.</th>
      <th style="text-align:center;"> Attendance Date</th>
      <th style="text-align:center;"> Attendance Day</th>
      <th style="text-align:center;"> In Time</th>
      <th style="text-align:center;"> Out Time</th>
      <th style="text-align:center;"> Location</th>
      <th style="text-align:center;"> Remark</th>      
    </tr>  
  </thead>
  <tbody>';
  $emp = 0;
  for($cntd=1;$cntd<=$countdays;$cntd++)
  {

    $emp++;   
    $convdate = date("Y-m-d",strtotime($datearray[0]."-".$datearray[1]."-".$cntd));
    $convday = date("D",strtotime($datearray[0]."-".$datearray[1]."-".$cntd));

    $getattd= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ATTD_DATE='$convdate'");
    $html.='<tr>';
    $html.='<td style="text-align:center;">'.$emp.'</td>'; 
    $html.='<td style="text-align:center;">'.date("d-M-Y",strtotime($convdate)).'</td>';
    $html.='<td style="text-align:center;">'.$convday.'</td>';

    if($getattd->DEA_IN_TIME!=''){
      $DEA_IN_TIME = $getattd->DEA_IN_TIME;
    }elseif($convday=="Sun"){ 
      $DEA_IN_TIME = "9:00 AM"; 
    }else{
      $DEA_IN_TIME ='--';
    }
    $html.='<td style="text-align:center;">'.$DEA_IN_TIME.'</td>';

    $DEA_OUT_TIME = '';
    // $DEA_OUT_TIME = $getattd->DEA_OUT_TIME!=''?$getattd->DEA_OUT_TIME:'--';
    if($getattd->DEA_OUT_TIME!=''){ if(date('h:i A',strtotime($getattd->DEA_OUT_TIME))< date('h:i A',strtotime("6:00 PM")) ){ $DEA_OUT_TIME = $getattd->DEA_OUT_TIME; }else{ $DEA_OUT_TIME= "6:00 PM"; } }elseif($convday=="Sun"){ 
      $DEA_OUT_TIME = "6:00 PM"; 
    }else{ $DEA_OUT_TIME = "--"; }

    $html.='<td style="text-align:center;">'.$DEA_OUT_TIME.'</td>';

    if($getattd->DEA_CURRENT_LOCATION!=''){
      $DEA_CURRENT_LOCATION = $getattd->DEA_CURRENT_LOCATION;
    }elseif($convday=="Sun"){ 
      $DEA_CURRENT_LOCATION = "WEEKLY OFF"; 
    }else{
      $DEA_CURRENT_LOCATION ='--';
    }
    $html.='<td style="text-align:center;">'.$DEA_CURRENT_LOCATION.'</td>';

    $DEA_REMARK = $getattd->DEA_REMARK!=''?$getattd->DEA_REMARK:'--';
    $html.='<td style="text-align:center;">'.$DEA_REMARK.'</td>';
    $html.='</tr>';
  }

  $html.='</tbody>';
  $html.='</table>';
  $html.='<br>';
  $html.='<table id="example1" class="table" style="border:none !important;">';
  $html.='<tr style="border:none !important;">';
  $html.='<td colspan="3" style="width:75%;text-align:right;border:none !important;">Signature:</td>';
  if(file_exists('images/user_sign/'.$DEM_EMP_ID."_SIGN.jpg"))
  {
    $html.='<td style="border:none !important;"><img src="images/user_sign/'.$DEM_EMP_ID.'_SIGN.jpg" style="width:100px;height:70px;"></td>';
  }
  else
  {
    $html.='<td></td>';    
  }
  $html.='</tr>';
  $html.='</table>';


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
// Generate PDF for Detailed Monthly Attendance


// Generate Excel for Detailed Monthly Attendance

if(isset($_GET['DEM_EMP_ID']) && isset($_GET['expxlselect_attd_month']))
{
  extract($_GET);
  

  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  $datearray = explode("-",$expxlselect_attd_month);
  $fulldate = date('F-Y',strtotime($expxlselect_attd_month));
  $r=$db->get_row("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$DEM_EMP_ID."'"); 
  $countdays =  cal_days_in_month(CAL_GREGORIAN, $datearray[1], $datearray[0]);


  $objPHPExcel->setActiveSheetIndex(0);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(5);

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $title->ins_name); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Employee Attendance Report of ".strtoupper($r->DEM_EMP_FIRST_NAME." ".$r->DEM_EMP_MIDDLE_NAME." ".$r->DEM_EMP_LAST_NAME)." (".$r->DEM_EMP_ID.")" ); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, $fulldate ); 
  $objPHPExcel->getActiveSheet()->mergeCells("A1:".$adjustedColumn."1");
  $objPHPExcel->getActiveSheet()->mergeCells("A2:".$adjustedColumn."2");
  $objPHPExcel->getActiveSheet()->mergeCells("A3:".$adjustedColumn."3");

  $rowtitleCount = 4;
  $coltitleCount = 0;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Attendance Date"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Attendance Day"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "In Time"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Out Time"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Location"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Remark"); 
  $coltitleCount++;

  // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Sign"); 
  // $coltitleCount++;

  $i=1;
  $rc=5;  

  for($cntd=1;$cntd<=$countdays;$cntd++)
  {

    $cc=0;  

    $convdate = date("Y-m-d",strtotime($datearray[0]."-".$datearray[1]."-".$cntd));
    $convday = date("D",strtotime($datearray[0]."-".$datearray[1]."-".$cntd));
    $getattd= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ATTD_DATE='$convdate'");
    if($convdate>date("Y-m-d")){
      if($datearray[1]==date("m")){
        break;
      }else{
        echo "<h4>You cannot take the Attendance of future date..!</h4>";
        break;
      }
    }

    $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,date("d-M-Y",strtotime($convdate)))->getColumnDimension('A')->setAutoSize(true);
    

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,$convday)->getColumnDimension('B')->setAutoSize(true);
    
    if($getattd->DEA_IN_TIME!=''){
      $DEA_IN_TIME = $getattd->DEA_IN_TIME;
    }elseif($convday=="Sun"){ 
      $DEA_IN_TIME = "9:00 AM"; 
    }else{
      $DEA_IN_TIME ='--';
    }
    $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$DEA_IN_TIME)->getColumnDimension('C')->setAutoSize(true);
    

    $DEA_OUT_TIME = '';
    // $DEA_OUT_TIME = $getattd->DEA_OUT_TIME!=''?$getattd->DEA_OUT_TIME:'--';
    if($getattd->DEA_OUT_TIME!=''){ if(date('h:i A',strtotime($getattd->DEA_OUT_TIME))< date('h:i A',strtotime("6:00 PM")) ){ $DEA_OUT_TIME = $getattd->DEA_OUT_TIME; }else{ $DEA_OUT_TIME= "6:00 PM"; } }elseif($convday=="Sun"){ 
      $DEA_OUT_TIME = "6:00 PM"; 
    }else{ $DEA_OUT_TIME = "--"; }
    $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,$DEA_OUT_TIME)->getColumnDimension('D')->setAutoSize(true);
    
    if($getattd->DEA_CURRENT_LOCATION!=''){
      $DEA_CURRENT_LOCATION = $getattd->DEA_CURRENT_LOCATION;
    }elseif($convday=="Sun"){ 
      $DEA_CURRENT_LOCATION = "WEEKLY OFF"; 
    }else{
      $DEA_CURRENT_LOCATION ='--';
    }
    $objPHPExcel->getActiveSheet()->setCellValue("E".$rc,$DEA_CURRENT_LOCATION)->getColumnDimension('E')->setAutoSize(true);
    

    $DEA_REMARK = $getattd->DEA_REMARK!=''?$getattd->DEA_REMARK:'--';
    $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,$DEA_REMARK)->getColumnDimension('F')->setAutoSize(true);
    

    
    $rc++;
  }
  $rc++;
  $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,"Signature");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(2);
  $objPHPExcel->getActiveSheet()->mergeCells("B".$rc.":".$adjustedColumn.$rc);

  if(file_exists('images/user_sign/'.$DEM_EMP_ID."_SIGN.jpg"))
  {
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setPath('images/user_sign/'.$DEM_EMP_ID."_SIGN.jpg");
    $objDrawing->setCoordinates('D'.$rc);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    $objDrawing->setWidthAndHeight(70,120);
    $objDrawing->setResizeProportional(true);
    $objPHPExcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);

  }
  else
  {
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$rc, '');
  }
 


  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod("attd_report.xlsx", 0777);
  $objWriter->save('attd_report.xlsx'); 
  header('location:download.php?file_url=attd_report.xlsx');
  echo('<script>window.open("'.site_root.'attd_report.xlsx", "_blank","",true);</script>');


  echo "<script>window.location='?folder=reports&file=emp_attd_detailed_single_month&DEM_EMP_ID=".$_GET['DEM_EMP_ID']."&select_attd_month=".$expxlselect_attd_month."';</script>";
}
// ENd Generate Excel for Detailed Monthly Attendance


// Generate PDF for Payment Report

if(isset($_GET['exppdfselect_pay_month']))
{
  extract($_GET);
  include_once('./dompdf/dompdf_config.inc.php');

  $datearray = explode("-",$exppdfselect_pay_month);
  $fulldate = date('F-Y',strtotime($exppdfselect_pay_month));
  if($_SESSION['user_type']=="2"){
    $r=$db->get_results("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."'");  
  }else{
    $r=$db->get_results("SELECT * FROM dw_employee_master");
  }

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

  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> PAYMENT REPORT of '.$fulldate.'</p>';
  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> FORM II M.W. RULES 1963 Rule 27</p>';
  $html.='<hr>';
  $html.='<br>';

  $html.='<table id="example1" class="table table-bordered table-striped" role="grid">
  <thead>
    <tr>
      <th style="text-align:center;">Sr. No.</th>
      <th style="text-align:center;"> Employee Name</th>
      <th style="text-align:center;"> AGE</th>
      <th style="text-align:center;"> TOTAL DAYS WORKED</th>
      <th style="text-align:center;"> RATE</th>
      <th style="text-align:center;"> TOTAL GW HRS.</th>
      <th style="text-align:center;"> BASIC</th>      
      <th style="text-align:center;"> HRA</th>      
      <th style="text-align:center;"> OTHER ALLOWANCES</th>      
      <th style="text-align:center;"> GROSS WAGES PAYABLE</th>      
      <th style="text-align:center;"> PROFF. TAX</th>      
      <th style="text-align:center;"> P.F. 12%</th>      
      <th style="text-align:center;"> PF 12%</th>      
      <th style="text-align:center;"> ESIC .75%</th>      
      <th style="text-align:center;"> ESIC 3.25%</th>      
      <th style="text-align:center;"> TOTAL DEDUCTION</th>      
      <th style="text-align:center;"> NET WAGES PAID</th>      
      <th style="text-align:center;"> PAYMENT REFERANCE</th>      
    </tr>  
  </thead>
  <tbody>';
  $emp = 0;
  $basictotal = $hratotal = $otherallowancestotal = $grosswagespayabletotal = $proftaxtotal = $ep_pftotal = $er_pftotal = $ep_esictotal = $er_esictotal = $totaldeductionsum = $netwagespaidsum = $i = 0;
  foreach($r as $rw){
    $emp++;
    $payroll_det=$db->get_row("SELECT * FROM dw_payroll_master WHERE DEM_EMP_ID='$rw->DEM_EMP_ID'");
    $pay_track=$db->get_row("SELECT * FROM dw_payment_tracker WHERE DEM_EMP_ID='$rw->DEM_EMP_ID' AND DPT_PAYMENT_YEAR='".$datearray[0]."' AND DPT_PAYMENT_MONTH='".$datearray[1]."'");

    $html.='<tr>';
    $html.='<td style="text-align:center;">'.$emp.'</td>'; 
    $html.='<td style="text-align:center;">'.strtoupper($rw->DEM_EMP_NAME_PREFIX." ".$rw->DEM_EMP_FIRST_NAME." ".$rw->DEM_EMP_MIDDLE_NAME." ".$rw->DEM_EMP_LAST_NAME).'</td>';
    $html.='<td style="text-align:center;">'.$rw->DEM_EMP_AGE.'</td>';
    $html.='<td style="text-align:center;">'.$pay_track->DPT_TOTAL_DAYS_WORKED.'</td>';
    $html.='<td style="text-align:center;">'.$payroll_det->DPM_RATE.'</td>';
     $html.='<td style="text-align:center;">'.$pay_track->DPT_TOTAL_GW_HRS.'</td>';

    $html.='<td style="text-align:center;">'.$payroll_det->DPM_BASIC_SALARY.'</td>';
    $basictotal+= $payroll_det->DPM_BASIC_SALARY;

    $html.='<td style="text-align:center;">'.$payroll_det->DPM_HRA.'</td>';
    $hratotal += $payroll_det->DPM_HRA;

    $html.='<td style="text-align:center;">'.$payroll_det->DPM_OTHER_ALLOWANCE.'</td>';
    $otherallowancestotal += $payroll_det->DPM_OTHER_ALLOWANCE;

    $html.='<td style="text-align:center;">'.$payroll_det->DPM_GROSS_WAGES_PAYABLE.'</td>';
    $grosswagespayabletotal += $payroll_det->DPM_GROSS_WAGES_PAYABLE;

    $html.='<td style="text-align:center;">'.$payroll_det->DPM_PROFESSIONAL_TAX.'</td>';
    $proftaxtotal += $payroll_det->DPM_PROFESSIONAL_TAX;

    $html.='<td style="text-align:center;">'.$payroll_det->DPM_PF_EMPLOYEE.'</td>';
    $ep_pftotal += $payroll_det->DPM_PF_EMPLOYEE;

    $html.='<td style="text-align:center;">'.$payroll_det->DPM_PF_EMPLOYER.'</td>';
    $er_pftotal += $payroll_det->DPM_PF_EMPLOYER;

    $html.='<td >'.$payroll_det->DPM_ESIC_EMPLOYEE.'</td>';
    $ep_esictotal += $payroll_det->DPM_ESIC_EMPLOYEE;

    $html.='<td style="text-align:center;">'.$payroll_det->DPM_ESIC_EMPLOYER.'</td>';
    $er_esictotal += $payroll_det->DPM_ESIC_EMPLOYER;

    $html.='<td style="text-align:center;">'.$pay_track->TOTAL_DEDUCTION.'</td>';
    $totaldeductionsum += $pay_track->TOTAL_DEDUCTION;

    $html.='<td style="text-align:center;">'.$pay_track->DPT_NET_WAGES_PAID.'</td>';
    $netwagespaidsum += $pay_track->DPT_NET_WAGES_PAID;

    $html.='<td style="text-align:center;">'.$pay_track->DPT_INVOICE_NO.'</td>';
    $html.='</tr>';
  }

  $html.='</tbody>';
  $html.='<tfoot>';
  $html.='<tr>'; 
  $html.='<th colspan="6" style="text-align:right;">Total</th>';
  $html.='<th style="text-align:center;">'.$basictotal.'</th>';
  $html.='<th style="text-align:center;">'.$hratotal.'</th>';
  $html.='<th style="text-align:center;">'.$otherallowancestotal.'</th>';
  $html.='<th style="text-align:center;">'.$grosswagespayabletotal.'</th>';
  $html.='<th style="text-align:center;">'.$proftaxtotal.'</th>';
  $html.='<th style="text-align:center;">'.$ep_pftotal.'</th>';
  $html.='<th style="text-align:center;">'.$er_pftotal.'</th>';
  $html.='<th style="text-align:center;">'.$ep_esictotal.'</th>';
  $html.='<th style="text-align:center;">'.$er_esictotal.'</th>';
  $html.='<th style="text-align:center;">'.$totaldeductionsum.'</th>';
  $html.='<th style="text-align:center;">'.$netwagespaidsum.'</th>';
  $html.='<th style="text-align:center;"></th>';
  
  $html.='</tr>';
  $html.='</tfoot>';
  $html.='</table>';
  $html.='<br>';

  $html.='<table id="example1" class="table" style="border:none !important;">';
  $html.='<tr style="border:none !important;">';
  $pfchalan=$ep_pftotal + $er_pftotal;
  $html.='<td style="width:10%!important;border:none !important;">PF CHALLAN AMT:</td>';
  $html.='<td style="width:25%;text-align:left;border:none !important;">'.$pfchalan.'</td>';
  $html.='<td rowspan="3" style="width:25%;text-align:right;border:none !important;">Signature:</td>';
  
  $html.='<td rowspan="3" style="width:25%;border:none !important;"></td>';    
  
  $html.='</tr>';

  $html.='<tr style="border:none !important;">';
  $esicchalan=$ep_esictotal + $er_esictotal;
  $html.='<td style="border:none !important;">ESIC CHALLAN AMT:</td>';
  $html.='<td style="text-align:left;border:none !important;">'.$esicchalan.'</td>';
  
  $html.='</tr>';  
  
  $html.='<tr style="border:none !important;">';
  $totalchalan= $ep_pftotal + $er_pftotal + $ep_esictotal + $er_esictotal;
  $html.='<td style="border:none !important;">TOTAL AMT:</td>';
  $html.='<td style="text-align:left;border:none !important;">'.$totalchalan.'</td>';

  $html.='</tr>';  

  $html.='</table>';


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

}
// Generate PDF for Payment Report

// Generate Excel for Payment Report

if(isset($_GET['expxlselect_pay_month']))
{
  extract($_GET);
  // prnt($_GET);
  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  $datearray = explode("-",$expxlselect_pay_month);
  $fulldate = date('F-Y',strtotime($expxlselect_pay_month));
  if($_SESSION['user_type']=="2"){
    $r=$db->get_results("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."'");  
  }else{
    $r=$db->get_results("SELECT * FROM dw_employee_master");
  }

  $objPHPExcel->setActiveSheetIndex(0);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(17);

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $title->ins_name." PAYMENT REPORT"); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "FORM II M.W. RULES 1963 Rule 27"); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, $fulldate ); 
  $objPHPExcel->getActiveSheet()->mergeCells("A1:".$adjustedColumn."1");
  $objPHPExcel->getActiveSheet()->mergeCells("A2:".$adjustedColumn."2");
  $objPHPExcel->getActiveSheet()->mergeCells("A3:".$adjustedColumn."3");

  $rowtitleCount = 4;
  $coltitleCount = 0;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "SR. NO."); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "EMPLOYEE NAME"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "AGE"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "TOTAL DAYS WORKED"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "RATE"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "TOTAL GW HRS."); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "BASIC"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "HRA"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "OTHER ALLOWANCES"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "GROSS WAGES PAYABLE"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "PROFF. TAX"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "P.F. 12%"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "PF 12%"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "ESIC .75%"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "ESIC 3.25%"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "TOTAL DEDUCTION"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "NET WAGES PAID"); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "PAYMENT REFERANCE"); 
  $coltitleCount++;

  // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "SIGN"); 
  // $coltitleCount++;


  $i=1;
  $rc=5;  

  $basictotal = $hratotal = $otherallowancestotal = $grosswagespayabletotal = $proftaxtotal = $ep_pftotal = $er_pftotal = $ep_esictotal = $er_esictotal = $totaldeductionsum = $netwagespaidsum = $i = 0;

  foreach($r as $rw){

    $payroll_det=$db->get_row("SELECT * FROM dw_payroll_master WHERE DEM_EMP_ID='$rw->DEM_EMP_ID'");
    $pay_track=$db->get_row("SELECT * FROM dw_payment_tracker WHERE DEM_EMP_ID='$rw->DEM_EMP_ID' AND DPT_PAYMENT_YEAR='".$datearray[0]."' AND DPT_PAYMENT_MONTH='".$datearray[1]."'");
    // prnt($pay_track);
    // break;
    $i++;

    $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,$i)->getColumnDimension('A')->setAutoSize(true);    

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,strtoupper($rw->DEM_EMP_NAME_PREFIX." ".$rw->DEM_EMP_FIRST_NAME." ".$rw->DEM_EMP_MIDDLE_NAME." ".$rw->DEM_EMP_LAST_NAME))->getColumnDimension('B')->setAutoSize(true);    

    $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$rw->DEM_EMP_AGE)->getColumnDimension('C')->setAutoSize(true);    

    $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,$pay_track->DPT_TOTAL_DAYS_WORKED)->getColumnDimension('D')->setAutoSize(true);
    
    $objPHPExcel->getActiveSheet()->setCellValue("E".$rc,$payroll_det->DPM_RATE)->getColumnDimension('E')->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,$pay_track->DPT_TOTAL_GW_HRS)->getColumnDimension('F')->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->setCellValue("G".$rc,$payroll_det->DPM_BASIC_SALARY)->getColumnDimension('G')->setAutoSize(true);
    $basictotal+= $payroll_det->DPM_BASIC_SALARY;

    $objPHPExcel->getActiveSheet()->setCellValue("H".$rc,$payroll_det->DPM_HRA)->getColumnDimension('H')->setAutoSize(true);
    $hratotal += $payroll_det->DPM_HRA;

    $objPHPExcel->getActiveSheet()->setCellValue("I".$rc,$payroll_det->DPM_OTHER_ALLOWANCE)->getColumnDimension('I')->setAutoSize(true);
    $otherallowancestotal += $payroll_det->DPM_OTHER_ALLOWANCE;

    $objPHPExcel->getActiveSheet()->setCellValue("J".$rc,$payroll_det->DPM_GROSS_WAGES_PAYABLE)->getColumnDimension('J')->setAutoSize(true);
    $grosswagespayabletotal += $payroll_det->DPM_GROSS_WAGES_PAYABLE;

    $objPHPExcel->getActiveSheet()->setCellValue("K".$rc,$payroll_det->DPM_PROFESSIONAL_TAX)->getColumnDimension('K')->setAutoSize(true);
    $proftaxtotal += $payroll_det->DPM_PROFESSIONAL_TAX;

    $objPHPExcel->getActiveSheet()->setCellValue("L".$rc,$payroll_det->DPM_PF_EMPLOYEE)->getColumnDimension('L')->setAutoSize(true);
    $ep_pftotal += $payroll_det->DPM_PF_EMPLOYEE;

    $objPHPExcel->getActiveSheet()->setCellValue("M".$rc,$payroll_det->DPM_PF_EMPLOYER)->getColumnDimension('M')->setAutoSize(true);
    $er_pftotal += $payroll_det->DPM_PF_EMPLOYER;

    $objPHPExcel->getActiveSheet()->setCellValue("N".$rc,$payroll_det->DPM_ESIC_EMPLOYEE)->getColumnDimension('N')->setAutoSize(true);
    $ep_esictotal += $payroll_det->DPM_ESIC_EMPLOYEE;

    $objPHPExcel->getActiveSheet()->setCellValue("O".$rc,$payroll_det->DPM_ESIC_EMPLOYER)->getColumnDimension('O')->setAutoSize(true);
    $er_esictotal += $payroll_det->DPM_ESIC_EMPLOYER;

    $objPHPExcel->getActiveSheet()->setCellValue("P".$rc,$pay_track->TOTAL_DEDUCTION)->getColumnDimension('P')->setAutoSize(true);
    $totaldeductionsum += $pay_track->TOTAL_DEDUCTION;

    $objPHPExcel->getActiveSheet()->setCellValue("Q".$rc,$pay_track->DPT_NET_WAGES_PAID)->getColumnDimension('Q')->setAutoSize(true);
    $netwagespaidsum += $pay_track->DPT_NET_WAGES_PAID;

    $objPHPExcel->getActiveSheet()->setCellValue("R".$rc,$pay_track->DPT_INVOICE_NO)->getColumnDimension('R')->setAutoSize(true);
    
    

    $rc++;
  } 

  $objPHPExcel->getActiveSheet()->setCellValue('B'.$rc, "Total" );
  $objPHPExcel->getActiveSheet()->setCellValue('G'.$rc, $basictotal );
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$rc, $hratotal );
  $objPHPExcel->getActiveSheet()->setCellValue('I'.$rc, $otherallowancestotal );
  $objPHPExcel->getActiveSheet()->setCellValue('J'.$rc, $grosswagespayabletotal );
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$rc, $proftaxtotal);
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$rc, $ep_pftotal);
  $objPHPExcel->getActiveSheet()->setCellValue('M'.$rc, $er_pftotal);
  $objPHPExcel->getActiveSheet()->setCellValue('N'.$rc, $ep_esictotal);
  $objPHPExcel->getActiveSheet()->setCellValue('O'.$rc, $er_esictotal);
  $objPHPExcel->getActiveSheet()->setCellValue('P'.$rc, $totaldeductionsum);
  $objPHPExcel->getActiveSheet()->setCellValue('Q'.$rc, $netwagespaidsum);
  $rc = $rc+2;

  $objPHPExcel->getActiveSheet()->setCellValue('B'.$rc, "PF CHALAN AMT");
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$rc, "-");
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$rc, $ep_pftotal + $er_pftotal);
  

  $objPHPExcel->getActiveSheet()->setCellValue("I".$rc,"Signature");
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(8);
  $objPHPExcel->getActiveSheet()->mergeCells("I".$rc.":".$adjustedColumn.$rc);

  if(file_exists('images/user_sign/'.$payroll_det->DEM_EMP_ID."_SIGN.jpg"))
  {
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setPath('images/user_sign/'.$payroll_det->DEM_EMP_ID."_SIGN.jpg");
    $objDrawing->setCoordinates('J'.$rc);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    $objDrawing->setWidthAndHeight(70,120);
    $objDrawing->setResizeProportional(true);
    $objPHPExcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);

  }
  else
  {
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$rc, '');
  }


  $rc ++;

  $objPHPExcel->getActiveSheet()->setCellValue('B'.$rc, "ESIC CHALAN AMT");
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$rc, "-");
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$rc, $ep_esictotal + $er_esictotal);
  $rc ++;

  $objPHPExcel->getActiveSheet()->setCellValue('B'.$rc, "TOTAL AMT");
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$rc, "-");
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$rc, $ep_pftotal + $er_pftotal + $ep_esictotal + $er_esictotal);
  $rc ++;

  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod($title->ins_name." pay_report.xlsx", 0777);
  $objWriter->save($title->ins_name.' pay_report.xlsx'); 
  header('location:download.php?file_url='.$title->ins_name.' pay_report.xlsx');
  echo('<script>window.open("'.site_root.$title->ins_name.' pay_report.xlsx", "_blank","",true);</script>');


}





if(isset($_GET['gen_attd_xl']))
{
  
  extract($_GET);
  // prnt($_GET);  
  $sa_date = $attd;

  if(isset($_SESSION['DEM_EMP_ID']) && $_SESSION['user_type']=="2"){
    $r = $db->get_results("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."'");    
  }else{
    $r = $db->get_results("SELECT * FROM dw_employee_master");
  }
   
  $getdatearray=explode("-",$sa_date);
  $nod=cal_days_in_month(CAL_GREGORIAN,$getdatearray[1],$getdatearray[0]);
  include_once('PHPExcel.php');
  
  $objPHPExcel = new PHPExcel();
  $fulldate = date('F-Y',strtotime($sa_date));
 

  // $objPHPExcel = new PHPExcel();
  $objPHPExcel->setActiveSheetIndex(0);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($nod+2);

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $title->ins_name); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Employee Attendance Report"); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, $fulldate ); 
  $objPHPExcel->getActiveSheet()->mergeCells("A1:".$adjustedColumn."1");
  $objPHPExcel->getActiveSheet()->mergeCells("A2:".$adjustedColumn."2");
  $objPHPExcel->getActiveSheet()->mergeCells("A3:".$adjustedColumn."3");

  $rowtitleCount = 4;
  $coltitleCount = 0;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "S.N."); 
  $coltitleCount++;

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Employee Name"); 
  $coltitleCount++;

  for($dc=1;$dc<=$nod;$dc++){
    $weekname= date('D',strtotime($getdatearray[0]."-".$getdatearray[1]."-".$dc));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, $dc." (".$weekname.") "); 
    $coltitleCount++;
    
  }
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Total"); 
    $coltitleCount++;
  // $weekname; 

  $i=1;
  $rc=5;
  foreach($r as $rw)
  {
    $cc=0;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cc, $rc, $i); 
    $cc++;
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cc, $rc, strtoupper($rw->DEM_EMP_NAME_PREFIX." ".$rw->DEM_EMP_FIRST_NAME." ".$rw->DEM_EMP_MIDDLE_NAME." ".$rw->DEM_EMP_LAST_NAME)); 
    $cc++;
    $atcnt=0;
    for($dc=1;$dc<=$nod;$dc++){
      $newdate= date('Y-m-d',strtotime($getdatearray[0]."-".$getdatearray[1]."-".$dc));

      $attstatus = $db->get_results("SELECT * FROM dw_emp_attendance WHERE  DEM_EMPLOYEE_ID='$rw->DEM_EMP_ID' AND  DEA_ATTD_DATE='$newdate'");
      // $db->debug();
      $getstudentatt= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$rw->DEM_EMP_ID' AND DEA_ATTD_DATE='$newdate'");
      if($attstatus == FALSE)
      {
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cc, $rc,"-"); 
      }else{
        if($getstudentatt->DEA_CURRENT_LOCATION == "OFFICE" || $getstudentatt->DEA_CURRENT_LOCATION == "CUSTOMER SITE" )
        {
         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cc, $rc,"P"); 
         $atcnt++;
        }elseif($getstudentatt->DEA_CURRENT_LOCATION == "WEEKLY OFF"){
         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cc, $rc,"W"); 
         $atcnt++;
        }else{
         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cc, $rc,"A");  
        }
      }
      
      $cc++;    
    } 
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cc, $rc,$atcnt); 
    $cc++;     
    $rc++;

  }
  // $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Student Name');
 

  
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod($title->ins_name." attendance.xlsx", 0777);
  $objWriter->save($title->ins_name.'attendance.xlsx'); 
  header('location:download.php?file_url='.$title->ins_name.'attendance.xlsx');
  echo('<script>window.open("'.site_root.$title->ins_name.'attendance.xlsx", "_blank","",true);</script>');

  // prnt($select_attd_month1);
// echo "<script>window.location='emp_attendance_monthly_report.php?attd=".$select_attd_month."';</script>";
}


?>



