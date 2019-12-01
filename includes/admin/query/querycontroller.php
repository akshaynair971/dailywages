 
<?php

//sms setting code start

if(isset($_POST['sms_setting']))
{
	$sms_sender = $_POST['sender_name'];
	$sms_u_name = $_POST['user_name'];
	$sms_password = $_POST['password'];
	$today = date('Y-m-d');

		if(isset($_POST['setting_id']) && $_POST['setting_id']!='')
	{
		$id = $_POST['setting_id'];
		
		$insert=$db->query ("UPDATE sms_setting SET sms_username='$sms_u_name',sms_password='$sms_password',sms_sender_name='$sms_sender' WHERE sms_id='$id'");

		if($insert)
		  {
		      global  $succ;
		      $succ= "Information Update Successfully...!";
		      header("Refresh:1.0; url=index.php?folder=admin&file=sms_setting_view");
		  }
		  else
		  {
		    global  $msg;
		    $msg= "Something Went Wrong...!";
		    header("Refresh:1.0; url=index.php?folder=admin&file=sms_setting_view");
		  }
			
	}
	else
		{
			$sq="INSERT INTO sms_setting VALUES ('','$sms_u_name','$sms_password','$sms_sender','','$today')";
	  	 	$insert1 = $db->query($sq);

	  	 	if($insert1)
			  {
			      global  $succ;
			      $succ= "Information Added Successfully...!";
			      header("Refresh:1.0; url=index.php?folder=admin&file=sms_setting_view");
			  }
			  else
			  {
			    global  $msg;
			    $msg= "Something Went Wrong...!";
			    header("Refresh:1.0; url=index.php?folder=admin&file=change_sms_setting");
			  }
		}
	}

//sms setting code end




//Send SMS Setting Code Start

if(isset($_POST['send_sms_setting']))
{
	extract($_POST);
	$today = date('Y-m-d');

	if (isset($_GET['edit_id'])) 
	{
		$insert=$db->query ("UPDATE send_sms_setting SET emp_regi_sms='$usr_regi_sms',emp_atten_sms='$emp_atten_sms',stud_regi_sms='$stud_regi_sms',stud_admi_sms='$stud_admi_sms',stud_atten_sms='$stud_atten_sms',payment_sms='$pay_sms',emp_salery_gen_sms='$emp_sal_sms',test_mark_snd_sms='$stud_tst_sms',homework_sms='$stud_hw_sms' WHERE snd_sms_id='".$_GET['edit_id']."'");

		if($insert)
		  {
		      global  $succ;
		      $succ= "SMS Send Information Update Successfully...!";
		      header("Refresh:1.0; url=index.php?folder=admin&file=set_sms_view");
		  }
		  else
		  {
		    global  $msg;
		    $msg= "Something Went Wrong...!";
		    header("Refresh:1.0; url=index.php?folder=admin&file=set_sms_view");
		  }
			
	}
	else
	{
		$sq="INSERT INTO send_sms_setting VALUES ('','".$_SESSION['inst_id']."','".$_SESSION['ad_id']."','".$_SESSION['user_type']."','$usr_regi_sms','$emp_atten_sms','$stud_regi_sms','$stud_admi_sms','$stud_atten_sms','$pay_sms','$emp_sal_sms','$stud_tst_sms','$stud_hw_sms','$today','')";
  	 	$insert1 = $db->query($sq);

  	 	if($insert1)
		  {
		      global  $succ;
		      $succ= "SMS Send Information Added Successfully...!";
		      header("Refresh:1.0; url=index.php?folder=admin&file=set_sms_view");
		  }
		  else
		  {
		    global  $msg;
		    $msg= "Something Went Wrong...!";
		    header("Refresh:1.0; url=index.php?folder=admin&file=set_sms_send_add");
		  }
	}
}

//Send SMS Setting Code End


?>