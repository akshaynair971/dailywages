<?php 

    // $inst_id =$_SESSION['inst_id'];

    if($_SESSION['user_type']=='1')  
    {
        $r=$db->get_row("SELECT * FROM general_setting WHERE user_type='1'");
    }
    // if($_SESSION['user_type']=='2')
    // {
    //     $r=$db->get_row("SELECT * FROM general_setting WHERE inst_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."'");
    // }
     
?>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-7 col-lg-7">
     
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
          <form method="POST" action="" enctype="multipart/form-data">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label for="exampleInputEmail1">Institution / Company Name <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='name' name='institution_name' placeholder="Enter Institution Name" value="<?php echo $r->ins_name; ?>" required>
                      
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Institution / Company Tag Line <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='tag_line'  name='tag_line' placeholder="Enter Institution Tag Line" value="<?php echo $r->ins_tagline; ?>" required>
                      
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Mobile Number <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='mob_no' name='mob_no' placeholder="Enter Mobile Number" maxlength="10" pattern="[0-9]{10}" onkeypress="return isNumberKey(event)" pattern="^\S{10,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Mobile No Must Be of 10 Digits' : '');" value="<?php echo $r->ins_mob; ?>" required>
                      
              </div>
              <!-- <div class="form-group">
                    <label for="exampleInputEmail1">Serial No.<span style="color: #e22b0e;">*</span></label>
                    <input type="text" class="form-control" id='serial_no' name='serial_no' placeholder="Enter Serial Number"  value="<?php echo $r->serial_no; ?>" >                          
              </div> -->
              <!-- <div class="form-group">
                    <label for="exampleInputEmail1">Affiliate No. (संलग्नता क्र.)<span style="color: #e22b0e;">*</span></label>
                    <input type="text" class="form-control" id='affiliate_no' name='affiliate_no' placeholder="Enter Affiliate Number"  value="<?php echo $r->affiliate_no; ?>" required>                          
              </div> -->
              <div class="form-group">
                <label for="exampleInputEmail1">Establishment Date<span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='datepicker1' name='establishment_date' placeholder="Enter Udise Number"  value="<?php echo $r->establishment_date; ?>" required>                          
              </div>
              
              <!-- <div class="form-group">
                    <label for="exampleInputEmail1">UDISE No.<span style="color: #e22b0e;">*</span></label>
                    <input type="text" class="form-control" id='udise_no' name='udise_no' placeholder="Enter Udise Number"  value="<?php echo $r->udise_no; ?>" required>                          
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Board<span style="color: #e22b0e;">*</span></label>
                    <input type="text" class="form-control" id='school_board' name='school_board' placeholder="Enter School Board"  value="<?php echo $r->school_board; ?>" required>                          
              </div> -->
              
              <div class="form-group">
                <label for="exampleInputEmail1">Institution / Company Address <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='address'  name='address' placeholder="Enter Mobile Number" required="" value="<?php echo $r->ins_address; ?>">
                      
              </div>
            
              <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <label for="exampleInputEmail1"> Institution / Company Logo <span style="color: #e22b0e;">*</span></label>
                <input type="file" onchange="readURL(this);" class="form-control" id='logo'  name='logo' placeholder="">
                      
              </div>

              <label for="exampleInputEmail1">Logo Preview </label>
              <?php if(isset($_SESSION['ad_id']) && isset($_SESSION['user_type'])){?>
              <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <img src="./images/logo/<?php echo $r->ins_logo; ?>" onerror="this.src='./images/pre.png'" class="img-rounded" id='logo_preview' name='logo_preview' placeholder="" style="border:2px solid #d2d6de; height: 100px; width: 150px;"> 
              </div>
              <?php } ?>
              <div class="form-group">
                <label for="exampleInputEmail1">Terms And Conditions Of Institution <span style="color: #e22b0e;">*</span></label>
                <textarea class="form-control" id='terms_condi'  name='terms_condi'><?php echo $r->terms_condi; ?></textarea>                          
              </div>
              <div class="form-group">
                    <!-- <input type="submit" value="Save" class="btn btn-success" name="save"> -->
                    <input type="submit" value="Submit" class="btn btn-primary btn-round" name="update">
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
                      $('#logo_preview')
                          .attr('src', e.target.result);
                  };

                  reader.readAsDataURL(input.files[0]);
              }
          }
    </script>
    <!-- end img display -->
  

<!-- script for phone number  -->
<script type="text/javascript">
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31
    && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
</script>
<!--//contact-->