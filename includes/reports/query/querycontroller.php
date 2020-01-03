<?php

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

// Generate Exceel for Detailed Attendance

if(isset($_GET['DEM_EMP_ID']) && isset($_GET['expxlselect_attd_month']))
{
  extract($_GET);
  // prnt($_GET);
  include_once('PHPExcel.php');
  $objPHPExcel = new PHPExcel();

  $datearray = explode("-",$expxlselect_attd_month);
  $fulldate = date('F-Y',strtotime($expxlselect_attd_month));
  if($_SESSION['user_type']=="2"){
    $r=$db->get_results("SELECT * FROM dw_employee_master WHERE DEM_EMP_ID='".$_GET['DEM_EMP_ID']."'");  
  }else{
    $r=$db->get_results("SELECT * FROM dw_employee_master");
  }
  $countdays =  cal_days_in_month(CAL_GREGORIAN, $datearray[1], $datearray[0]);

  $objPHPExcel->setActiveSheetIndex(0);
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(6);

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "DAILY WAGES"); 
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Employee Attendance Report"); 
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

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "Sign"); 
  $coltitleCount++;

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

    $objPHPExcel->getActiveSheet()->setCellValue("A".$rc,$convdate)->getColumnDimension('A')->setAutoSize(true);
    

    $objPHPExcel->getActiveSheet()->setCellValue("B".$rc,$convday)->getColumnDimension('B')->setAutoSize(true);
    

    $DEA_IN_TIME = $getattd->DEA_IN_TIME!=''?$getattd->DEA_IN_TIME:'--';
    $objPHPExcel->getActiveSheet()->setCellValue("C".$rc,$DEA_IN_TIME)->getColumnDimension('C')->setAutoSize(true);
    

    $DEA_OUT_TIME = $getattd->DEA_OUT_TIME!=''?$getattd->DEA_OUT_TIME:'--';
    $objPHPExcel->getActiveSheet()->setCellValue("D".$rc,$DEA_OUT_TIME)->getColumnDimension('D')->setAutoSize(true);
    

    $DEA_CURRENT_LOCATION = $getattd->DEA_CURRENT_LOCATION!=''?$getattd->DEA_CURRENT_LOCATION:'--';
    $objPHPExcel->getActiveSheet()->setCellValue("E".$rc,$DEA_CURRENT_LOCATION)->getColumnDimension('E')->setAutoSize(true);
    

    $DEA_REMARK = $getattd->DEA_REMARK!=''?$getattd->DEA_REMARK:'--';
    $objPHPExcel->getActiveSheet()->setCellValue("F".$rc,$DEA_REMARK)->getColumnDimension('F')->setAutoSize(true);
    

    if(file_exists('images/user_sign/'.$getattd->DEM_EMPLOYEE_ID."_SIGN.jpg"))
    {
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setPath('images/user_sign/'.$getattd->DEM_EMPLOYEE_ID."_SIGN.jpg");
      $objDrawing->setCoordinates('G'.$rc);
      $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
      $objDrawing->setWidthAndHeight(70,120);
      $objDrawing->setResizeProportional(true);
      $objPHPExcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);

    }
    else
    {
      $objPHPExcel->getActiveSheet()->setCellValue('G'.$rc, '');
    }

    $rc++;
  } 

  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  chmod("dailywagesattd_report.xlsx", 0777);
  $objWriter->save('dailywagesattd_report.xlsx'); 
  header('location:download.php?file_url=dailywagesattd_report.xlsx');
  echo('<script>window.open("'.site_root.'dailywagesattd_report.xlsx", "_blank","",true);</script>');


  echo "<script>window.location='?folder=reports&file=emp_attd_detailed_single_month&DEM_EMP_ID=".$_GET['DEM_EMP_ID']."&select_attd_month=".$expxlselect_attd_month."';</script>";
}


// Generate Exceel for Payment Report

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
  $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex(18);

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "DAILY WAGES PAYMENT REPORT"); 
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

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coltitleCount, $rowtitleCount, "SIGN"); 
  $coltitleCount++;


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
    
    if(file_exists('images/user_sign/'.$payroll_det->DEM_EMP_ID."_SIGN.jpg"))
    {
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setPath('images/user_sign/'.$payroll_det->DEM_EMP_ID."_SIGN.jpg");
      $objDrawing->setCoordinates('S'.$rc);
      $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
      $objDrawing->setWidthAndHeight(70,120);
      $objDrawing->setResizeProportional(true);
      $objPHPExcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);

    }
    else
    {
      $objPHPExcel->getActiveSheet()->setCellValue('S'.$rc, '');
    }

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
  chmod("dailywagespay_report.xlsx", 0777);
  $objWriter->save('dailywagespay_report.xlsx'); 
  header('location:download.php?file_url=dailywagespay_report.xlsx');
  echo('<script>window.open("'.site_root.'dailywagespay_report.xlsx", "_blank","",true);</script>');


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

  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "DAILY WAGES"); 
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
  chmod("dailywagesattendance.xlsx", 0777);
  $objWriter->save('dailywagesattendance.xlsx'); 
  header('location:download.php?file_url=dailywagesattendance.xlsx');
  echo('<script>window.open("'.site_root.'dailywagesattendance.xlsx", "_blank","",true);</script>');

  // prnt($select_attd_month1);
// echo "<script>window.location='emp_attendance_monthly_report.php?attd=".$select_attd_month."';</script>";
}


?>



