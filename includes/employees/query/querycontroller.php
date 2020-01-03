<?php
  
// Add / Edit Employee


if (isset($_POST['save_user'])) 
{  
  extract($_POST);
  $profile = $_FILES['profile']['name'];   
  $sign = $_FILES['sign']['name'];   

  if (isset($_GET['edit_user']) && $_GET['edit_user']!='')
  {

    $DEM_EMP_ID=$_GET['edit_user'];
    $user_update = $db->query("UPDATE dw_employee_master SET DEM_EMP_NAME_PREFIX='$DEM_EMP_NAME_PREFIX', DEM_EMP_FIRST_NAME='$DEM_EMP_FIRST_NAME',DEM_EMP_MIDDLE_NAME='$DEM_EMP_MIDDLE_NAME',DEM_EMP_LAST_NAME='$DEM_EMP_LAST_NAME',DEM_EMP_GENDER='$DEM_EMP_GENDER', DEM_EMP_DOB ='$DEM_EMP_DOB',DEM_EMP_AGE='$DEM_EMP_AGE',DEM_PERMANENT_ADDRESS='$DEM_PERMANENT_ADDRESS',DEM_PA_PINCODE='$DEM_PA_PINCODE',DEM_CURRRENT_ADDRESS='$DEM_CURRRENT_ADDRESS',DEM_CA_PINCODE='$DEM_CA_PINCODE',DEM_MOBILE_NUMBER='$DEM_MOBILE_NUMBER',DEM_ALTERNATE_MOBILE_NUMBER='$DEM_ALTERNATE_MOBILE_NUMBER',DEM_PERSONAL_EMAIL_ID='$DEM_PERSONAL_EMAIL_ID',DEM_OFFICIAL_EMAIL_ID='$DEM_OFFICIAL_EMAIL_ID',DEM_START_DATE='$DEM_START_DATE',DEM_END_DATE='$DEM_END_DATE',DEM_ACTIVE_FLAG='$DEM_ACTIVE_FLAG',DEM_LAST_UPDATED_BY='".$_SESSION['ad_id']."' WHERE DEM_EMP_ID ='".$DEM_EMP_ID."'");


    $user_update_cred = $db->query("UPDATE dw_user_login SET DUL_USER_NAME='$DUL_USER_NAME', DUL_USER_PASSWORD='$DUL_USER_PASSWORD',DUL_USER_ROLE='$DUL_USER_ROLE',DUL_LAST_UPDATED_BY='".$_SESSION['ad_id']."' WHERE DEM_EMP_ID ='".$DEM_EMP_ID."'");

    $getpayroldet = $db->get_row("SELECT * FROM dw_payroll_master WHERE DPM_RATE='$DPM_RATE' AND DPM_BASIC_SALARY='$DPM_BASIC_SALARY' AND DPM_VALID_FROM='$DPM_VALID_FROM' AND DPM_VALID_TO='$DPM_VALID_TO' AND DPM_HRA='$DPM_HRA' AND DPM_OTHER_ALLOWANCE='$DPM_OTHER_ALLOWANCE' AND DPM_SPECIAL_ALLOWANCE='$DPM_SPECIAL_ALLOWANCE' AND DPM_GROSS_WAGES_PAYABLE='$DPM_GROSS_WAGES_PAYABLE' AND DPM_PROFESSIONAL_TAX='$DPM_PROFESSIONAL_TAX' AND DPM_PF_EMPLOYEE='$DPM_PF_EMPLOYEE' AND DPM_PF_EMPLOYER='$DPM_PF_EMPLOYER' AND DPM_ESIC_EMPLOYEE='$DPM_ESIC_EMPLOYEE' AND DPM_ESIC_EMPLOYER='$DPM_ESIC_EMPLOYER' AND DPM_CALCULATED_AMOUNT='$DPM_CALCULATED_AMOUNT' AND DEM_EMP_ID='".$DEM_EMP_ID."'");    
    
    if($getpayroldet){

    }else{
      $insert_payrole_history = $db->query("INSERT INTO dw_payroll_history VALUES('',NOW(),'".$_SESSION['ad_id']."',NOW(),'".$_SESSION['ad_id']."','$DPM_RATE','$DPM_VALID_FROM','$DPM_VALID_TO','$DPM_BASIC_SALARY','$DPM_HRA','$DPM_OTHER_ALLOWANCE','$DPM_SPECIAL_ALLOWANCE','$DPM_GROSS_WAGES_PAYABLE','$DPM_PROFESSIONAL_TAX','$DPM_PF_EMPLOYEE','$DPM_PF_EMPLOYER','$DPM_ESIC_EMPLOYEE','$DPM_ESIC_EMPLOYER','$DPM_CALCULATED_AMOUNT','$DEM_EMP_ID','$user_id')");
    
    }

    $update_payrole = $db->query("UPDATE dw_payroll_master SET DPM_LAST_UPDATED_BY='".$_SESSION['ad_id']."', DPM_RATE='$DPM_RATE',DPM_BASIC_SALARY='$DPM_BASIC_SALARY',DPM_VALID_FROM='$DPM_VALID_FROM',DPM_VALID_TO='$DPM_VALID_TO',DPM_HRA='$DPM_HRA',DPM_OTHER_ALLOWANCE='$DPM_OTHER_ALLOWANCE',DPM_SPECIAL_ALLOWANCE='$DPM_SPECIAL_ALLOWANCE',DPM_GROSS_WAGES_PAYABLE='$DPM_GROSS_WAGES_PAYABLE',DPM_PROFESSIONAL_TAX='$DPM_PROFESSIONAL_TAX',DPM_PF_EMPLOYEE='$DPM_PF_EMPLOYEE',DPM_PF_EMPLOYER='$DPM_PF_EMPLOYER',DPM_ESIC_EMPLOYEE='$DPM_ESIC_EMPLOYEE',DPM_ESIC_EMPLOYER='$DPM_ESIC_EMPLOYER',DPM_CALCULATED_AMOUNT='$DPM_CALCULATED_AMOUNT' WHERE DEM_EMP_ID ='".$DEM_EMP_ID."'");


    if($user_update)
    {
      include_once('./private/class.upload.php');
      $id = $DEM_EMP_ID;
      if($profile!='')
      {
        // Uploading the profile picture
        $path = "./images/user_profile/";
        $user_profile=$id.".jpg";
        $file="./images/user_profile/".$user_profile;
        if(file_exists($file))
        {
          unlink($file);
        }
        $pro = new Upload($_FILES['profile']);

        if ($pro->uploaded) 
        {
          $pro->file_new_name_body = $id;      
          $pro->image_convert = 'jpg';
          $pro->Process($path);
          if ($pro->processed)
          {
            
          } 
          else 
          {
            echo 'Error1: ' . $pro->error;
          }
        } 
        else 
        {
          echo 'Error1: ' . $pro->error;  
        }
      }

      if($sign!='')
      {
        // Uploading the profile picture
        $path = "./images/user_sign/";
        $user_sign=$id."_SIGN.jpg";
        $file="./images/user_sign/".$user_sign;
        if(file_exists($file))
        {
          unlink($file);
        }
        $pro = new Upload($_FILES['sign']);

        if ($pro->uploaded) 
        {
          $pro->file_new_name_body = $id."_SIGN";      
          $pro->image_convert = 'jpg';
          $pro->Process($path);
          if ($pro->processed)
          {
            
          } 
          else 
          {
            echo 'Error1: ' . $pro->error;
          }
        } 
        else 
        {
          echo 'Error1: ' . $pro->error;  
        }
      }
      global  $succ;
      // $succ= "Employee Details Update Successfully...!";
      // header("Refresh:1.0; url=index.php?folder=employees&file=employee_list");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong...!";      
    }
  }
  else
  {
    $user_insert=$db->query("INSERT INTO dw_employee_master values('','','$DEM_EMP_NAME_PREFIX','$DEM_EMP_FIRST_NAME','$DEM_EMP_MIDDLE_NAME','$DEM_EMP_LAST_NAME','$DEM_EMP_GENDER','$DEM_EMP_DOB','$DEM_EMP_AGE','$DEM_PERMANENT_ADDRESS','$DEM_PA_PINCODE','$DEM_CURRRENT_ADDRESS','$DEM_CA_PINCODE','$DEM_MOBILE_NUMBER','$DEM_ALTERNATE_MOBILE_NUMBER','$DEM_PERSONAL_EMAIL_ID','$DEM_OFFICIAL_EMAIL_ID','$DEM_START_DATE','$DEM_END_DATE','$DEM_ACTIVE_FLAG',NOW(),'".$_SESSION['ad_id']."','','".$_SESSION['ad_id']."')");      
     
    if($user_insert)
    {
      $last_id = $db->insert_id;    
      $DEM_EMP_ID = "DW".date('ym').$last_id;
      $update_empid = $db->query("UPDATE dw_employee_master SET DEM_EMP_ID='$DEM_EMP_ID' WHERE DEM_ID='$last_id' ");
      $user_id = $db->insert_id;

      $insert_user = $db->query("INSERT INTO dw_user_login VALUES('','$DUL_USER_NAME','$DUL_USER_PASSWORD','$DUL_USER_ROLE','$DEM_EMP_ID',NOW(),'".$_SESSION['ad_id']."',NOW(),'".$_SESSION['ad_id']."','ACITVE')");

      $insert_payrole = $db->query("INSERT INTO dw_payroll_master VALUES('',NOW(),'".$_SESSION['ad_id']."',NOW(),'".$_SESSION['ad_id']."','$DPM_RATE','$DPM_VALID_FROM','$DPM_VALID_TO','$DPM_BASIC_SALARY','$DPM_HRA','$DPM_OTHER_ALLOWANCE','$DPM_SPECIAL_ALLOWANCE','$DPM_GROSS_WAGES_PAYABLE','$DPM_PROFESSIONAL_TAX','$DPM_PF_EMPLOYEE','$DPM_PF_EMPLOYER','$DPM_ESIC_EMPLOYEE','$DPM_ESIC_EMPLOYER','$DPM_CALCULATED_AMOUNT','$DEM_EMP_ID','$user_id')");

      $insert_payrole_history = $db->query("INSERT INTO dw_payroll_history VALUES('',NOW(),'".$_SESSION['ad_id']."',NOW(),'".$_SESSION['ad_id']."','$DPM_RATE','$DPM_VALID_FROM','$DPM_VALID_TO','$DPM_BASIC_SALARY','$DPM_HRA','$DPM_OTHER_ALLOWANCE','$DPM_SPECIAL_ALLOWANCE','$DPM_GROSS_WAGES_PAYABLE','$DPM_PROFESSIONAL_TAX','$DPM_PF_EMPLOYEE','$DPM_PF_EMPLOYER','$DPM_ESIC_EMPLOYEE','$DPM_ESIC_EMPLOYER','$DPM_CALCULATED_AMOUNT','$DEM_EMP_ID','$user_id')");

      


      include_once('./private/class.upload.php');
      $id = $DEM_EMP_ID;
      if($profile!='')
      {
        // Uploading the profile picture
        $path = "./images/user_profile/";
        $user_profile=$id.".jpg";
        $file="./images/user_profile/".$user_profile;
        if(file_exists($file))
        {
          unlink($file);
        }
        $pro = new Upload($_FILES['profile']);

        if ($pro->uploaded) 
        {
          $pro->file_new_name_body = $id;      
          $pro->image_convert = 'jpg';
          $pro->Process($path);
          if ($pro->processed)
          {
            
          } 
          else 
          {
            echo 'Error1: ' . $pro->error;
          }
        } 
        else 
        {
          echo 'Error1: ' . $pro->error;  
        }
      }

      if($sign!='')
      {
        // Uploading the profile picture
        $path = "./images/user_sign/";
        $user_sign=$id."_SIGN.jpg";
        $file="./images/user_sign/".$user_sign;
        if(file_exists($file))
        {
          unlink($file);
        }
        $pro = new Upload($_FILES['sign']);

        if ($pro->uploaded) 
        {
          $pro->file_new_name_body = $id;      
          $pro->image_convert = 'jpg';
          $pro->Process($path);
          if ($pro->processed)
          {
            
          } 
          else 
          {
            echo 'Error1: ' . $pro->error;
          }
        } 
        else 
        {
          echo 'Error1: ' . $pro->error;  
        }
      }
      global  $succ;
      $succ= "New Employee Added Successfully...!";
      header("Refresh:1.0; url=index.php?folder=employees&file=employee_list");
    }
    else
    { 
      global  $msg;
      $msg= "Something Went Wrong...!";      
    }
  }

  
}



if (isset($_GET['delete_user'])) 
{
    $dele_user = $_GET['delete_user'];
    
    $delete =$db->query("DELETE FROM dw_employee_master WHERE DEM_EMP_ID = '".$dele_user."'");
    $delete1 =$db->query("DELETE FROM dw_user_login WHERE DEM_EMP_ID = '".$dele_user."'");
    
    if ($delete) 
    {
      $file="./images/user_profile/".$delete->DEM_EMP_ID.'.jpg';
      $file1="./images/user_sign/".$delete->DEM_EMP_ID.'_SIGN.jpg';
      if(file_exists($file))
      {
        unlink($file);
      }

      if(file_exists($file1))
      {
        unlink($file1);
      }
      global  $succ;
      $succ= "Deleted Successfully...!";
      header("Refresh:1.0; url=index.php?folder=employees&file=employee_list");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong..!";  
      header("Refresh:1.0; url=index.php?folder=employees&file=employee_list");    
    }
    
}

if (isset($_GET['deactiveemp_id'])) 
{
  $deactiveemp_id=$_GET['deactiveemp_id'];
  
  $deactive_update22=$db->query("UPDATE dw_user_login SET DUL_ACTIVE_FLAG='INACTIVE' WHERE DEM_EMP_ID='".$deactiveemp_id."'");

  if($deactive_update)
  {
      global  $succ;
      $succ= "Employee is Deactivated Successfully...!";
      header("Refresh:1.0; url=index.php?folder=employees&file=employee_list");
  }
  else
  {
    global  $msg;
    $msg= "Something Went Wrong...!";
    header("Refresh:1.0; url=index.php?folder=employees&file=employee_list");
  }
}

if (isset($_GET['activeemp_id'])) 
{
  $activeemp_id=$_GET['activeemp_id'];  
  $active_update22=$db->query("UPDATE dw_user_login SET DUL_ACTIVE_FLAG='ACTIVE' WHERE DEM_EMP_ID='".$activeemp_id."'");
  

  if($active_update22)
  {
    global  $succ;
    $succ= "Employee is Activate Successfully...!";
    header("Refresh:1.0; url=index.php?folder=employees&file=employee_list");
  }
  else
  {
    global  $msg;
    $msg= "Something Went Wrong...!";
    header("Refresh:1.0; url=index.php?folder=employees&file=employee_list");
  }
}


if(isset($_POST['save_attd']) || isset($_POST['save_lock_attd']))
{
  extract($_POST);  
  // prnt($_POST);
  if(isset($_POST['save_attd'])){
    $lock_status = 1;
  } 

  if(isset($_POST['save_lock_attd'])){
    $lock_status = 0;
  }

  foreach ($_POST['DEA_IN_TIME'] as $key => $value) {    
     
    if(($DEA_IN_TIME[$key] && $DEA_OUT_TIME[$key] && $DEA_CURRENT_LOCATION[$key] && $DEA_SIGN[$key])!=''){
      
      $attdarray = explode("-",$attd_date[$key]);
      if($DEA_ID[$key]!=''){
        if($_SESSION['user_type']=='1'){
          $getattdrec= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ID='".$DEA_ID[$key]."'");
          if($getattdrec->DEA_STATUS==0){
            $newset =",DEA_STATUS='0'";
          }else{
            $newset =",DEA_STATUS='$lock_status'";
          }
          
          $filter = "DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ID='".$DEA_ID[$key]."'";  
        }else{
          $newset =",DEA_STATUS='$lock_status'";
          $filter = "DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ID='".$DEA_ID[$key]."' AND DEA_STATUS='1'";
        }
        $update1=$db->query("UPDATE dw_emp_attendance SET DEA_IN_TIME='$DEA_IN_TIME[$key]',DEA_OUT_TIME='$DEA_OUT_TIME[$key]',DEA_CURRENT_LOCATION='$DEA_CURRENT_LOCATION[$key]',DEA_SIGN='$DEA_SIGN[$key]',DEA_REMARK='$DEA_REMARK[$key]' $newset WHERE $filter");
        // $db->debug();       

      }
      else{
        $insert1=$db->query("INSERT INTO dw_emp_attendance (DEA_CREATION_DATE,DEA_CREATION_BY,DEA_LAST_UPDATED_DATE,DPT_LAST_UPDATED_BY,DEA_ATTD_DATE,DEA_ATTD_MONTH,DEA_ATTD_YEAR,DEA_IN_TIME,DEA_OUT_TIME,DEA_CURRENT_LOCATION,DEA_REMARK,DEA_SIGN,DEA_LATITUDE,DEA_LONGITUDE, DEA_STATUS, DEM_EMPLOYEE_ID) VALUES (NOW(),'".$_SESSION['ad_id']."',NOW(),'".$_SESSION['ad_id']."','$attd_date[$key]','$attdarray[1]','$attdarray[0]','$DEA_IN_TIME[$key]','$DEA_OUT_TIME[$key]','$DEA_CURRENT_LOCATION[$key]','$DEA_REMARK[$key]','$DEA_SIGN[$key]','','','$lock_status','".$DEM_EMP_ID."')");
        // $db->debug();        
      }
      if($insert1 || $update1)
      {
        global  $succ;
        if($lock_status==1){
          $succ= "Attendence Submitted Successfully..!";
        }
        if($lock_status==0){
          $succ= "Attendence Submitted & Locked Successfully..!";
        }
        // unset($_SESSION['toast_handler']);
        $_SESSION['toast_handler']['toast_disp']= 1;
        $_SESSION['toast_handler']['toast_status']="success";
        $_SESSION['toast_handler']['toast_msg']= $succ;
        if($_SESSION['user_type']=='1'){
          // header("Refresh:1.0; url=index.php?folder=employees&file=admin_take_employee_attendance&DEM_EMP_ID=$DEM_EMP_ID");
          echo "<script>alert('".$succ."'); window.location='index.php?folder=employees&file=admin_take_employee_attendance&DEM_EMP_ID=$DEM_EMP_ID';</script>";
        }else{
          // header("Refresh:1.0; url=index.php?folder=employees&file=employee_attendance_view");
          echo "<script>alert('".$succ."'); window.location='index.php?folder=employees&file=employee_attendance_view';</script>";
        }
     
      }
    }    
  }    
}



if(isset($_POST['PAYMENT_SUBMIT']))
{
  extract($_POST);
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";
  
  $attdarray = explode("-",$pay_month_year);
  if($_GET['DPT_ID']!=''){

    $update1=$db->query("UPDATE dw_payment_tracker SET DPT_LAST_UPDATED_BY='".$_SESSION['ad_id']."',DPT_PAYMENT_DATE='$DPT_PAYMENT_DATE',DPT_PAYMENT_MONTH='$attdarray[1]',DPT_PAYMENT_YEAR='$attdarray[0]',DPT_TOTAL_DAYS_WORKED='$DPT_TOTAL_DAYS_WORKED',DPT_TOTAL_GW_HRS='$DPT_TOTAL_GW_HRS',TOTAL_DEDUCTION='$TOTAL_DEDUCTION',DPT_NET_WAGES_PAID='$DPT_NET_WAGES_PAID',DPT_INVOICE_NO='$DPT_INVOICE_NO' WHERE DPT_ID='".$_GET['DPT_ID']."'");
    // $db->debug();
    if($update1)
    {
      global  $succ;
      echo "<script> alert('Payment Details Updated Successfully..!');</script>";
      echo "<script> window.location='index.php?folder=employees&file=payment_tracker_view&DEM_EMP_ID=".$DEM_EMP_ID."';</script>";
      header("Refresh:1.0; url=index.php?folder=employees&file=payment_tracker_view");
    } 

  }
  else{
    $insert1=$db->query("INSERT INTO dw_payment_tracker (DPT_CREATION_DATE,DPT_CREATED_BY,DPT_LAST_UPDATED_DATE,DPT_LAST_UPDATED_BY,DPT_PAYMENT_DATE,DPT_PAYMENT_MONTH,DPT_PAYMENT_YEAR,DPT_TOTAL_DAYS_WORKED,DPT_TOTAL_GW_HRS,TOTAL_DEDUCTION,DPT_NET_WAGES_PAID,DPT_INVOICE_NO,DPT_STATUS,DEM_EMP_ID) VALUES (NOW(),'".$_SESSION['ad_id']."',NOW(),'".$_SESSION['ad_id']."','$DPT_PAYMENT_DATE','$attdarray[1]','$attdarray[0]','$DPT_TOTAL_DAYS_WORKED','$DPT_TOTAL_GW_HRS','$TOTAL_DEDUCTION','$DPT_NET_WAGES_PAID','$DPT_INVOICE_NO','1','".$DEM_EMP_ID."')");
    // $db->debug();
    if($insert1)
    {
      global  $succ;
      $succ= "Payment Details Added Successfully..!";
      header("Refresh:1.0; url=index.php?folder=employees&file=payment_tracker_view");
    }
  }
    
}


?>



