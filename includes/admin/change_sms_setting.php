<style type="text/css">
  .form-control{
    border-radius: 7px !important;
  }
  .req-color
  {
    color: red;
  }
</style>
<form method="POST">
<section class="content">
          <div class="row">
            <!-- left column -->
            
            
            <div class="col-md-6">

              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
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
                </div><!-- /.box-header -->
             <div class="box-body">


              <?php
              
              if(isset($msg))
{
  echo $msg;
}

              
if(isset($_GET['edit_id']))
{
  $id=$_GET['edit_id'];
  $r=$db->get_row("SELECT * FROM sms_setting WHERE sms_id='$id'");
  }
  ?>

  

                  <div class="form-group">
                      <label>SMS Sender Name (<span class="req-color">*</span>)</label>
                      <input type="text" class="form-control" id="sender_name" placeholder="Enter Sender Name"  name="sender_name" required value="<?php if(isset($r)){echo $r->sms_sender_name; }?>">
                  </div>

                   <div class="form-group">
                      <label>SMS User Name (<span class="req-color">*</span>)</label>
                      <input type="text" class="form-control" id="user_name" placeholder="Enter user Name" required  name="user_name" value="<?php if(isset($r)){echo $r->sms_username; }?>">
                  </div>

                   <div class="form-group">
                      <label>SMS Password (<span class="req-color">*</span>)</label>
                      <input type="text" class="form-control" id="password" placeholder="Enter Password" required  name="password" value="<?php if(isset($r)){echo $r->sms_password; }?>">
                  </div>

                      <input type="hidden" value="<?php echo $r->sms_id; ?>" name="setting_id">

                      <input type="submit" class="btn btn-primary" name="sms_setting">
                    
             
             </div>
                  </div>


            </div>

            </section>

        </form>
        