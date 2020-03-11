<?php

    if(isset($_GET['edit_ins']) && $_GET['edit_ins']!='')
    {
        $ed_id = $_GET['edit_ins'];
        $ins_edit = $db->get_row("SELECT * FROM institute WHERE inst_id='$ed_id'");
    }
?>
<!-- Main content -->
    <section class="content"> 
      <div class="row">
        <!-- <div class="col-md-2 col-lg-2"></div> -->
        <div class="col-md-12 col-lg-12">
         
          <div class="box">
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
              <h3>General Setting</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="POST" action="">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Institution Name <span style="color: #e22b0e;">*</span></label>
                        <input type="text" class="form-control" id='ins_name'  name='ins_name' placeholder="Enter Institution Name" value="<?php if(isset($ins_edit)){ echo $ins_edit->inst_name; } ?>" required="">
                          
                  </div>
                  <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Address <span style="color: #e22b0e;">*</span></label>
                        <textarea class="form-control" id='address' name='address' placeholder="Enter Address" rows="4" required><?php if(isset($ins_edit)){ echo $ins_edit->inst_address; } ?></textarea>
                  </div>

                  <div class="form-group col-md-12" style="border:1px solid; border-color: #2a586f; border-radius: 8px;"><br>

                    <label for="exampleInputEmail1" style="font-size: 17px;"> Get Permission To Institution <span style="color: #e22b0e;">*</span></label><br>

                    <!-- <select data-placeholder="Select Institution Permission..." multiple class="chosen-select form-control" name="tabs_id[]"> -->
                        <!-- <option value="">Select Permission</option> -->
                     <!--  <?php 
                        $get_tab = $db->get_results("SELECT * FROM tab_allow_tbl");

                        $tab_data = explode(',',$ins_edit->tab_permission);

                        if($get_tab){
                          foreach($get_tab as $tab){
                              if ($tab->tb_allow_id!=9 && $tab->tb_allow_id!=12 && $tab->tb_allow_id!=38){ 
                      ?>
                        <option value="<?php echo $tab->tb_allow_id; ?>" <?php if(in_array($tab->tb_allow_id, $tab_data)){ echo 'selected'; } ?>><?php echo $tab->tab_title; ?></option>
                      <?php } } } ?>
                    </select> -->

                    <label class="col-md-4">
                    <input type="checkbox" id="checkAll"> Select All </label>

                    <?php
                     $tab_data = explode(',',$ins_edit->tab_permission);
                      if($get_tab){
                        foreach($get_tab as $tab){
                            if ($tab->tb_allow_id!=9 && $tab->tb_allow_id!=12 && $tab->tb_allow_id!=38){ 
                    ?>
                    <label class="col-md-4">
                    <input type="checkbox" name="tabs_id[]" value="<?php echo $tab->tb_allow_id; ?>" <?php if(in_array($tab->tb_allow_id, $tab_data)){ echo 'checked'; } ?>> <?php echo $tab->tab_title; ?></label>

                    <?php } } } ?>

                  </div>

                  <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Username <span style="color: #e22b0e;">*</span></label>
                        <input type="text" class="form-control" id='username'  name='username' placeholder="Enter Full Name" required="" value="<?php if(isset($ins_edit)){ echo $ins_edit->inst_user; } ?>">
                          
                  </div>
                  <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Password <span style="color: #e22b0e;">*</span></label>
                        <input type="text" class="form-control" id='password'  name='password' placeholder="Enter Mobile Number" required="" value="<?php if(isset($ins_edit)){ echo $ins_edit->inst_password; } ?>">
                          
                  </div>
                  
                  <div class="form-group col-md-12">
                      <input type="submit" value="Submit" class="btn btn-primary btn-round" name="institute">
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

    <script>
      $(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!"
      })
    </script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script>
        $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
  });

</script>    