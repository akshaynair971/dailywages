<?php             
if(isset($_GET['edit_id']))
  {
    $id=$_GET['edit_id'];
    $r=$db->get_row("SELECT * FROM send_sms_setting WHERE snd_sms_id='$id'");
  }
?>

<style type="text/css">
  .req-color
  {
    color: red;
  }
</style>
            <section class="content">
              <form method="POST">
            
               <div class="box-header">
               <h3 class="box-title"><b> Send SMS Setting Details</b></h3>
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
               </div>
      
               <div class="col-lg-6 col-md-6 col-sm-12" >
               <div class="box box-default">

               <div class="box-body">

                  <div class="form-group">
                      <label>Set User Registration SMS <span class="req-color">*</span></label>
                      <textarea type="text" class="form-control" id="usr_regi_sms" placeholder="Set User Registration SMS" name="usr_regi_sms" rows="3" required><?php if(isset($r)){echo $r->emp_regi_sms; }?></textarea>
                  </div>

                   <div class="form-group">
                      <label>Set Employee Attendance SMS <span class="req-color">*</span></label>
                     <textarea type="text" class="form-control" id="emp_atten_sms" placeholder="Set Employee Attendance SMS" name="emp_atten_sms" rows="3" required><?php if(isset($r)){echo $r->emp_atten_sms; }?></textarea>
                  </div>

                   <div class="form-group">
                      <label>Set Student Registration SMS <span class="req-color">*</span></label>
                      <textarea type="text" class="form-control" id="stud_regi_sms" placeholder="Set Student Registration SMS" name="stud_regi_sms" rows="3" required><?php if(isset($r)){echo $r->stud_regi_sms; }?></textarea>
                  </div>

                  <div class="form-group">
                      <label>Set Student Admission SMS <span class="req-color">*</span></label>
                      <textarea type="text" class="form-control" id="stud_admi_sms" placeholder="Set Student Admission SMS" name="stud_admi_sms" rows="3" required><?php if(isset($r)){echo $r->stud_admi_sms; }?></textarea>
                  </div>

                  <div class="form-group">
                      <label>Set Student Attendance SMS <span class="req-color">*</span></label>
                      <textarea type="text" class="form-control" id="stud_atten_sms" placeholder="Set Student Attendance SMS" name="stud_atten_sms" rows="3" required><?php if(isset($r)){echo $r->stud_atten_sms; }?></textarea>
                  </div>
               
               </div>  
            </div>
          </div>
      
             <div class="col-lg-6 col-md-6 col-sm-12" >
             <div class="box box-default">

             <div class="box-body">

                <div class="form-group">
                    <label>Set Payment SMS <span class="req-color">*</span></label>
                    <textarea type="text" class="form-control" id="pay_sms" placeholder="Set Payment SMS" name="pay_sms" rows="3" required><?php if(isset($r)){echo $r->payment_sms; }?></textarea>
                </div>

                 <div class="form-group">
                    <label>Set Employee Salery SMS <span class="req-color">*</span></label>
                   <textarea type="text" class="form-control" id="emp_sal_sms" placeholder="Enter Set Employee Salery SMS" name="emp_sal_sms" rows="3" required><?php if(isset($r)){echo $r->emp_salery_gen_sms; }?></textarea>
                </div>

                 <div class="form-group">
                    <label>Set Test Mark Send SMS <span class="req-color">*</span></label>
                    <textarea type="text" class="form-control" id="stud_tst_sms" placeholder="Set Test Mark Send SMS" name="stud_tst_sms" rows="3" required><?php if(isset($r)){echo $r->test_mark_snd_sms; }?></textarea>
                </div>

                <div class="form-group">
                    <label>Set Home Work SMS <span class="req-color">*</span></label>
                    <textarea type="text" class="form-control" id="stud_hw_sms" placeholder="Enter Sender Name" name="stud_hw_sms" rows="3" required><?php if(isset($r)){echo $r->homework_sms; }?></textarea>
                </div>
                <br><br>
                <div class="form-group">
                    <input type="submit" value="Submit Details" class="btn btn-primary btn-round" name="send_sms_setting">&nbsp;

                    <a href="?folder=admin&file=set_sms_view" class="btn btn-primary btn-round">Go Back</a>
                </div><br>
             
             </div>  
          </div>
        </div>  
      </form>
  </section>