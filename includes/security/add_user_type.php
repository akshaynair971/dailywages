<?php 
  $r=$db->get_results("SELECT * FROM institute");  
?>
<?php

    if(isset($_GET['edit_user_type']) && $_GET['edit_user_type']!='')
    {
        $ed_id = $_GET['edit_user_type'];
        $user_edit = $db->get_row("SELECT * FROM user_type WHERE usr_id='$ed_id'");
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
                        <label for="exampleInputEmail1">User Type<span style="color: #e22b0e;">(*)</span></label>
                        <input type="text" class="form-control" id='usr_type'  name='usr_type' placeholder="Enter User Type" required="" value="<?php if(isset($user_edit)){ echo $user_edit->usr_type; } ?>">
                          
                  </div>
                  
                  <div class="form-group">
                        <input type="submit" value="Save" class="btn btn-success" name="save_user_type">
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
  