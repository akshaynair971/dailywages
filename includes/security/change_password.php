<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-2 col-lg-2"></div>
        <div class="col-md-7 col-lg-7">
          
          <div class="box">
            <div class="box-header">
              <h3>Change Password</h3>
            </div>


          <?php  
             if(isset($msg))
            {
              echo"<div style='font-size:18px; color:red; margin-left:15px; font-weight:700;'>".$msg."</div>";
            }
            if(isset($succ))
            {
              echo"<div style='font-size:18px; color:green; margin-left:15px; font-weight:700;'>".$succ."</div>";
            }

            
            if(isset($_SESSION['ad_id']) && $_SESSION['user_type']=='1')
            {
              $pass = $db->get_row("SELECT * FROM admin WHERE ad_id='".$_SESSION['ad_id']."'");
            }

            else if(isset($_SESSION['ad_id']) && $_SESSION['user_type']=='2')
            {
              $pass1 = $db->get_row("SELECT * FROM dw_user_login WHERE DUL_USER_ID='".$_SESSION['ad_id']."'");
            }

            
            
          ?>


            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" action="" enctype="multipart/form-data">
                
                  <div class="form-group">
                        <label for="exampleInputEmail1">Old Password <span style="color: #e22b0e;">*</span></label>
                        <input type="text" class="form-control" id='oldpassword'  name='oldpassword' placeholder="Enter Old Password" required="" value="<?php if(isset($_SESSION['ad_id']) && $_SESSION['user_type']=='1'){ echo $pass->ad_password; } elseif (isset($_SESSION['ad_id']) && $_SESSION['user_type']=='2'){ echo $pass1->DUL_USER_PASSWORD; }  ?>" autocomplete="off" readonly>
                          
                  </div>

                  <div class="form-group">
                        <label for="exampleInputEmail1">New Password <span style="color: #e22b0e;">*</span></label>
                        <input type="password" class="form-control" id='newpassword'  name='newpassword' placeholder="Enter Password" required="" value="" autocomplete="off">
                          
                  </div>

                  <div class="form-group">
                        <label for="exampleInputEmail1">Confirm Password <span style="color: #e22b0e;">*</span></label>
                        <input type="password" class="form-control" id='newpassword2'  name='newpassword2' placeholder="Enter Confirm Password" required="" value="" autocomplete="off">
                          
                  </div>
                  
                  <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-primary btn-round" name="password_change">
                        
                  </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->