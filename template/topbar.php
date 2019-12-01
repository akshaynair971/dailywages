<?php 
  $title =$db->get_row("SELECT * FROM general_setting WHERE inst_id='".$_SESSION['ad_id']."'");
  if($_SESSION['user_type']=="2")
  {
    $title1 =$db->get_row("SELECT a.DEM_EMP_ID,b.DEM_EMP_NAME_PREFIX,b.DEM_EMP_FIRST_NAME,b.DEM_EMP_MIDDLE_NAME,b.DEM_EMP_LAST_NAME FROM dw_user_login as a LEFT JOIN dw_employee_master as b ON a.DEM_EMP_ID=b.DEM_EMP_ID WHERE a.DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."'");
    // $db->debug(); 
    // prnt($title1);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (isset($title)){echo $title->ins_name;}   ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="shortcut icon" href="images/logo/<?php echo $title->ins_logo; ?>" onerror="this.src='images/err_logo.png'" class="user-image"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/jquery-ui.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap --> 
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  
  <link rel="stylesheet" href="bower_components/jquery-toast/jquery.toast.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="plugins/timepicker/mdtimepicker.css">
  <!-- <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css"> -->
  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
  
  <link href="plugins/select2/select2.css" rel="stylesheet" type="text/css" />
  
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/jquery-toast/jquery.toast.min.js"></script>


  <style type="text/css">
    .form-control 
    {
      border-radius: 8px !important;
    }
    .btn-round
    {
      border-radius: 15px !important;
    }
  </style>

</head>
<body class="hold-transition skin-blue sidebar-mini" >
<div class="wrapper">

 
<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?php if (isset($title)) {echo substr($title->ins_name,0,1);}  ?></b></span>

      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php if (isset($title)) {echo $title->ins_name;} else{ echo $title1->user_name; } ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span> 
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          
          <!-- Tasks: style can be found in dropdown.less -->

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <img src="<?php if($_SESSION['user_type']=="1"){?>images/logo/<?php echo $title->ins_logo; ?> <?php } elseif($_SESSION['user_type']=="2"){?>images/user_profile/<?php echo $title1->DEM_EMP_ID.".jpg"; ?> <?php } else { ?> images/user.jpg <?php } ?>" onerror="this.src='images/err_logo.png'" class="user-image" alt="User Image">

              <span class="hidden-xs"> <b><?php if($_SESSION['user_type']=="1"){ echo $title->ins_name; }elseif($_SESSION['user_type']=="2"){ echo $title1->DEM_EMP_FIRST_NAME." ".$title1->DEM_EMP_MIDDLE_NAME." ".$title1->DEM_EMP_LAST_NAME; }  ?></b> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php if($_SESSION['user_type']=="1"){?>images/logo/<?php echo $title->ins_logo; ?> <?php } elseif($_SESSION['user_type']=="2"){?>images/user_profile/<?php echo $title1->DEM_EMP_ID.".jpg"; ?> <?php } else { ?> images/user.jpg <?php } ?>" onerror="this.src='images/err_logo.png'" class="img-circle" alt="User Image"><br>

                <span class="hidden-xs"> <b style="color: #fff; font-size: 20px;"><?php if($_SESSION['user_type']=="1"){ echo $title->ins_name; }elseif($_SESSION['user_type']=="2"){ echo $title1->DEM_EMP_FIRST_NAME." ".$title1->DEM_EMP_MIDDLE_NAME." ".$title1->DEM_EMP_LAST_NAME; } ?></b> </span>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <div class="pull-right">
                <a href="logout.php" class="btn btn-primary btn-round" style="margin: 10px; border-radius: 5px; background-color: #2a586f; color: white;"><i class="fa fa-power-off" aria-hidden="true"></i> &nbsp;<b>Sign Out</b></a>
              </div>
             
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>