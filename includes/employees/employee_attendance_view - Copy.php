<?php
  if (isset($_POST['emp_attend_view'])) {
    extract($_POST);
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    $today_date = date('Y-m-d');
    $checktodatt = $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEA_ATTD_DATE='$emp_attend_date' AND DEM_EMPLOYEE_ID='".$_SESSION['DEM_EMP_ID']."' ");
    // $db->debug();  
  }
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
			 <div colspan="{$colSpan}" align="center" id="date_heading" >
						<font color="#3C8DBC" size="6px;">	<b>Employee Attendance </b></font><br>
            <span style="color: red; font-size: 18px; font-weight: 700;"></span>
				</div>	
					<div class="col-xs-12" align="right">
						<!-- <a class="btn btn-primary btn-w-xs" href="#" data-toggle="modal" data-target="#myModal">Take Attendance</a> -->
					</div>
				</div>	
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <form method="POST" enctype="multipart/form-data">
              <div class="form-group col-md-4">
              	<label style="width: 30%; margin-left: 10px;">Date : <span style="color: red;">*</span></label>
              	<input type="text" class="form-control"  style="margin-left: 10px;" placeholder="Select Date Here......" autocomplete="off" name="emp_attend_date" id="datepicker" required>
              </div>
              <div class="form-group col-md-4">
              <input style="margin-top: 22px;" type="submit" class="btn btn-primary btn-round" value="Get Attendance" name="emp_attend_view">
            </div>
            <br>
            <?php if (isset($_POST['emp_attend_view'])) 
            { ?>
              <div class="form-group col-md-12">
                <a href="?folder=employees&file=take_employee_attendance&att_date=<?php echo $emp_attend_date; ?>" style="margin-top: 22px;" class="btn btn-warning btn-round" >Take / Edit Attendance</a>
              </div>
              <br>

              <div class="form-group col-md-12">
                <b style="color: green;"> Attendance Status of date <?php echo date("d/m/Y",strtotime($emp_attend_date)); ?></b>
              </div>

              <div class="form-group col-md-12">  
                <?php 
                if($checktodatt)
                { ?>        
                <table  class="table table-bordered table-striped">
                  <thead>
                    <tr>  
                      <th>IN Time</th>
                      <th>OUT Time</th>
                      <th>Location</th>
                      <th>Sign</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>                  	         				
                    <tr>  								
            					
            					<td><?php echo $checktodatt->DEA_IN_TIME; ?></td>
            					<td><?php echo $checktodatt->DEA_OUT_TIME; ?></td>
            					<td><?php echo $checktodatt->DEA_CURRENT_LOCATION; ?></td>
                      <td><?php echo $checktodatt->DEA_SIGN; ?></td>
                      <td>
                        <a href="?folder=employees&file=take_employee_attendance&dea_id=<?php echo $checktodatt->DEA_ID; ?>&att_date=<?php echo $checktodatt->DEA_ATTD_DATE; ?>"><i class="fa fa-edit"></i></a>                          
                      </td>
            				</tr>            		
				          </tbody>
         	      </table>
                <?php 
                }else{
                ?>
                <h3 style="color: red;">Pending..!</h3>
                <?php
                } ?>
              </div>
           	<?php } ?>
           </form><br>
         </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     
    </section>
    <!-- /.content -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script>
        $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
        </script> 

<script src="dist/js/jquery-1.10.2.js"></script>

  <script>
  $(function() {
    $( "#datepicker" ).datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: "1950:2050"
    });
  });
  </script>