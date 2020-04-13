<?php
session_start();
include('./connection.php');

if (isset($_POST['get_weeks_in_year'])) {
	extract($_POST);
	$lastweak = date("W",strtotime('December'.$attd_year));
	?>
	<option value="">Select Week</option>
	<?php
	
	for($wc=1;$wc<=$lastweak;$wc++)
	{

		if($_SESSION['user_type']==2)
		{

			if(((date('W')-1)==$wc) || (date('W')==$wc))
			{
	?>		
			<option value="<?php echo $wc; ?>" <?php if(date('W')==$wc && date('Y')==$attd_year){ echo "selected"; } ?>><?php echo "Week ".$wc; ?></option>			
	<?php
			}
		}else{
	?>
			<option value="<?php echo $wc; ?>" <?php if(date('W')==$wc && date('Y')==$attd_year){ echo "selected"; } ?>><?php echo "Week ".$wc; ?></option>
	<?php
		}
	if((date('W')==$wc) && (date("Y")==$attd_year)){ break;  }
	}
}


if (isset($_POST['get_weeks_in_yearfor_report'])) {
	extract($_POST);
	$lastweak = date("W",strtotime('December'.$attd_year));
	?>
	<option value="">Select Week</option>
	<?php
	
	for($wc=1;$wc<=$lastweak;$wc++)
	{		
	?>
			<option value="<?php echo $wc; ?>" <?php if(date('W')==$wc && date('Y')==$attd_year){ echo "selected"; } ?>><?php echo "Week ".$wc; ?></option>
	<?php		
	
	if((date('W')==$wc) && (date("Y")==$attd_year)){ break;  }
	}
}
?>