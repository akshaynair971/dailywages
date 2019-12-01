<?php
session_start();
ob_start();

global $db;

if(!isset($_SESSION['ad_id']))
{
  echo "<script>window.location='login.php';</script>";
}

include_once("connection.php");

// prnt($_SESSION);
if(isset($_GET['folder']))
{
  $folder=$_GET['folder'];  
}
else
{
  $folder='default';
}
 

 include('includes/function.php');


if(is_file('includes/'.$folder.'/function.php'))
   {
    include_once('includes/'.$folder.'/function.php');
    }
    
      include_once('includes/'.$folder.'/query/querycontroller.php');
      

//  if(!isset($_SESSION['first']))
// {
//  welcome_msg();
//  $_SESSION['first']='run';
//  }

include('template/topbar.php');
include('template/left.php');
?>
      <?php 
            if(isset($_GET['folder'])){
      ?>
 

      <div class="content-wrapper">
        <?php
        
           include_once('includes/'.$folder.'/breadcrumbs.php');
        ?>

        <section class="content">
          <div class="row">
                 <?php
                 
                 include_once('includes/'.$folder.'/controller.php');

                 ?>
          </div>
        </section>
      </div>

 <?php } 
 else
    {
        include_once('includes/default/dashboard.php'); 

    }

?>
<?php
  include('template/footer.php');
?>