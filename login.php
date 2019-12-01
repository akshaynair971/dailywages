<?php

session_start();

include("connection.php");

$title =$db->get_row("SELECT * FROM general_setting WHERE gs_id='1'");

if($_POST)
{ 

	if(isset($_POST['uname']) && isset($_POST['pass']))
	{

    $user_type=$_POST['user_type'];
		
		$username=$_POST['uname'];
		
		$password=$_POST['pass'];

    if($user_type==1) 
    {
      $checkadmin = $db->get_var("SELECT COUNT(*) FROM admin WHERE ad_username='$username' AND ad_password='$password'");
    }
    elseif ($user_type==2) 
    {
      $checkadmin = $db->get_var("SELECT COUNT(*) FROM dw_user_login WHERE DUL_USER_NAME='$username' AND DUL_USER_PASSWORD='$password' AND DUL_ACTIVE_FLAG='ACTIVE'");
    }
		
		
		if($checkadmin==1)
		{
		mail("akshaynair8747@gmail.com","login to bookman daily wages","someone has logged in to bookman");
		 	
      if(isset($_POST['user_type']))
      {

  			if ($_POST['user_type'] == '1') 
        {
    			$getadmin = $db->get_row("SELECT * FROM admin WHERE ad_username='$username' AND ad_password='$password'");            
              
          $_SESSION['ad_id']=$getadmin->ad_id;
          $_SESSION['ad_name'] = $getadmin->ad_username;
          $_SESSION['user_type'] = $getadmin->ad_usertype;   
          
          header('location:index.php');  
        }

        if ($_POST['user_type'] == '2') 
        {
          $getadmin = $db->get_row("SELECT * FROM dw_user_login WHERE DUL_USER_NAME='$username' AND DUL_USER_PASSWORD='$password'");  					
    					
  				$_SESSION['ad_id']=$getadmin->DUL_USER_ID;
          $_SESSION['DEM_EMP_ID']=$getadmin->DEM_EMP_ID;
  				$_SESSION['ad_name'] = $getadmin->DUL_USER_NAME;
          $_SESSION['user_type'] = "2";                      
         
  				header('location:index.php');
  			}
          
         
      }
		}
    
		else
		{
			
	    global	$msg;
		  $msg= " Either username & password is Incorrect or you are Deactivated by Administrator..!";

		}
	
	}
	else
	{
	}

}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (isset($title)) {echo $title->ins_name;}  ?></title>
  <link rel="shortcut icon" href="images/logo/<?php echo $title->ins_logo; ?>" onerror="this.src='images/err_logo.png'" class="user-image"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

  <link rel="stylesheet" href="dist/css/login_page_style.css">

  
</head>
<body class="login-page" style="background: #2a586f; ">
<div class="login-box" style="margin: 3% auto;">
 

        
          <div class="info" style="text-align: center;">
	        <img class="img-circle" style="width:81px; margin-right:10px; " src="images/logo/<?php echo $title->ins_logo; ?>"/>            
           <h3 style="" class="example"><b style="text-transform: uppercase; color: #fff; display: inline-block;"><?php if (isset($title)) {echo $title->ins_name;}  ?></b></h3>
			     
		
          </div>
        

        <div class="form" style="background: #fff; border: none;">
              
              
              <?php if($checkadmin!=1){
                echo '<div style="color:red;">'.$msg.'</div>';
              } ?>

              <form class="login-form" role="form" method="POST">

                <select class="form-control form-group" id="user_type" name="user_type" style="border-radius: 6px;">
                  <option value="1">ADMIN</option>
                  <option value="2">USER</option>
                </select>

                <input type="text" class="form-control" id="uname" name="uname" placeholder="username" autocomplete="off">
                <input type="password" class="form-control" name="pass" id="user_password" placeholder="password" autocomplete="off">
                
                <button style="background: #2a586f;">LOGIN</button>
              </form>
              <a style="color: #2a586f;font-size: 12px;font-family: monospace;padding-top: 25px;" class="btn btn-link" href="#">Forgot Your Password?</a>
   

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
