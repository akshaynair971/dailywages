<?php



  if (isset($_POST['update']))  
    {
        extract($_POST);
        $logo = $_FILES['logo']['name']; 
  

    $var = "UPDATE general_setting SET ins_name='$institution_name',ins_tagline='$tag_line',ins_mob='$mob_no',serial_no='$serial_no',affiliate_no='$affiliate_no',establishment_date='$establishment_date',udise_no='$udise_no',school_board='$school_board', ins_address='$address',terms_condi='$terms_condi' WHERE inst_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."'";

        $gen_update=$db->query($var);      
          
          if($gen_update)
          {
            include_once('./private/class.upload.php');
          
              if($logo!='')
              {

                $id=$db->get_row("SELECT * FROM general_setting WHERE inst_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."'");

                // Uploading the profile picture
                $path = "./images/logo";
                $gen_logo=$id->gs_id.".jpg";
                $file="./images/logo/".$gen_logo;
                if(file_exists($file))
                {
                  unlink($file);
 
                }
                $pro = new Upload($_FILES['logo']);

                    if ($pro->uploaded) 
                    {

                       $pro->file_new_name_body   = "$id->gs_id";
                      //$handle->image_resize         = true;
                      $pro->image_convert = 'jpg';
                      $pro->Process($path);
                        if ($pro->processed)
                        {
                          $update = $db->query("UPDATE general_setting SET ins_logo='$gen_logo' WHERE inst_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."'");
                          //echo 'OK';
                        } 
                        else 
                        {
                          echo 'Error1: ' . $pro->error;
                        }
                    } 
                    else 
                    {
                      echo 'Error1: ' . $pro->error;  
                    }

              }

              if($gen_update)
                {
                    global  $succ;
                    $succ= "Information Updated successfully...!";
                    header("Refresh:1.0; url=index.php?index.php");
                }
                else
                {
                  global  $msg;
                  $msg= "Something Went Wrong...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=general_setting");
                }
        }
  }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////INSTITUTE///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if (isset($_POST['institute'])) 
    {
        extract($_POST);

        // echo "<pre>";
        // print_r($_POST['tabs_id']);
        // echo "</pre>";

        $tab_data = implode(',', $_POST['tabs_id']);

        if (isset($_GET['edit_ins'])) 
        {
            $inst_update = $db->query("UPDATE institute SET inst_name='$ins_name',inst_address='$address', inst_user='$username', inst_password='$password',tab_permission='$tab_data' WHERE inst_id='".$_GET['edit_ins']."'"); 

            if($inst_update)
              {
                $gs_update=$db->query("UPDATE general_setting set ins_name='$ins_name',ins_address='$address' WHERE inst_id='".$_GET['edit_ins']."'");

                  global  $succ;
                  $succ= "Institute Information Update Successfully...!";
                  header("Refresh:1.0; url=index.php?folder=security&file=view_institute");
              }
              else
              {
                global  $msg;
                $msg= "Something Went Wrong...!";
                header("Refresh:1.0; url=index.php?folder=security&file=view_institute");
              }


        }else
        {
        
            $inst_insert=$db->query("INSERT INTO institute values('','2','$ins_name','$address','$username','$password','$tab_data','1')");      
              
              if($inst_insert)
              {
                  $id = $db->insert_id;
                  $gs_insert=$db->query("INSERT INTO general_setting values('','$id','2','$ins_name','','','$address','','')");


                   global  $succ;
                   $succ= "New Institute Information Added Successfully...!";
                   header("Refresh:1.0; url=index.php?folder=security&file=view_institute");
              }
              else
                {
                  global  $msg;
                  $msg= "Something Went Wrong...!";
                  header("Refresh:1.0; url=index.php?folder=security&file=view_institute");
                }
        }

}




if (isset($_GET['delete_ins'])) 
{
    $dele_inst = $_GET['delete_ins'];
    $delete =$db ->query("DELETE FROM institute WHERE inst_id = '".$dele_inst."'");

    if ($delete)
    {
      echo "<script>alert('Deleted successfully...');</script>";
      echo "<script>window.location='?folder=security&file=view_institute'</script>";
    }
    else
    {
      echo "<script>alert(' not Deleted successfully...');</script>";
    }
    
}


if (isset($_GET['delete_user_type'])) 
{
    $dele_usr_type = $_GET['delete_user_type'];
    $delete =$db ->query("DELETE FROM user_type WHERE usr_id = '".$dele_usr_type."'");
    
    if ($delete)
    {
      echo "<script>alert('Deleted successfully...');</script>";
      echo "<script>window.location='?folder=security&file=view_user_type'</script>";
    }
    else
    {
      echo "<script>alert('Error something went wrong ...');</script>";
    }
    
}




if(isset($_POST['password_change']))
{
  $oldpassword= $_POST['oldpassword'];
  $newpassword= $_POST['newpassword'];
  $newpassword2= $_POST['newpassword2'];


if(isset($_SESSION['ad_id']) && $_SESSION['user_type'] == '1')
{
   $getpass= $db->get_var("SELECT COUNT(*) FROM  admin WHERE ad_id='".$_SESSION['ad_id']."'AND ad_password='$oldpassword'  ");
   
  
  if($getpass==1){
    $update = $db->query("UPDATE admin SET ad_password='$newpassword' WHERE ad_id='".$_SESSION['ad_id']."'");
    global  $succ;
    $succ= "Password Changed Successfully..!";

  }
  else{

  global  $msg;
    $msg= " Please enter the valid  password...!";
  }

}



else if(isset($_SESSION['ad_id']) && $_SESSION['user_type'] == '2')
  {
     $getpass= $db->get_var("SELECT COUNT(*) FROM  dw_user_login WHERE DUL_USER_ID='".$_SESSION['ad_id']."'AND DUL_USER_PASSWORD='$oldpassword'  ");
     
    
    if($getpass==1){
      $update = $db->query("UPDATE dw_user_login SET DUL_USER_PASSWORD='$newpassword' WHERE DUL_USER_ID='".$_SESSION['ad_id']."'");

      global  $succ;
      $succ= "Password Changed Successfully..!";

    }
    else{

    global  $msg;
      $msg= " Please enter the valid  password...!";
    }

}


  else
  {
    echo "something Went Wrong";
  }

}
?>