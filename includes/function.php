<?php


 
function welcome_msg()
  {
    global $db;
    $title =$db->get_row("SELECT * FROM general_setting WHERE inst_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."'"); 

     $title1 =$db->get_row("SELECT * FROM user WHERE user_type='".$_SESSION['user_type']."' AND user_id='".$_SESSION['ad_id']."'"); 

     $title2 =$db->get_row("SELECT * FROM student_registration WHERE par_log_user_type='".$_SESSION['user_type']."' AND sr_id='".$_SESSION['ad_id']."'");
    ?>


<script src="bootstrap/js/jquery.min.js"></script>
    
<style>


.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
  position: fixed;
  left: 0px;
  top: 0px; 
  color:#fff;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url(./dist/img/482.GIF) center no-repeat black;
}

.se-pre-con h1{
  text-align: center;
  margin-top: 240px;
  font-size: 45px;
}
</style>
<script>

    //paste this code under head tag or in a seperate js file.
  // Wait for window load
  $(window).load(function() {
    // Animate loader off screen
    setTimeout(
  function() 
  {
    //do something special
    $(".se-pre-con").fadeOut("slow");;
      }, 1400);
  });

 
    </script>

<!-- <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet"> -->
  
<div class="se-pre-con"> 

<h1 style="color:#80ced6; text-transform: uppercase; font-weight: 700;">Welcome <?php if (isset($title)){echo $title->ins_name;} elseif(isset($title1)){ echo $title1->user_name; } else{ echo $title2->stud_father; }  ?></h1></div> 
<?php

  }


?>



