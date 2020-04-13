
<?php
  $date = date('Y-m-d');  
?>  
  

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title->ins_name; ?> Dashboard
      <small><b></b></small>
    </h1>

    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <?php
  if($_SESSION['user_type'] == '1'){
  ?>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->

    <div class="row">

      <div class="col-lg-3 col-xs-6" style="color: white;">
        <!-- small box -->
        <div class="small-box " style="background: #2a586f;">
          <div class="inner">
            <?php 
            $totalusers = $db->get_var("SELECT COUNT(DEM_ID) FROM dw_employee_master");
             ?>
            <h3><?php if(isset($totalusers)){ echo $totalusers; } else { echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">Total Users</p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6" style="color: white;">
        <!-- small box -->
        <div class="small-box" style="background: #2a586f;">
          <?php 
          $tdate= date("Y-m-d");
            $todaysattd = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEA_ATTD_DATE='$tdate'");
             ?>
          <div class="inner">
            <h3><?php if(isset($todaysattd)){ echo $todaysattd; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;"> Todays Attendance </p>
          </div>
          <div class="icon">
            <i class="fa fa-clock-o"></i>
          </div>
        </div>
      </div>

      
      <div class="col-lg-3 col-xs-6" style="color: white;">
        
        <div class="small-box " style="background: #2a586f;">
          <?php 
            $tdate= date("Y-m-d");
            $curmonexp = $db->get_var("SELECT COUNT(DTE_ID) FROM dw_travel_expense WHERE YEAR(DTE_VOUCHER_DATE)=YEAR('$tdate') AND MONTH(DTE_VOUCHER_DATE)=MONTH('$tdate')");
          ?>
          <div class="inner">
            <h3><?php if(isset($curmonexp)){ echo $curmonexp; } else { echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">Current Month Expense</p>
          </div>
          <div class="icon">
            <i class="fa fa-bus"></i>
          </div>
        </div>
      </div>
        
      <!-- <div class="col-lg-3 col-xs-6" style="color: white;">        
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php if(isset($total_cource)){ echo $total_cource; } else { echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">TOTAL COURSE</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div> -->       
    </div>
  </section>
    <!-- /.content-wrapper -->
  <?php 
  } ?>

  <?php
  if($_SESSION['user_type'] == '2'){
  ?>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->

    <div class="row">

     <!--  <div class="col-lg-3 col-xs-6" style="color: white;">
        
        <div class="small-box" style="background: #2a586f;">
          <div class="inner">
            <h3><?php if(isset($institute)){ echo $institute; } else { echo 'Pending'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">Todays Attendance</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div> -->

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6" style="color: white;">
        <!-- small box -->
        <div class="small-box" style="background: #2a586f;">
          <div class="inner">
            <?php 
            $tdate= date("Y-m-d");
            $todaysattd1 = $db->get_var("SELECT COUNT(DEA_ID) FROM dw_emp_attendance WHERE DEA_ATTD_DATE='$tdate' AND DEM_EMPLOYEE_ID='".$_SESSION['DEM_EMP_ID']."'");
             ?>
            <h3><?php if(isset($todaysattd1) && $todaysattd1>0){ echo "Done"; }else{ echo "Pending"; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;"> Todays Attendance </p>
          </div>
          <div class="icon">
            <i class="fa fa-clock-o"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6" style="color: white;">
        
        <div class="small-box " style="background: #2a586f;">
          <?php 
            $tdate= date("Y-m-d");
            $curmonexp = $db->get_var("SELECT COUNT(DTE_ID) FROM dw_travel_expense WHERE YEAR(DTE_VOUCHER_DATE)=YEAR('$tdate') AND MONTH(DTE_VOUCHER_DATE)=MONTH('$tdate') AND DEM_EMP_ID='".$_SESSION['DEM_EMP_ID']."'");
          ?>
          <div class="inner">
            <h3><?php if(isset($curmonexp)){ echo $curmonexp; } else { echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">Current Month Expense</p>
          </div>
          <div class="icon">
            <i class="fa fa-bus"></i>
          </div>
        </div>
      </div>

     
     <!--  <div class="col-lg-3 col-xs-6">
        
        <div class="small-box bg-yellow ">
          <div class="inner">
            <h3><?php if(isset($stud_regi)){ echo $stud_regi; } else { echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">Payment Credited Till Now</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div> -->
        <?php// print_r($_SESSION); ?>
        <?php // print_r($title1); ?>
      <!-- <div class="col-lg-3 col-xs-6">        
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php // if(isset($total_cource)){ echo $total_cource; } else { echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">TOTAL COURSE</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div> -->       
    </div>
  </section>
    <!-- /.content-wrapper -->
  <?php 
  } ?>

</div>