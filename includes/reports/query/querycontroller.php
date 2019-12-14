<?php

if(isset($_POST['rep_attd_sub_sin_mon']))
{
  extract($_POST);
  
  $select_attd_month1= date("Y-m",strtotime($select_attd_month));
  // prnt($select_attd_month1);
echo "<script>window.location='?folder=reports&file=emp_attd_single_month_list&select_attd_month=".$select_attd_month."';</script>";
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



