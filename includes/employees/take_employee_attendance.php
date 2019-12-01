<?php
    // print_r($_SESSION);
    $today_date = date('Y-m-d');
    $dea_id= $_GET['dea_id']; 
    $checktodatt = $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEA_ID='".$dea_id."' AND DEM_EMPLOYEE_ID='".$_SESSION['DEM_EMP_ID']."'");      

?>

    <!-- Main content -->
<section class="content">	
  <div class="row">
    <div class="col-xs-12">         
      <div class="box">
        <div class="box-header">
          <?php  
            if(isset($msg))
            {
              echo"<div style='font-size:18px; color:red; margin-left:15px; font-weight:700;'>".$msg."</div>";
            }
            if(isset($succ))
            {
              echo"<div style='font-size:18px; color:green; margin-left:15px; font-weight:700;'>".$succ."</div>";
            }
          ?>
			
          <div class="row">
            <div align="center" id="date_heading" >
						  <font color="#3C8DBC" size="6px;">	<b>Take Attendance</b></font>
				    </div>				
				  </div>	
        
        <form method="POST" enctype="multipart/form-data">
          <div class="form-group col-md-12">
          	<label style="width: 30%; margin-left: 10px;">Date : <?php echo date("d/m/Y",strtotime($_GET['att_date'])); ?></label>
          	<input type="hidden" class="form-control" value="<?php echo $_GET['att_date']; ?>" name="attend_date" id="attend_date" required>    
          </div>
          <div class="form-group col-md-4">
            <label>In Time</label>
            <input type="text" name="DEA_IN_TIME"  id="DEA_IN_TIME"  class="form-control timepicker" value="<?php echo $checktodatt->DEA_IN_TIME; ?>">
          </div>
          <div class="form-group col-md-4">
            <label>Out Time</label>
            <input type="text" name="DEA_OUT_TIME" id="DEA_OUT_TIME" class="form-control timepicker" value="<?php echo $checktodatt->DEA_OUT_TIME; ?>">
          </div>
          <div class="form-group col-md-4">
            <label>Location</label>
            <input type="text" name="DEA_CURRENT_LOCATION" id="DEA_CURRENT_LOCATION" class="form-control" value="<?php echo $checktodatt->DEA_CURRENT_LOCATION; ?>">
          </div>
          <div class="form-group col-md-4">
            <label>Sign</label>
            <input type="text" name="DEA_SIGN"  id="DEA_SIGN" class="form-control" value="<?php echo $checktodatt->DEA_SIGN; ?>">
          </div>
          <div class="form-group col-md-12">
            <input type="submit" class="btn btn-primary btn-round" value="Submit Attendance" name="emp_attend_submit">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
   