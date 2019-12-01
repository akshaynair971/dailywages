
<?php
  $date = date('Y-m-d');

  $institute = $db->get_var("SELECT COUNT(inst_id) FROM institute");

  $employee = $db->get_var("SELECT COUNT(user_id) FROM user");

  $employee1 = $db->get_var("SELECT COUNT(user_id) FROM user WHERE inst_id='".$_SESSION['ad_id']."'");

  $stud_regi=$db->get_var("SELECT COUNT(sr_id) FROM student_registration");

  $total_service=$db->get_var("SELECT COUNT(prod_id) FROM product_names");

  $total_cource=$db->get_var("SELECT COUNT(class_id) FROM course WHERE inst_id='".$_SESSION['ad_id']."'");

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
            <h3><?php if(isset($institute)){ echo $institute; } else { echo '0'; } ?></h3>
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
          <div class="inner">
            <h3><?php if(isset($employee)){ echo $employee; } else if (isset($employee1)){ echo $employee1; }else{ echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;"> Todays Attendance </p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div>

      
      <!-- <div class="col-lg-3 col-xs-6" style="color: white;">
        
        <div class="small-box bg-yellow ">
          <div class="inner">
            <h3><?php if(isset($stud_regi)){ echo $stud_regi; } else { echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">Current Month Attendance</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div> -->
        
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

      <div class="col-lg-3 col-xs-6" style="color: white;">
        <!-- small box -->
        <div class="small-box" style="background: #2a586f;">
          <div class="inner">
            <h3><?php if(isset($institute)){ echo $institute; } else { echo 'Pending'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;">Todays Attendance</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div>

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6" style="color: white;">
        <!-- small box -->
        <div class="small-box" style="background: #2a586f;">
          <div class="inner">
            <h3><?php if(isset($employee)){ echo $employee; } else if (isset($employee1)){ echo $employee1; }else{ echo '0'; } ?></h3>
            <p style="font-weight: 700; font-size: 18px;"> Current Month Attendance </p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
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