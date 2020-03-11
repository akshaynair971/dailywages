<?php
  
session_start();
// Hospital Post Data Insert Code.....

  if (isset($_POST["free_post_submit"]))
  {

  //echo "<script>alert('Hello')</script>";

    $title =  $_POST["j_title"];
    $type =  $_POST['j_type'];
    $role = $_POST['j_role'];
    $sal_min = $_POST['m_salary_min'];
    $sal_max = $_POST['m_salary_max'];
    $hiring_for =  $_POST['j_hiring'];
    $city =  $_POST['j_city'];
    $location = $_POST['j_localities'];
    $exp_min = $_POST['job_exp_min'];
    $exp_max = $_POST['job_exp_max'];
    $specialist = $_POST['job_speci'];
    $description =  $_POST['j_desc'];
    $email =  $_POST['j_email'];
    $mobile = $_POST['j_phone'];

    $date = date('d/m/Y');

        //$password = md5($password);
       $post_sql = "INSERT INTO fre_post_job (post_hospital_id,job_title,job_type,job_role,monthly_sal_min,monthly_sal_max,job_hiring_for,job_city,job_localities,exp_min,exp_max,job_specialisation,job_desc,job_email,job_phone,post_date) VALUES 
        ('".$_SESSION['id']."','$title','$type','$role','$sal_min','$sal_max','$hiring_for','$city','$location','$exp_min','$exp_max',' $specialist','$description','$email','$mobile','$date')";

      $post_insert = $db->query($post_sql);

     if($post_insert)
     {
        
        echo "<script>alert('Free Post Register Successfully..!!')</script>";

       echo "<script type='text/javascript'>window.location='index.php';</script>";
      }
      else
      {
        echo "Error";
      }
    
  }

?>



