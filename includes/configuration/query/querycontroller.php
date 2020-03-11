<?php 
  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////USER TYPE////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$GLOBALS['isexist'] = 0;
 
if (isset($_POST['save_user_type']))  
    {
      
        extract($_POST);

        if (isset($_GET['edit_user_type'])) 
        {
          
            $usr_type_update = $db->query("UPDATE user_type SET usr_type='$desin_name' WHERE usr_id='".$_GET['edit_user_type']."'"); 

            if($usr_type_update)
              {
                  global  $succ;
                  $succ= "Designation Update Successfully...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=designations");
              }
              else
              {
                global  $msg;
                $msg= "Something Went Wrong...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=designations");
              }


        }else 
        {
            $chkusertype= $db->get_var("SELECT COUNT(*) FROM user_type WHERE usr_type='$desin_name'");

            if ($chkusertype>0)
            { 
                $isexist=1;
            }
            else
            {
              $usr_type_insert=$db->query("INSERT INTO user_type values('','".$_SESSION['ad_id']."','$desin_name','1')");      
                
              if($usr_type_insert)
              {
                  global  $succ;
                  $succ= "Designation Insert Successfully...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=designations");
              }
              else
              {
                global  $msg;
                $msg= "Something Went Wrong...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=add_designation");
              }
            }
        }

}
  

if (isset($_GET['desig_del_id'])) 
{
    $dele_sub = $_GET['desig_del_id'];
    $delete =$db->query("DELETE FROM user_type WHERE usr_id = '".$dele_sub."'");
    
     if($delete)
    {
        global  $succ;
        $succ= "Designation Deleted Successfully...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=subjects");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong...!";
      header("Refresh:1.0; url=index.php?folder=configuration&file=subjects");
    }
    
}  
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////ACADEMIC YEAR////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['save_ay'])) 
    {
        extract($_POST);

        if (isset($_GET['edit_ay'])) 
        {
            $ay_update = $db->query("UPDATE academic_year SET start_year='$start_year', end_year='$end_year'  WHERE ay_id='".$_GET['edit_ay']."'"); 

          if($ay_update)
          {
              global  $succ;
              $succ= "Academic Year Update Successfully...!";
              header("Refresh:1.0; url=index.php?folder=configuration&file=academic_years");
          }
          else
          {
            global  $msg;
            $msg= "Something Went Wrong...!";
            header("Refresh:1.0; url=index.php?folder=configuration&file=academic_years");
          }


        }
        else
        {
            $ay_insert=$db->query("INSERT INTO academic_year values('','".$_SESSION['ad_id']."','$start_year','$end_year','1')");      
              
              if($ay_insert)
              {
                  global  $succ;
                  $succ= "Academic Year Insert Successfully...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=academic_years");
              }
              else
              {
                global  $msg;
                $msg= "Something Went Wrong...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=add_academic_year");
              }
          }
      }



if (isset($_GET['acd_yr_del_id'])) 
{
    $dele_sub = $_GET['acd_yr_del_id'];
    $delete =$db->query("DELETE FROM academic_year WHERE ay_id = '".$dele_sub."'");
    
     if($delete)
    {
        global  $succ;
        $succ= "Academic Year Deleted Successfully...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=academic_years");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong...!";
      header("Refresh:1.0; url=index.php?folder=configuration&file=academic_years");
    }
    
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CLASS/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['save_class'])) 
    {
        extract($_POST);

        if (isset($_GET['edit_stud'])) 
        {
            $class_update = $db->query("UPDATE course SET class_name='$class_name' WHERE class_id='".$_GET['edit_stud']."'"); 

           if($class_update)
           {
               global  $succ;
               $succ= "Class Update Successfully...!";
               header("Refresh:1.0; url=index.php?folder=configuration&file=class_view");
           }
           else
           {
             global  $msg;
             $msg= "Something Went Wrong...!";
             header("Refresh:1.0; url=index.php?folder=configuration&file=class_view");
           }


        }
        else
        {        
            $class_insert=$db->query("INSERT INTO course values('','".$_SESSION['ad_id']."','$class_name','1')");      
              
              if($class_insert)
              {
                  global  $succ;
                  $succ= "New Class Insert Successfully...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=class_view");
              }
              else
              {
                global  $msg;
                $msg= "Something Went Wrong...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=add_class");
              }
        }
    }
  


  if (isset($_GET['class_del_id'])) 
  {
      $dele_sub = $_GET['class_del_id'];
      $delete =$db->query("DELETE FROM course WHERE class_id = '".$dele_sub."'");
      
       if($delete)
      {
          global  $succ;
          $succ= "Class Deleted Successfully...!";
          header("Refresh:1.0; url=index.php?folder=configuration&file=class_view");
      }
      else
      {
        global  $msg;
        $msg= "Something Went Wrong...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=class_view");
      }
      
  }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////BOARD/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['save_board'])) 
    {
        extract($_POST);  

        if (isset($_GET['edit_board'])) 
        {
            $board_update = $db->query("UPDATE board SET board_name='$bord_name' WHERE board_id='".$_GET['edit_board']."'"); 

            if($board_update)
            {
                global  $succ;
                $succ= "Board Update Successfully...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=board_view");
            }
            else
            {
              global  $msg;
              $msg= "Something Went Wrong...!";
              header("Refresh:1.0; url=index.php?folder=configuration&file=board_view");
            }


        }else
        { 
            $board_insert=$db->query("INSERT INTO board values('','".$_SESSION['ad_id']."','$bord_name','1')");      
                  
              if($board_insert)
              {
                  global  $succ;
                  $succ= "New Board Insert Successfully...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=board_view");
              }
              else
              {
                global  $msg;
                $msg= "Something Went Wrong...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=add_board");
              }
        }

}
  


if (isset($_GET['board_del_id'])) 
{
    $dele_sub = $_GET['board_del_id'];
    $delete =$db->query("DELETE FROM board WHERE board_id = '".$dele_sub."'");
    
     if($delete)
    {
        global  $succ;
        $succ= "Board Deleted Successfully...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=board_view");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong...!";
      header("Refresh:1.0; url=index.php?folder=configuration&file=board_view");
    }
    
}  


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SECTION/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['save_section']))
    {
        extract($_POST);  

        if (isset($_GET['edit_section'])) 
        {
            $section_update = $db->query("UPDATE section SET sec_name='$section' WHERE sec_id='".$_GET['edit_section']."'"); 

            if($section_update)
            {
                global  $succ;
                $succ= "Section Update Successfully...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=section_view");
            }
            else
            {
              global  $msg;
              $msg= "Something Went Wrong...!";
              header("Refresh:1.0; url=index.php?folder=configuration&file=section_view");
            }


        }else
        {      
              $section_insert=$db->query("INSERT INTO section values('','".$_SESSION['ad_id']."','$section','1')");      
                
                if($section_insert)
                {
                    global  $succ;
                    $succ = "New Section Insert Successfully...!";
                    header("Refresh:1.0; url=index.php?folder=configuration&file=section_view");
                }
                else
                {
                    global  $msg;
                    $msg = "Something Went Wrong...!";
                    header("Refresh:1.0; url=index.php?folder=configuration&file=add_section");
                }
            }
        }




if (isset($_GET['sec_del_id'])) 
{
    $dele_sub = $_GET['sec_del_id'];
    $delete =$db->query("DELETE FROM section WHERE sec_id = '".$dele_sub."'");
    
     if($delete)
    {
        global  $succ;
        $succ= "Section Deleted Successfully...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=section_view");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong...!";
      header("Refresh:1.0; url=index.php?folder=configuration&file=section_view");
    }
    
}  

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////DEPARTMENT/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['save_department'])) 
    {
        extract($_POST);  

        if (isset($_GET['edit_dept'])) 
        {
            $department_update = $db->query("UPDATE department SET dept_name='$dept_name' WHERE dept_id='".$_GET['edit_dept']."'"); 

           if($department_update)
            {
                global  $succ;
                $succ= "Department Update Successfully...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=departments_view");
            }
            else
            {
              global  $msg;
              $msg= "Something Went Wrong...!";
              header("Refresh:1.0; url=index.php?folder=configuration&file=departments_view");
            }


        }else
        {
        
                $department_insert=$db->query("INSERT INTO department values('','".$_SESSION['ad_id']."','$dept_name','1')");      
                  
                 if($department_insert)
                {
                    global  $succ;
                    $succ= "New Department Insert Successfully...!";
                    header("Refresh:1.0; url=index.php?folder=configuration&file=departments_view");
                }
                else
                {
                  global  $msg;
                  $msg= "Something Went Wrong...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=add_department");
                }
            }
        }



if (isset($_GET['depar_del_id'])) 
{
    $dele_sub = $_GET['depar_del_id'];
    $delete =$db->query("DELETE FROM department WHERE dept_id = '".$dele_sub."'");
    
     if($delete)
    {
        global  $succ;
        $succ= "Department Deleted Successfully...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=departments_view");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong...!";
      header("Refresh:1.0; url=index.php?folder=configuration&file=departments_view");
    }
    
}  


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SUBJECT/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['save_subject_list']))
    {
        extract($_POST);  

        if (isset($_GET['ed_sub'])) 
        {
          // echo "<script>alert('Hello');</script>";

            $subject_update = $db->query("UPDATE subject SET class='$sub_class',board='$board',subject='$subject' WHERE sub_id='".$_GET['ed_sub']."'"); 

            if($subject_update)
             {
                 global  $succ;
                 $succ= "Subject Update Successfully...!";
                 header("Refresh:1.0; url=index.php?folder=configuration&file=subjects_view");
             }
             else
             {
               global  $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:1.0; url=index.php?folder=configuration&file=subjects_view");
             }


        }
        else
        {
          
          for($i=0; $i<count($_POST['sub_class']); $i++)
          {

            $subect_insert=$db->query("INSERT INTO subject values('','".$_SESSION['ad_id']."', '".$_POST['sub_class'][$i]."','".$_POST['board'][$i]."','".$_POST['subject'][$i]."','1')");      
                if($subect_insert)
                {
                    global  $succ;
                    $succ= "New Subject Insert Successfully...!";
                    header("Refresh:1.0; url=index.php?folder=configuration&file=subjects_view");
                }
                else
                {
                  global  $msg;
                  $msg= "Something Went Wrong...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=add_subject");
                }
              }
            }
        }




if (isset($_GET['sub_del_sub'])) 
{
    $dele_sub = $_GET['sub_del_sub'];
    $delete =$db->query("DELETE FROM subject WHERE sub_id = '".$dele_sub."'");
    
     if($delete)
    {
        global  $succ;
        $succ= "Subject Deleted Successfully...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=subjects_view");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong...!";
      header("Refresh:1.0; url=index.php?folder=configuration&file=subjects_view");
    }
    
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////EMPLOYEE SUBJECT///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['class'])) 
    { 
        $all_sub_data = json_encode($_POST);  

        if (isset($_GET['edit_emp_sub'])) 
        {
            $emp_sub_update = $db->query("UPDATE employee_subject SET teach_subject_all_details='$all_sub_data' WHERE emp_id='".$_GET['edit_emp_sub']."'"); 


            if($emp_sub_update)
             {
                 global  $succ;
                 $succ= "Employee Subject Update Successfully...!";
                 header("Refresh:1.0; url=index.php?folder=configuration&file=employee_subjects_view");
             }
             else
             {
               global  $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:1.0; url=index.php?folder=configuration&file=employee_subjects_view");
             }


        }
        else
        {

          $chkemp= $db->get_var("SELECT COUNT(*) FROM employee_subject WHERE inst_id='".$_SESSION['ad_id']."' AND class LIKE '%$class%' AND board LIKE '%$board%' emp_name LIKE '%$emp_name%' AND emp_sub LIKE '%$subject%'");
            if ($chkemp>0)
            { 

                $isexist=1; 

            }
            else
            {
                // echo "<script>alert('saldfasd;f;adskf');</script>";

                $emp_sub_insert=$db->query("INSERT INTO employee_subject values('','".$_SESSION['ad_id']."', '$all_sub_data','1')");      
                  
                 if($emp_sub_insert)
                {
                    global  $succ;
                    $succ= "Employee Subject Insert Successfully...!";
                    header("Refresh:1.0; url=index.php?folder=configuration&file=employee_subjects_view");
                }
                else
                {
                  global  $msg;
                  $msg= "Something Went Wrong...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=add_employee_subject");
                }
            }
        }

}


if (isset($_GET['del_emp_sub'])) 
{
    $dele_sub = $_GET['del_emp_sub'];
    $delete =$db->query("DELETE FROM employee_subject WHERE emp_id = '".$dele_sub."'");
    
     if($delete)
    {
        global  $succ;
        $succ= "Deleted Successfully...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=employee_subjects_view");
    }
    else
    {
      global  $msg;
      $msg= "Something Went Wrong...!";
      header("Refresh:1.0; url=index.php?folder=configuration&file=employee_subjects_view");
    }
    
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Time Table Add //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if (isset($_POST['add_exam_time_table']))
    {
        extract($_POST);  

         // echo "<script>alert('hello');</script>";

        if (isset($_GET['ed_sub'])) 
        {
         

            $subject_update = $db->query("UPDATE exam_time_tabledb SET class_id='$standard_name',sec_id='$section',board_id='$board_name',sub_id='$subject',ay_id='$acd_yr',exam_date='$exam_date',exam_start_time='$start_exam_time',exam_end_time='$end_exam_time' WHERE exam_id='".$_GET['ed_sub']."'"); 

            if($subject_update)
             {
                 global  $succ;
                 $succ= "Exam Details Update Successfully...!";
                 header("Refresh:1.0; url=index.php?folder=configuration&file=all_exam_time_table_view");
             }
             else
             {
               global  $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:1.0; url=index.php?folder=configuration&file=all_exam_time_table_view");
             }


        }
        else
        {
          
          for($i=0; $i<count($_POST['standard_name']); $i++)
          {

            $subect_insert=$db->query("INSERT INTO exam_time_tabledb values('','".$_SESSION['ad_id']."', '".$_SESSION['inst_id']."','".$_SESSION['user_type']."','".$_POST['standard_name'][$i]."','".$_POST['section'][$i]."','".$_POST['board_name'][$i]."','".$_POST['subject'][$i]."','".$_POST['acd_yr'][$i]."','".$_POST['exam_date'][$i]."','".$_POST['start_exam_time'][$i]."','".$_POST['end_exam_time'][$i]."','')");      
                if($subect_insert)
                {
                    global  $succ;
                    $succ= "New Time Table Add Successfully...!";
                    header("Refresh:1.0; url=index.php?folder=configuration&file=all_exam_time_table_view");
                }
                else
                {
                  global  $msg;
                  $msg= "Something Went Wrong...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=add_subject");
                }
              }
            }
        }


        if (isset($_GET['deact_id'])) 
          {
            $deact_id=$_GET['deact_id'];

            $deactive_update=$db->query("UPDATE exam_time_tabledb SET status='1' WHERE exam_id='".$deact_id."'");


            if($deactive_update)
              {
                  global  $succ;
                  $succ= "Exam Time Table is Deactivated Successfully...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=all_exam_time_table_view");
              }
              else
              {
                global  $msg;
                $msg= "Something Went Wrong...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=all_exam_time_table_view");
              }
          }

        if (isset($_GET['act_id'])) 
          {
            $act_id=$_GET['act_id'];
            $active_update=$db->query("UPDATE exam_time_tabledb SET status='0' WHERE exam_id='".$act_id."'");

            if($active_update)
              {
                  global  $succ;
                  $succ= "Exam Time Table is Activate Successfully...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=all_exam_time_table_view");
              }
              else
              {
                global  $msg;
                $msg= "Something Went Wrong...!";
                header("Refresh:1.0; url=index.php?folder=configuration&file=all_exam_time_table_view");
              }
          }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Time Table Add //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
  
  if (isset($_POST['add_lect_time_tableclk']))
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        $c_name = $_POST['class_name'];
        $b_name = $_POST['board_name'];
        $s_name = $_POST['sec_name'];
        $ad_yr_name = $_POST['acd_year'];

        unset($_POST['class_name'],$_POST['board_name'],$_POST['sec_name'],$_POST['acd_year']);

        $all_data = json_encode($_POST);
        $today_date = date('Y-m-d');

        if (isset($_GET['ed_id'])) 
        {
            $subject_update = $db->query("UPDATE lect_time_table SET class_id='$c_name',board_id='$b_name',sec_id='$s_name',ay_id='$ad_yr_name',time_table_details='$all_data' WHERE lt_id='".$_GET['ed_id']."'"); 

            if($subject_update)
             {
                 global  $succ;
                 $succ= "Lecture Time Table Details Update Successfully...!";
                 header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
             }
             else
             {
               global  $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
             }


        }
        else
        {

            $subect_insert=$db->query("INSERT INTO lect_time_table values('','".$_SESSION['ad_id']."', '".$_SESSION['inst_id']."','".$_SESSION['user_type']."','$c_name','$b_name','$s_name','$ad_yr_name','$all_data','$today_date','')");      
                if($subect_insert)
                {
                    global  $succ;
                    $succ= "New Time Table Add Successfully...!";
                    header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
                }
                else
                {
                  global  $msg;
                  $msg= "Something Went Wrong...!";
                  header("Refresh:1.0; url=index.php?folder=configuration&file=add_lect_time_table");
                }
            }
        }



       if (isset($_GET['lect_deact_id'])) 
         {
           $lect_deact_id=$_GET['lect_deact_id'];

           $deactive=$db->query("UPDATE lect_time_table SET status='1' WHERE lt_id='".$lect_deact_id."'");


           if($deactive)
             {
                 global  $succ;
                 $succ= "Lecture Time Table is Deactivated Successfully...!";
                 header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
             }
             else
             {
               global  $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
             }
         }

       if (isset($_GET['lect_act_id'])) 
         {
           $lect_act_id=$_GET['lect_act_id'];
           $active_update=$db->query("UPDATE lect_time_table SET status='0' WHERE lt_id='".$lect_act_id."'");

           if($active_update)
             {
                 global  $succ;
                 $succ= "Lecture Time Table is Activate Successfully...!";
                 header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
             }
             else
             {
               global  $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
             }
         } 

         // Delete Lecture Time Table 
         if (isset($_GET['ltdel_id'])) 
         {
           $ltdel_id=$_GET['ltdel_id'];

           $ltdele=$db->query("DELETE FROM lect_time_table WHERE lt_id='".$ltdel_id."'");


           if($ltdele)
             {
                 global  $succ;
                 $succ= "Lecture Time Table is Deleted Successfully...!";
                 header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
             }
             else
             {
               global  $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:1.0; url=index.php?folder=configuration&file=lect_time_table_view");
             }
         }

         // End of Delete Lecture Time Table 



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Teacher Assign //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if (isset($_POST['class_teacher_assign']))
{
    extract($_POST);
    $today_date = date('Y-m-d');

 if (isset($_GET['edit_teach'])) 
 {
     $sub_update = $db->query("UPDATE class_teacher_assign SET class_id='$cl_name',board_id='$bo_name',sec_id='$cl_section',ay_id='$ac_year',user_id='$teach_name' WHERE teacher_id='".$_GET['edit_teach']."'"); 

     if($sub_update)
      {
          global  $succ;
          $succ= "Class Teacher Assign Details Update Successfully...!";
          header("Refresh:1.0; url=index.php?folder=configuration&file=teacher_assign_view");
      }
      else
      {
        global  $msg;
        $msg= "Something Went Wrong...!";
        header("Refresh:1.0; url=index.php?folder=configuration&file=teacher_assign_view");
      }


 }
 else
 {
     $sub_insert=$db->query("INSERT INTO class_teacher_assign values('','".$_SESSION['inst_id']."','$cl_name','$bo_name','$cl_section','$ac_year','$teach_name','$today_date','')");    

         if($sub_insert)
         {
             global  $succ;
             $succ= "Class Teacher Assign Successfully...!";
             header("Refresh:1.0; url=index.php?folder=configuration&file=teacher_assign_view");
         }
         else
         {
           global  $msg;
           $msg= "Something Went Wrong...!";
           header("Refresh:1.0; url=index.php?folder=configuration&file=add_class_teacher");
         }
     }
 }


 if (isset($_GET['tech_asig_del_id'])) 
 {
     $del_teach = $_GET['tech_asig_del_id'];
     $delete =$db->query("DELETE FROM class_teacher_assign WHERE teacher_id = '".$del_teach."'");
     
      if($delete)
     {
         global  $succ;
         $succ= "Class Teacher Details Deleted Successfully...!";
         header("Refresh:1.0; url=index.php?folder=configuration&file=teacher_assign_view");
     }
     else
     {
       global  $msg;
       $msg= "Something Went Wrong...!";
       header("Refresh:1.0; url=index.php?folder=configuration&file=teacher_assign_view");
     }
     
 } 



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Cast Add Code ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 if(isset($_POST['cast_det_submit']))
 {
     extract($_POST);
     $today_date = date('Y-m-d');
     
     if(isset($_GET['edit_id']) && $_GET['edit_id']!='')
     {
         $edit_id=$_GET['edit_id'];

         $update=$db->query("UPDATE cast_details SET cast_name='$cast_name' WHERE cst_id='$edit_id'");

         if($update)
         {
             global $succ;
             $succ= "Category Updated Successfully..!";
             header("Refresh:0.5; url=index.php?folder=configuration&file=new_cast_view");
         }
         else
         {
           global $msg;
           $msg= "Something Went Wrong...!";
           header("Refresh:0.5; url=index.php?folder=configuration&file=new_cast_view");
         }
     }
     else
     {
         $chkusertype= $db->get_var("SELECT COUNT(*) FROM cast_details WHERE cast_name='$cast_name'");

         if ($chkusertype>0)
         { 
             $isexist=1;
         }
         else
         {

             $sql="INSERT INTO cast_details VALUES('','".$_SESSION['ad_id']."','$cast_name','$today_date','')";

             $insert=$db->query($sql);

             if($insert)
             {
               global $succ;
               $succ= "Category Added Successfully..!";
               header("Refresh:0.5; url=index.php?folder=configuration&file=new_cast_view");
             }
             else
             {
               global $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:0.5; url=index.php?folder=configuration&file=new_cast_view");
             }
         }
     }
 }



 if(isset($_GET['cst_del_id']) && $_GET['cst_del_id']!=''){

     $cst_del_id = $_GET['cst_del_id'];

     $delbk="DELETE FROM cast_details WHERE cst_id='$cst_del_id'";

     $delete = $db->query($delbk);

     if($delete)
     {
         global $succ;
         $succ= "Category Details Deleted Successfully..!";
         header("Refresh:0.5; url=index.php?folder=configuration&file=new_cast_view");
     }
     else
     {
       global $msg;
       $msg= "Something Went Wrong...!";
       header("Refresh:0.5; url=index.php?folder=configuration&file=new_cast_view");
     }
 }



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Cast Sub Category Add Code ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 if(isset($_POST['sub_category_submit']))
 {
     extract($_POST);
     $today_date = date('Y-m-d');
     
     if(isset($_GET['sub_cat_edit_id']) && $_GET['sub_cat_edit_id']!='')
     {
         $sub_cat_edit_id=$_GET['sub_cat_edit_id'];

         $update=$db->query("UPDATE cast_category_details SET cst_id='$cast_id',cast_category_name='$sub_cat_name' WHERE cc_id='$sub_cat_edit_id'");

         if($update)
         {
             global $succ;
             $succ= "Cast Details Updated Successfully..!";
             header("Refresh:0.5; url=index.php?folder=configuration&file=cast_subcate_view");
         }
         else
         {
           global $msg;
           $msg= "Something Went Wrong...!";
           header("Refresh:0.5; url=index.php?folder=configuration&file=cast_subcate_view");
         }
     }
     else
     {
         $chkusertype= $db->get_var("SELECT COUNT(*) FROM cast_category_details WHERE cst_id='$cast_id' AND cast_category_name='$sub_cat_name'");

         if ($chkusertype>0)
         { 
             $isexist=1;
         }
         else
         {

             $sql="INSERT INTO cast_category_details VALUES('','".$_SESSION['ad_id']."','$cast_id','$sub_cat_name','$today_date','')";

             $insert=$db->query($sql);

             if($insert)
             {
               global $succ;
               $succ= "New Cast Added Successfully..!";
               header("Refresh:0.5; url=index.php?folder=configuration&file=cast_subcate_view");
             }
             else
             {
               global $msg;
               $msg= "Something Went Wrong...!";
               header("Refresh:0.5; url=index.php?folder=configuration&file=cast_subcate_view");
             }
         }
     }
 }



 if(isset($_GET['del_sub_cat_id']) && $_GET['del_sub_cat_id']!=''){

     $del_sub_cat_id = $_GET['del_sub_cat_id'];

     $delbk="DELETE FROM cast_category_details WHERE cc_id='$del_sub_cat_id'";

     $delete = $db->query($delbk);

     if($delete)
     {
         global $succ;
         $succ= "Cast Details Deleted Successfully..!";
         header("Refresh:0.5; url=index.php?folder=configuration&file=cast_subcate_view");
     }
     else
     {
       global $msg;
       $msg= "Something Went Wrong...!";
       header("Refresh:0.5; url=index.php?folder=configuration&file=cast_subcate_view");
     }
 }

?>