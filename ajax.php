<?php
session_start();
include('./connection.php');

// Get Employee Details

if(isset($_POST['view_emp_details']))
{
	extract($_POST);
	
	$get_emp_details = $db->get_row("SELECT * FROM dw_employee_master as a LEFT JOIN dw_user_login as b ON a.DEM_EMP_ID=b.DEM_EMP_ID LEFT JOIN dw_payroll_master as c ON a.DEM_EMP_ID=c.DEM_EMP_ID WHERE a.DEM_EMP_ID='".$DEM_EMP_ID."'");

?>
	<table class="table table-bordered table-responsive">
		<tr>
			<td colspan="4">
				<div class="row">
					<div class="col-md-2">
						<img src="images/user_profile/<?php if($get_emp_details->DEM_EMP_ID!=''){ echo $get_emp_details->DEM_EMP_ID.'.jpg'; } ?>" class="img-rounded" onerror="this.src='images/user.jpg'" style="border:2px solid #d2d6de; height: 100px; width: 80px;">
					</div>
					<div class="col-md-10">			
						<b>Name: <?php echo strtoupper($get_emp_details->DEM_EMP_NAME_PREFIX." ".$get_emp_details->DEM_EMP_FIRST_NAME." ".$get_emp_details->DEM_EMP_MIDDLE_NAME." ".$get_emp_details->DEM_EMP_LAST_NAME); ?></b><br>
						<b>EMP ID.: <?php echo $get_emp_details->DEM_EMP_ID; ?></b>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<h4>Personal Details</h4>
				<hr style="border: 1px solid black;">
			</td>
		</tr>
		<tr>
			<td>
				<b>Gender:</b> 
			</td>
			<td>
				<?php echo $get_emp_details->DEM_EMP_GENDER; ?> 
			</td>
			<td>
				<b>Date Of Birth:</b> 
			</td>
			<td>
				<?php echo date("d/m/Y",strtotime($get_emp_details->DEM_EMP_DOB)); ?> 
			</td>
		</tr>
		<tr>
			<td>
				<b>Age:</b>
			</td>
			<td> 
				<?php echo $get_emp_details->DEM_EMP_AGE; ?> 
			</td>
			<td>
				<b>Mobile No.:</b> 
			</td>
			<td>
				<?php echo $get_emp_details->DEM_MOBILE_NUMBER; ?> 
			</td>
		</tr>
		<tr>
			<td>
				<b>Alt. Mobile No.: </b>
			</td>
			<td>
				<?php echo $get_emp_details->DEM_ALTERNATE_MOBILE_NUMBER; ?> 
			</td>
			<td>
				<b>Personal Email:</b>
			</td>
			<td>
			 	<?php echo $get_emp_details->DEM_PERSONAL_EMAIL_ID; ?> 
			</td>
		</tr>
		<tr>
			<td>
				<b>Official Email: </b>
			</td>
			<td>
				<?php echo $get_emp_details->DEM_OFFICIAL_EMAIL_ID; ?> 
			</td>
			<td>
				<b>Added On:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DEM_CREATION_DATE); ?> 
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<b>Permanent Address:</b><br>
				<?php echo $get_emp_details->DEM_PERMANENT_ADDRESS; ?>  
				<?php echo $get_emp_details->DEM_PA_PINCODE; ?>  
			</td>			
		
			<td colspan="2">
				<b>Current Address:</b><br>
				<?php echo $get_emp_details->DEM_CURRRENT_ADDRESS; ?>  
				<?php echo $get_emp_details->DEM_CA_PINCODE; ?>  
			</td>			
		</tr>
		<tr>
			<td colspan="4">
				<h4>Payroll Details</h4>
				<hr style="border: 1px solid black;">
			</td>
		</tr>
		<tr>
			<td>
				<b>Role:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DUL_USER_ROLE); ?> 
			</td>
			<td>
				<b>Payrole Rate: </b>
			</td>
			<td>
				<?php echo $get_emp_details->DPM_RATE; ?> 
			</td>
						
		</tr>
		<tr>
			<td>
				<b>Basic Salary:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DPM_BASIC_SALARY); ?> 
			</td>
			<td>
				<b>DPM_HRA </b>
			</td>
			<td>
				<?php echo $get_emp_details->DPM_HRA; ?> 
			</td>
						
		</tr>
		<tr>
			<td>
				<b>Other Allowance:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DPM_OTHER_ALLOWANCE); ?> 
			</td>
			<td>
				<!-- <b>Special Allowance </b> -->
			</td>
			<td>
				<!-- <?php echo $get_emp_details->DPM_SPECIAL_ALLOWANCE; ?>  -->
			</td>
						
		</tr>
		

		<tr>
			<td>
				<b>Gross Wages:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DPM_GROSS_WAGES_PAYABLE); ?> 
			</td>
			<td>
				<b>Prof. Tax</b>
			</td>
			<td>
				<?php echo $get_emp_details->DPM_PROFESSIONAL_TAX; ?> 
			</td>
						
		</tr>
		<tr>
			<td>
				<b>PF EMPLOYEE:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DPM_PF_EMPLOYEE); ?> 
			</td>
			<td>
				<b>PF EMPLOYER:</b>
			</td>
			<td>
				<?php echo strtoupper($get_emp_details->DPM_PF_EMPLOYER); ?> 
			</td>
						
		</tr>
		<tr>
			<td>
				<b>ESIC EMPLOYEE:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DPM_ESIC_EMPLOYEE); ?> 
			</td>
			<td>
				<b>ESIC EMPLOYER:</b>
			</td>
			<td>
				<?php echo strtoupper($get_emp_details->DPM_ESIC_EMPLOYER); ?> 
			</td>
						
		</tr>
		<tr>
			<td>
				<b>Amount Payable:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DPM_CALCULATED_AMOUNT); ?> 
			</td>
			<td>
				<b>Start Date:</b>
			</td> 
			<td> 
				<?php echo strtoupper($get_emp_details->DEM_START_DATE); ?> 
			</td>			
						
		</tr>
		<tr>
			<td>
				<b>Status:</b>
			</td>
			<td>
				<?php echo strtoupper($get_emp_details->DEM_ACTIVE_FLAG); ?> 
			</td>
			<td >
				<b>End Date:</b>
			</td>
			<td>
				<?php echo strtoupper($get_emp_details->DEM_END_DATE); ?> 
			</td>
						
		</tr>
	</table>	


<?php  
} 
// End Get Employee Details

if(isset($_POST['get_dates_attendance']))
{
	extract($_POST);
	?>
	<table class="table table-responsive table-bordered">
		<thead>
			<tr>
				<th>Attd. Date</th>
				<th>Attd. Day</th>
				<th>In Time</th>
				<th>Out Time</th>
				<th>Location</th>
				<th>Remark</th>
				<th>Sign</th>
			</tr>
		</thead>
		<tbody>	
			<?php
			$countdays =  cal_days_in_month(CAL_GREGORIAN, $attd_month, $attd_year);
			for($cntd=1;$cntd<=$countdays;$cntd++)
			{
				$convdate = date("Y-m-d",strtotime($attd_year."-".$attd_month."-".$cntd));
				$convday = date("D",strtotime($attd_year."-".$attd_month."-".$cntd));
				$getattd= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ATTD_DATE='$convdate'");
				if($convdate>date("Y-m-d")){
					if($attd_month==date("m")){
						break;
					}else{
						echo "<h4>You cannot take the Attendance of future date..!</h4>";
						break;
					}
				}	
			?>
				<tr style="<?php if($getattd->DEA_STATUS=="0"){ echo 'background-color: #122630; color: white;'; } ?><?php if($getattd->DEA_STATUS=="1"){ echo 'background-color: #b45935; color: white;'; } ?>">
					<td style="<?php if($getattd){ echo "background-color: green;"; }else{ echo "background-color: #2a586f;";  } ?>color: white; "> 
						<center><span style="font-weight: 700;"><?php echo $convdate; ?></span> </center>			
					</td>
					<td><span style="<?php if($convday==="Sun"){ echo "color: red;"; } ?>"><?php echo $convday; ?></span></td>
					<td>
						<div class="form-group">
				            <input type="text" name="DEA_IN_TIME[]" id="DEA_dIN_TIME" class="form-control timepicker" value="<?php if($getattd->DEA_IN_TIME!=''){ echo $getattd->DEA_IN_TIME; } ?>" <?php if((isset($getattd->DEA_STATUS)) && ($getattd->DEA_STATUS==0) && ($_SESSION['user_type']!='1')){ echo "disabled"; } ?>>
				      	</div>
					</td>
					<td>
						<div class="form-group">				        
				            <input type="text" name="DEA_OUT_TIME[]" id="DEA_OUT_TIME" class="form-control timepicker" value="<?php if($getattd->DEA_OUT_TIME!=''){ echo $getattd->DEA_OUT_TIME; } ?>" <?php if((isset($getattd->DEA_STATUS)) && ($getattd->DEA_STATUS==0) && ($_SESSION['user_type']!='1')){ echo "disabled"; } ?>>
				            
				      	</div>
					</td>
					<td>
						<div class="form-group">
				            <select name="DEA_CURRENT_LOCATION[]" id="DEA_CURRENT_LOCATION" class="form-control" <?php if((isset($getattd->DEA_STATUS)) && ($getattd->DEA_STATUS==0) && ($_SESSION['user_type']!='1')){ echo "disabled"; } ?>>
				            	<option value="">Select Location</option>
				            	<option value="OFFICE" <?php if($getattd->DEA_CURRENT_LOCATION=="OFFICE"){ echo "selected"; } ?>>OFFICE</option>
				            	<option value="CUSTOMER SITE" <?php if($getattd->DEA_CURRENT_LOCATION=="CUSTOMER SITE"){ echo "selected"; } ?>>CUSTOMER SITE</option>
				            	<option value="PERSONAL LEAVE" <?php if($getattd->DEA_CURRENT_LOCATION=="PERSONAL LEAVE"){ echo "selected"; } ?>>PERSONAL LEAVE</option>
				            	<option value="CASUAL LEAVE" <?php if($getattd->DEA_CURRENT_LOCATION=="CASUAL LEAVE"){ echo "selected"; } ?>>CASUAL LEAVE</option>
				            	<option value="SICK LEAVE" <?php if($getattd->DEA_CURRENT_LOCATION=="SICK LEAVE"){ echo "selected"; } ?>>SICK LEAVE</option>
				            	<option value="WEAKLY OFF" <?php if($getattd->DEA_CURRENT_LOCATION=="WEAKLY OFF"){ echo "selected"; } ?>>WEAKLY OFF</option>
				        	</select>
				      	</div>
				    </td>
					<td>
						<div class="form-group">
				            <input type="text" name="DEA_REMARK[]" id="DEA_REMARK" class="form-control" value="<?php if($getattd->DEA_REMARK!=''){ echo $getattd->DEA_REMARK; } ?>" <?php if((isset($getattd->DEA_STATUS)) && ($getattd->DEA_STATUS==0) && ($_SESSION['user_type']!='1')){ echo "disabled"; } ?>>
				      	</div>
					</td>
					<td>
						<div class="form-group">
				            <input type="text" name="DEA_SIGN[]" id="DEA_SIGN" class="form-control" value="<?php if($getattd->DEA_SIGN!=''){ echo $getattd->DEA_SIGN; } ?>" <?php if((isset($getattd->DEA_STATUS)) && ($getattd->DEA_STATUS==0) && ($_SESSION['user_type']!='1')){ echo "disabled"; } ?>>
				            <input type="hidden" name="attd_date[]" id="attd_date" class="form-control" value="<?php echo $convdate; ?>" <?php if((isset($getattd->DEA_STATUS)) && ($getattd->DEA_STATUS==0) && ($_SESSION['user_type']!='1')){ echo "disabled"; } ?>>
				            <input type="hidden" name="DEA_ID[]" id="DEA_ID" class="form-control" value="<?php echo $getattd->DEA_ID; ?>" <?php if((isset($getattd->DEA_STATUS)) && ($getattd->DEA_STATUS==0) && ($_SESSION['user_type']!='1')){ echo "disabled"; } ?> >
				      	</div>
					</td>					
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<script> $('.timepicker').mdtimepicker(); </script>
	<?php

}


if(isset($_POST['get_attd']))
{
	extract($_POST);
	$convdate = date("Y-m-d",strtotime($attd_date));
	$getattd= $db->get_row("SELECT * FROM dw_emp_attendance WHERE DEM_EMPLOYEE_ID='$DEM_EMP_ID' AND DEA_ATTD_DATE='$convdate'");	


	if($getattd)
	{ ?>        
		<div class="row">

			<div class="form-group col-md-4">
	            <label>Attendance Date:</label>
	            <input type="text" name="attd_date" id="attd_date" class="form-control" value="<?php echo $convdate; ?>" readonly>
	      	</div>
	      	<div class="form-group col-md-4">
	            <label>In Time</label>
	            <input type="text" name="DEA_IN_TIME" id="DEA_IN_TIME" class="form-control timepicker" value="<?php echo $getattd->DEA_IN_TIME; ?>" <?php if(($getattd->DEA_STATUS!="1") && ($_SESSION['user_type']==2)){ echo "disabled";  } ?>>
	      	</div>
	     	<div class="form-group col-md-4">
		        <label>Out Time</label>
	            <input type="text" name="DEA_OUT_TIME" id="DEA_OUT_TIME" class="form-control timepicker" value="<?php echo $getattd->DEA_OUT_TIME; ?>" <?php if(($getattd->DEA_STATUS!="1") && ($_SESSION['user_type']==2)){ echo "disabled";  } ?>>
	      	</div>
	      	<div class="form-group col-md-4">
	            <label>Location</label>
	            <select name="DEA_CURRENT_LOCATION" id="DEA_CURRENT_LOCATION" class="form-control" value="<?php echo $getattd->DEA_CURRENT_LOCATION; ?>" <?php if(($getattd->DEA_STATUS!="1") && ($_SESSION['user_type']==2)){ echo "disabled";  } ?>>
	            	<option value="">Select Location</option>
	            	<option value="OFFICE" <?php if($getattd->DEA_CURRENT_LOCATION=="OFFICE"){ echo "selected"; } ?>>OFFICE</option>
	            	<option value="CUSTOMER SITE" <?php if($getattd->DEA_CURRENT_LOCATION=="CUSTOMER SITE"){ echo "selected"; } ?>>CUSTOMER SITE</option>
	            	<option value="LEAVE" <?php if($getattd->DEA_CURRENT_LOCATION=="LEAVE"){ echo "selected"; } ?>>LEAVE</option>
	        	</select>
	      	</div>
	      	<div class="form-group col-md-4">
	            <label>Remark</label>
	            <input type="text" name="DEA_REMARK" id="DEA_REMARK" class="form-control" value="<?php echo $getattd->DEA_REMARK; ?>" <?php if(($getattd->DEA_STATUS!="1") && ($_SESSION['user_type']==2)){ echo "disabled";  } ?>>
	      	</div>
	      	<div class="form-group col-md-4">
	            <label>Sign</label>
	            <input type="text" name="DEA_SIGN" id="DEA_SIGN" class="form-control" value="<?php echo $getattd->DEA_SIGN; ?>" <?php if(($getattd->DEA_STATUS!="1") && ($_SESSION['user_type']==2)){ echo "disabled";  } ?>>
	            
	      	</div>
	      	<?php if($_SESSION['user_type']=="1"){ ?>
      		<div class="form-group col-md-12">
	      		<input type="hidden" name="DEA_ID" id="DEA_ID" value="<?php echo $getattd->DEA_ID; ?>" >

	            <input type="submit" class="btn btn-primary btn-round" value="Submit Attendance" name="emp_attend_submit" id="emp_attend_submit" onclick="take_attendance();">
	      	</div>
	      	<div class="form-group col-md-12">
	            <span class="msg"></span>
	      	</div>
	      	<?php }else{ 
	      		
	      		?>
	      		<input type="hidden" name="DEA_ID" id="DEA_ID" value="<?php echo $getattd->DEA_ID; ?>">
	      		<?php
	      		
	      		if($getattd->DEA_STATUS=="1"){ ?>
			      	<div class="form-group col-md-12">		      		

			            <input type="submit" class="btn btn-primary btn-round" value="Submit Attendance" name="emp_attend_submit" id="emp_attend_submit" onclick="take_attendance();">
			      	</div>
			      	<div class="form-group col-md-12">
			            <span class="msg"></span>
			      	</div>
	      <?php }

	      	} ?>
      	</div>
      <script> $('.timepicker').mdtimepicker(); </script>
	<?php 
	}else{
	?>	<div class="row">

			<div class="form-group col-md-4">
	            <label>Attendance Date:</label>
	            <input type="text" name="attd_date" id="attd_date" class="form-control" value="<?php echo $convdate; ?>" readonly>
	      	</div>

	      	<div class="form-group col-md-4">
	            <label>In Time</label>
	            <input type="text" name="DEA_IN_TIME" id="DEA_IN_TIME" class="form-control timepicker" value="<?php echo $checktodatt->DEA_IN_TIME; ?>">
	      	</div>

	     	<div class="form-group col-md-4">
		        <label>Out Time</label>
	            <input type="text" name="DEA_OUT_TIME" id="DEA_OUT_TIME" class="form-control timepicker" value="<?php echo $checktodatt->DEA_OUT_TIME; ?>">
	      	</div>

	      	<div class="form-group col-md-4">
	            <label>Location</label>
	            <select name="DEA_CURRENT_LOCATION" id="DEA_CURRENT_LOCATION" class="form-control" value="<?php echo $checktodatt->DEA_CURRENT_LOCATION; ?>">
	            	<option value="">Select Location</option>
	            	<option value="OFFICE" <?php if($checktodatt->DEA_CURRENT_LOCATION=="OFFICE"){ echo "selected"; } ?>>OFFICE</option>
	            	<option value="CUSTOMER SITE" <?php if($checktodatt->DEA_CURRENT_LOCATION=="CUSTOMER SITE"){ echo "selected"; } ?>>CUSTOMER SITE</option>
	            	<option value="LEAVE" <?php if($checktodatt->DEA_CURRENT_LOCATION=="LEAVE"){ echo "selected"; } ?>>LEAVE</option>
	        	</select>
	      	</div>

	      	<div class="form-group col-md-4">
	            <label>Remark</label>
	            <input type="text" name="DEA_REMARK" id="DEA_REMARK" class="form-control" value="<?php echo $checktodatt->DEA_REMARK; ?>">
	      	</div>

	      	<div class="form-group col-md-4">
	            <label>Sign</label>
	            <input type="text" name="DEA_SIGN" id="DEA_SIGN" class="form-control" value="<?php echo $checktodatt->DEA_SIGN; ?>">
	      	</div>

	      	<div class="form-group col-md-12">
	            <input type="submit" class="btn btn-primary btn-round" value="Submit Attendance" name="emp_attend_submit" id="emp_attend_submit" onclick="take_attendance();">
	      	</div>

	      	<div class="form-group col-md-12">
	            <span class="msg"></span>
	      	</div>

      	</div>
      <script>$('.timepicker').mdtimepicker();</script>
	<?php	
	}	
}


if(isset($_POST['take_attendance']))
{
	extract($_POST);	
	$attdarray = explode("-",$attd_date);
	if($_POST['DEA_ID']!=''){

	    $update1=$db->query("UPDATE dw_emp_attendance SET DEA_IN_TIME='$DEA_IN_TIME',DEA_OUT_TIME='$DEA_OUT_TIME',DEA_CURRENT_LOCATION='$DEA_CURRENT_LOCATION',DEA_REMARK='$DEA_REMARK',DEA_SIGN='$DEA_SIGN' WHERE DEA_ID='".$_POST['DEA_ID']."'");
	    // $db->debug();
	    if($update1)
	    {
	      
			$resp['status']= "success";
			$resp['message']= "Attendence Submitted Successfully..!";
	      
	    }else{
    		$resp['status']= "failed";
			$resp['message']= "Something Went Wrong While Taking An Attendance..!";
	    }
	    echo json_encode($resp);

  	}
  	else{
	    $insert1=$db->query("INSERT INTO dw_emp_attendance (DEA_CREATION_DATE,DEA_CREATION_BY,DEA_LAST_UPDATED_DATE,DEA_ATTD_DATE,DEA_ATTD_MONTH,DEA_ATTD_YEAR,DEA_IN_TIME,DEA_OUT_TIME,DEA_CURRENT_LOCATION,DEA_REMARK,DEA_SIGN,DEM_EMPLOYEE_ID,DEA_LATITUDE,DEA_LONGITUDE,DEA_STATUS) VALUES (NOW(),'".$_SESSION['ad_id']."',NOW(),'$attd_date','$attdarray[1]','$attdarray[0]','$DEA_IN_TIME','$DEA_OUT_TIME','$DEA_CURRENT_LOCATION','$DEA_REMARK','$DEA_SIGN','".$DEM_EMP_ID."','0','0','1')");
	    // $db->debug();
	    if($insert1)
	    {
	      
			$resp['status']= "success";
			$resp['message']= "Attendence Submitted Successfully..!";
	      
	    }else{
    		$resp['status']= "failed";
			$resp['message']= "Something Went Wrong While Taking An Attendance..!";	
			// $resp['message1']= $db->debug();	
	    }
	    echo json_encode($resp);
  	}
}


if(isset($_POST['save_lock_attd']))
{
	extract($_POST);	
	
    $update1=$db->query("UPDATE dw_emp_attendance SET DEA_STATUS='0' WHERE DEM_EMPLOYEE_ID='".$_POST['DEM_EMP_ID']."' AND DEA_STATUS='1'");
    // $db->debug();
    if($update1)
    {
      
		$resp['status']= "success";
		$resp['message']= "Attendence Locked Successfully..!";
      
    }else{
		$resp['status']= "failed";
		$resp['message']= "Attendance Already Locked or There is No Any New Attendance..!";	
		// $resp['message1']= $db->debug();	
    }
    echo json_encode($resp);

}

if(isset($_POST['save_lock_payd']))
{
	extract($_POST);	
	
    $update1=$db->query("UPDATE dw_payment_tracker SET DPT_STATUS='0' WHERE DEM_EMP_ID='".$_POST['DEM_EMP_ID']."' AND DPT_STATUS='1'");
    // $db->debug();
    if($update1)
    {
      
		$resp['status']= "success";
		$resp['message']= "Payment Details Locked Successfully..!";
      
    }else{
		$resp['status']= "failed";
		$resp['message']= "Payment Details Already Locked or There is No Any New Payment Details..!";	
		// $resp['message1']= $db->debug();	
    }
    echo json_encode($resp);

}

// Search Employee For Attendance in Admin
if(isset($_POST['searchemp_for_attd']))
{
	extract($_POST);
	?>
	<table class="table table-responsive table-bordered">
		<thead>
			<tr>
				<th>EMP. ID.</th>
				<th>EMP. Name</th>
				<th>EMP. Mobile</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$getempdet= $db->get_results("SELECT * FROM dw_employee_master WHERE DEM_EMP_FIRST_NAME LIKE '%$searchemp_for_attd%' OR DEM_EMP_MIDDLE_NAME LIKE '%$searchemp_for_attd%' OR DEM_EMP_LAST_NAME LIKE '%$searchemp_for_attd%' OR DEM_EMP_ID LIKE '%$searchemp_for_attd%' OR DEM_MOBILE_NUMBER LIKE '%$searchemp_for_attd%' OR DEM_ALTERNATE_MOBILE_NUMBER LIKE '%$searchemp_for_attd%'");
		foreach ($getempdet as $getempdetrw) 
		{			
		?>
			<tr>
				<td><?php echo $getempdetrw->DEM_EMP_ID; ?></td>
				<td><?php echo $getempdetrw->DEM_EMP_FIRST_NAME." ".$getempdetrw->DEM_EMP_MIDDLE_NAME." ".$getempdetrw->DEM_EMP_LAST_NAME; ?></td>
				<td><?php echo $getempdetrw->DEM_MOBILE_NUMBER; ?></td>
				<td><a class="btn btn-primary" href="?folder=employees&file=admin_take_employee_attendance&DEM_EMP_ID=<?php echo $getempdetrw->DEM_EMP_ID; ?>">TAKE ATTENDANCE</a></td>
			</tr>	
		<?php
		}
		?>
		</tbody>
	</table>

<?php	
}

// End Search Employee For Attendance in Admin


// Get Employee payment Details and Attendance 
if(isset($_POST['get_emp_payment_details']))
{
	extract($_POST);
	$attd_date_array = explode("-",$DPT_PAYMENT_DATE);

	$getempattd= $db->get_var("SELECT COUNT(*) FROM dw_emp_attendance WHERE  DEM_EMPLOYEE_ID = '$DEM_EMP_ID' AND DEA_ATTD_YEAR='$attd_date_array[0]' AND DEA_ATTD_MONTH='$attd_date_array[1]'");
	
	$getemppay= $db->get_var("SELECT COUNT(DPT_ID) FROM dw_payment_tracker WHERE  DEM_EMP_ID = '$DEM_EMP_ID' AND DPT_PAYMENT_YEAR='$attd_date_array[0]' AND DPT_PAYMENT_MONTH='$attd_date_array[1]'");
	// echo $getemppay;
	if($getemppay==0)
	{
	      
		$resp['status']= "success";
		$resp['total_attendance']= $getempattd;
		$resp['message']= "No Payment Added For This Month, Please Proceed To Continue..!";
      
    }else{
		$resp['status']= "failed";
		$resp['total_attendance']= $getempattd;
		$resp['message']= "Payment Details For This Month Is Already Stored..!";
    }
    echo json_encode($resp);	
}

// End Get Employee payment Details and Attendance
?>
