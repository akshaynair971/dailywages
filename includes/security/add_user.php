<?php 
  $r=$db->get_results("SELECT * FROM institute");  
?>
<?php

    if(isset($_GET['edit_user']) && $_GET['edit_user']!='')
    {
        $ed_id = $_GET['edit_user'];
        $user_edit = $db->get_row("SELECT * FROM user WHERE user_id='$ed_id'");
    }
?>
<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-2 col-lg-2"></div>
        <div class="col-md-7 col-lg-7">
          
          <div class="box">
            <div class="box-header">
              <h3>User Setting</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                        <label for="exampleInputEmail1">Institution Name<span style="color: #e22b0e;">(*)</span></label>
                        <select class="form-control" id='ins_name'  name='ins_name' placeholder="" required="" value="">
                          <option value="">---Select Institute---</option>
                          <?php 
                            if($r) {
                                foreach ($r as $rw) {
                            ?>
                          <option value="<?php echo $rw->inst_id; ?>"<?php if($rw->inst_id==$user_edit->inst_id){ echo "selected";} ?> ><?php echo $rw->inst_name; ?></option>
                          <?php }  ?>
                          <?php }  ?>
                        </select>
                          
                  </div>
                  <div class="form-group">
                        <label for="exampleInputEmail1">Full Name<span style="color: #e22b0e;">(*)</span></label>
                        <input type="text" class="form-control" id='name'  name='name' placeholder="Enter Full Name" required="" value="<?php if(isset($user_edit)){ echo $user_edit->user_name; } ?>">
                          
                  </div>
                  <div class="form-group">
                        <label for="exampleInputEmail1">Mobile Number<span style="color: #e22b0e;">(*)</span></label>
                        <input type="text" class="form-control" id='mob'  name='mob' placeholder="Enter Mobile Number" required="" value="<?php if(isset($user_edit)){ echo $user_edit->user_mob; } ?>">
                          
                  </div>
                  <div class="form-group">
                        <label for="exampleInputEmail1">Address<span style="color: #e22b0e;">(*)</span></label>
                        <input type="text" class="form-control" id='address'  name='address' placeholder="Enter Address" required="" value="<?php if(isset($user_edit)){ echo $user_edit->user_address; } ?>">
                          
                  </div>
                  <div class="form-group">
                        <label for="exampleInputEmail1">E-mail<span style="color: #e22b0e;">(*)</span></label>
                        <input type="text" class="form-control" id='email' name='email' placeholder="Enter E-mail Id" required="" value="<?php if(isset($user_edit)){ echo $user_edit->user_email; } ?>">
                          
                  </div>
                  <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <label for="exampleInputEmail1">User Profile<span style="color: #e22b0e;">(*)</span></label>
                        <input type="file" onchange="readURL(this);" class="form-control" id='profile'  name='profile' placeholder="">
                          
                  </div>
                  <label for="exampleInputEmail1">Profile Preview </label>
                  <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        
                        <img src="./images/user_profile/<?php if(isset($user_edit)){ echo $user_edit->user_profile; } ?>" class="img-rounded" id='profile_preview' onerror="this.src='images/pre.png'"  name='profile_preview' placeholder="" style="border:2px solid #d2d6de; height: 120px; width: 230px;">
                          
                  </div>
                  <div class="form-group">
                        <input type="submit" value="Save" class="btn btn-success" name="save_user">
                        <!-- <input type="submit" value="Save" class="btn btn-success" name="update"> -->


                  </div>
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

    <!-- rich text editor -->
    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
    <script type="text/javascript">
      bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
    </script>
    <!-- end editor -->

    <!-- image display -->
    <script type="text/javascript">
        function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function (e) {
                      $('#profile_preview')
                          .attr('src', e.target.result);
                  };

                  reader.readAsDataURL(input.files[0]);
              }
          }
    </script>
    <!-- end img display -->
  