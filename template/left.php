  <aside class="main-sidebar" style="background-color:#122630; width:240px;">  
    <!-- sidebar: style can be found in sidebar.less --> 
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php if($_SESSION['user_type']=="1"){?>images/logo/<?php echo $title->ins_logo; ?> <?php } elseif($_SESSION['user_type']=="2"){?>images/user_profile/<?php echo $title1->DEM_EMP_ID.".jpg";  } else { ?> images/user.jpg <?php } ?>" onerror="this.src='images/err_logo.png'" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="margin-top: 12px;"> <b><?php if($_SESSION['user_type']=="1"){ echo $title->ins_name; }elseif($_SESSION['user_type']=="2"){ echo "HELLO, ".$title1->DEM_EMP_NAME_PREFIX." ".$title1->DEM_EMP_FIRST_NAME; }  ?></b></p>
        </div>
      </div>
  <ul class="sidebar-menu" data-widget="tree">  
    <li ><a href="<?php echo site_root; ?>index.php"><i class="fa fa-dashboard"></i> Main Dashboard </a></li>
    <?php if($_SESSION['user_type']=="1"){?>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-lock"></i>
          <span>Security</span>   
          <span class="pull-right-container"> 
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        
          <li><a href="<?php echo site_root; ?>index.php?folder=security&file=general_setting"><i class="fa fa-cog"></i>General Setting</a></li>
        

        
          <li><a href="<?php echo site_root; ?>index.php?folder=security&file=change_password"><i class="fa fa-key"></i>Change Password</a></li>
          
          <!-- <li><a href="?folder=admin&file=sms_setting_view"><i class="fa fa-line-chart"></i> SMS General Setting </a></li>       -->
          <!-- <?php if(in_array('39',$tab_data)){ ?>
            <li><a href="?folder=admin&file=set_sms_view"><i class="fa fa-line-chart"></i> Set SMS To Send</a></li>
          <?php } ?> -->

          <!--  <li><a href="?folder=admin&file=database_backup_view"><i class="fa fa-line-chart"></i> <b style="color: red;"> Database Backup</b></a></li>
        

          
            <li><a href="?folder=admin&file=opening_balance_view"><i class="fa fa-line-chart"></i> <b style="color: #3c8dbc;"> Opening Balance</b></a></li> -->
        
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Employees</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">      
          <li><a href="<?php echo site_root; ?>index.php?folder=employees&file=employee_list"><i class="fa fa-hand-o-right"></i> Employees List </a></li>
          <li><a href="<?php echo site_root; ?>index.php?folder=employees&file=admin_employee_attendance_view"><i class="fa fa-hand-o-right"></i>  Employees Attendance & <br> Payment</a></li>     
          <!-- <li><a href="?folder=employees&file=admin_employee_paytrack_view"><i class="fa fa-hand-o-right"></i>  Employees Payment Tracker</a></li>      -->
        </ul>
      </li> 
      <li><a href="<?php echo site_root; ?>index.php?folder=travel_expense&file=travel_expense_list"><i class="fa fa-file"></i> Travel & Expense</a></li>
      <li><a href="<?php echo site_root; ?>index.php?folder=reports&file=emp_report_filter_by_date"><i class="fa fa-file"></i> Reports</a></li>

      <!-- <li  class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i> <span> Reports</span>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i></span>
        </a> 
        <ul class="treeview-menu">              
          <li><a href="?folder=reports&file=emp_report_filter_by_date"><i class="fa fa-hand-o-right"></i> Payment Report</a></li>              
                     
        </ul>           
      </li> -->
    <?php 
    }
     ?>



    <?php 


    if($_SESSION['user_type']=="2"){?>
      <li class="treeview ">
        <a href="#">
          <i class="fa fa-lock"></i>
          <span>My Account</span>   
          <span class="pull-right-container"> 
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo site_root; ?>index.php?folder=employees&file=employee_profile"><i class="fa fa-user"></i>My Profile</a></li>
          <li><a href="<?php echo site_root; ?>index.php?folder=security&file=change_password"><i class="fa fa-key"></i>Change Password</a></li>
       
        </ul>
      </li>
      <li><a href="<?php echo site_root; ?>index.php?folder=employees&file=employee_attendance_view"><i class="fa fa-hand-o-right"></i> Attendance </a></li>
      <li><a href="<?php echo site_root; ?>index.php?folder=employees&file=payment_tracker_view&DEM_EMP_ID=<?php echo $_SESSION['DEM_EMP_ID']; ?>"><i class="fa fa-rupee"></i> Payment Tracker </a></li>
      <li><a href="<?php echo site_root; ?>index.php?folder=travel_expense&file=travel_expense_list"><i class="fa fa-file"></i> Travel & Expense</a></li>
      <li><a href="<?php echo site_root; ?>index.php?folder=reports&file=emp_report_filter_by_date"><i class="fa fa-file"></i> Reports</a></li>
      <!-- <li  class="treeview">
        <a href="#">
          <i class="fa fa-file" aria-hidden="true"></i> <span> Reports</span>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i></span>
        </a> 
        <ul class="treeview-menu">              
          <li><a href="?folder=reports&file=emp_report_filter_by_date"><i class="fa fa-hand-o-right"></i> Payment Report</a></li>              
                       
        </ul>           
      </li> -->
        
    <?php 
    }
     ?>  




  </ul>
</section>
 <!-- /.sidebar -->
</aside>