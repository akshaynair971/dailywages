<?php
$user_edit = $db->get_row("SELECT * FROM dw_employee_master as a LEFT JOIN dw_user_login as b ON a.DEM_EMP_ID=b.DEM_EMP_ID LEFT JOIN dw_payroll_master as c ON  a.DEM_EMP_ID=c.DEM_EMP_ID  WHERE a.DEM_ID='".$_SESSION['ad_id']."'");
// $db->debug();
?>
<!-- Main content -->
<section class="content">
  <div class="row">        
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
          <h3>Profile </h3>
          <div class="box-tools">
            <!-- <a href="?folder=employees&file=employee_list" class="btn btn-default btn-round">Go Back</a> -->
          </div>
        </div>
            <!-- /.box-header -->
        <div class="box-body">
          <form method="POST" action="" enctype="multipart/form-data">
            <div class="col-md-12 col-sm-12 col-xs-12">   
              <div class="form-group col-md-12">
                <h3>Basic Details</h3>
                <hr style="border: 1px solid;">
              </div>
              <div class="form-group col-md-6"> 
                
                <img src="images/user_profile/<?php if($user_edit->DEM_EMP_ID!=''){ echo $user_edit->DEM_EMP_ID.'.jpg'; } ?>" class="img-rounded" id='profile_preview' onerror="this.src='images/user.jpg'"  style="border:2px solid #d2d6de; height: 150px; width: 140px;">   
              </div>
              <div class="form-group col-md-6"> 
                
                <img src="images/user_profile/<?php if($user_edit->DEM_EMP_ID!=''){ echo $user_edit->DEM_EMP_ID.'_SIGN.jpg'; } ?>" class="img-rounded" id='profile_preview' onerror="this.src='images/sign.jpg'"  style="border:2px solid #d2d6de; height: 150px; width: 140px;">   
              </div>
              <div class="form-group col-md-3">
                <label for="DEM_EMP_NAME_PREFIX">Prefix <span style="color: #e22b0e;">*</span></label>
                <select class="form-control" id='DEM_EMP_NAME_PREFIX'  name='DEM_EMP_NAME_PREFIX' required readonly>
                  <option value="">Select Prefix</option>
                  <option value="MR." <?php if($user_edit->DEM_EMP_NAME_PREFIX=="MR."){ echo "selected"; } ?> >MR.</option>
                  <option value="MRS." <?php if($user_edit->DEM_EMP_NAME_PREFIX=="MRS."){ echo "selected"; } ?> >MRS.</option>
                  <option value="MS." <?php if($user_edit->DEM_EMP_NAME_PREFIX=="MS."){ echo "selected"; } ?> >MS.</option>
                </select>  
              </div>
              <div class="form-group col-md-3">
                <label for="DEM_EMP_FIRST_NAME">First Name <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DEM_EMP_FIRST_NAME'  name='DEM_EMP_FIRST_NAME' placeholder="Enter First Name" value="<?php if(isset($user_edit)){ echo $user_edit->DEM_EMP_FIRST_NAME; } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label for="DEM_EMP_MIDDLE_NAME">Middle Name <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DEM_EMP_MIDDLE_NAME'  name='DEM_EMP_MIDDLE_NAME' placeholder="Enter Middle Name" value="<?php if(isset($user_edit)){ echo $user_edit->DEM_EMP_MIDDLE_NAME; } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label for="DEM_EMP_LAST_NAME">Last Name <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DEM_EMP_LAST_NAME'  name='DEM_EMP_LAST_NAME' placeholder="Enter Last Name" value="<?php if(isset($user_edit)){ echo $user_edit->DEM_EMP_LAST_NAME; } ?>" required readonly>  
              </div>

              <div class="form-group col-md-3">
                <label class="control-label">Gender <span style="color: #e22b0e;">*</span> </label>
                <select class="form-control" id='DEM_EMP_GENDER'  name='DEM_EMP_GENDER' required readonly>
                  <option value="">Select Gender</option>
                  <option value="MALE" <?php if($user_edit->DEM_EMP_GENDER=="MALE"){ echo "selected"; } ?>  >MALE</option>
                  <option value="FEMALE" <?php if($user_edit->DEM_EMP_GENDER=="FEMALE"){ echo "selected"; } ?>  >FEMALE</option>
                  <option value="TRANSGENDER" <?php if($user_edit->DEM_EMP_GENDER=="TRANSGENDER"){ echo "selected"; } ?>  >TRANSGENDER</option>
                </select>                  
              </div>

              <div class="form-group col-md-3">
                <label for="DEM_EMP_DOB">Date Of Birth <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control DEM_EMP_DOB" id='datepicker1'  name='DEM_EMP_DOB' placeholder="Choose Date Of Birth" value="<?php if(isset($user_edit)){ echo date('d-M-Y',strtotime($user_edit->DEM_EMP_DOB)); } ?>" required autocomplete="off" onchange="GetAge();" readonly>
              </div>              

              <div class="form-group col-md-3">
                <label for="DEM_EMP_AGE">Employee Age <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control DEM_EMP_AGE" id='DEM_EMP_AGE'  name='DEM_EMP_AGE' placeholder="Enter Employee Age" value="<?php if(isset($user_edit)){ echo $user_edit->DEM_EMP_AGE; } ?>" required readonly>
              </div>

              <div class="form-group col-md-3">
                <label for="DEM_MOBILE_NUMBER">Mobile Number <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DEM_MOBILE_NUMBER'  name='DEM_MOBILE_NUMBER' placeholder="Enter Mobile Number" maxlength="10"  onkeypress="return isNumberKey(event)" pattern="^\S{10,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Mobile No Must Be of 10 Digits' : '');" value="<?php if(isset($user_edit)){ echo $user_edit->DEM_MOBILE_NUMBER; } ?>" required readonly>
              </div>

              <div class="form-group col-md-3">
                <label for="DEM_ALTERNATE_MOBILE_NUMBER">Alternate Phone Number </label>
                <input type="text" class="form-control" id='DEM_ALTERNATE_MOBILE_NUMBER'  name='DEM_ALTERNATE_MOBILE_NUMBER' placeholder="Enter Alternate Phone Number" maxlength="10"  onkeypress="return isNumberKey(event)" pattern="^\S{10,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Mobile No Must Be of 10 Digits' : '');" value="<?php if(isset($user_edit)){ echo $user_edit->DEM_ALTERNATE_MOBILE_NUMBER; } ?>" readonly >
              </div>             

              <div class="form-group col-md-3">
                <label for="DEM_PERSONAL_EMAIL_ID">Personal E-mail </label>
                <input type="email" class="form-control" id='DEM_PERSONAL_EMAIL_ID' name='DEM_PERSONAL_EMAIL_ID' placeholder="Enter Personal E-mail ID." value="<?php if(isset($user_edit)){ echo $user_edit->DEM_PERSONAL_EMAIL_ID; } ?>" readonly > 
              </div>

              <div class="form-group col-md-3">
                <label for="DEM_OFFICIAL_EMAIL_ID">Official E-mail </label>
                <input type="email" class="form-control" id='DEM_OFFICIAL_EMAIL_ID' name='DEM_OFFICIAL_EMAIL_ID' placeholder="Enter Official E-mail ID." value="<?php if(isset($user_edit)){ echo $user_edit->DEM_OFFICIAL_EMAIL_ID; } ?>" readonly > 
              </div>       

              <div class="form-group col-md-9">
                <label for="DEM_CURRRENT_ADDRESS">Current Address <span style="color: #e22b0e;">*</span></label>
                <textarea class="form-control" id='DEM_CURRRENT_ADDRESS'  name='DEM_CURRRENT_ADDRESS' placeholder="Enter Current Address" rows="3" required readonly><?php if(isset($user_edit)){ echo $user_edit->DEM_CURRRENT_ADDRESS; } ?></textarea>  
              </div>  

              <div class="form-group col-md-3">
                <label for="DEM_CA_PINCODE">Pin Code <span style="color: #e22b0e;">*</span> </label>
                <input type="text" class="form-control" id='DEM_CA_PINCODE' name='DEM_CA_PINCODE' placeholder="Enter Current Address Pin Code" value="<?php if(isset($user_edit)){ echo $user_edit->DEM_CA_PINCODE; } ?>" required onkeypress="return isNumberKey(event)" maxlength="6" readonly> 
              </div>

              <div class="form-group col-md-9">
                <label for="DEM_PERMANENT_ADDRESS">Permanant Address <span style="color: #e22b0e;">*</span> </label>
                <textarea class="form-control" id='DEM_PERMANENT_ADDRESS'  name='DEM_PERMANENT_ADDRESS' placeholder="Enter Permanant Address" rows="3" required readonly><?php if(isset($user_edit)){ echo $user_edit->DEM_PERMANENT_ADDRESS; } ?></textarea>  
              </div>

              <div class="form-group col-md-3">
                <label for="DEM_PA_PINCODE">Pin Code <span style="color: #e22b0e;">*</span> </label>
                <input type="text" class="form-control" id='DEM_PA_PINCODE' name='DEM_PA_PINCODE' placeholder="Enter Permanant Address Pin Code" value="<?php if(isset($user_edit)){ echo $user_edit->DEM_PA_PINCODE; } ?>" required  onkeypress="return isNumberKey(event)" maxlength="6" readonly> 
              </div>   

              <div class="form-group col-md-4">
                <label for="DEM_ADHAR_ID">Adhar No. <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DEM_ADHAR_ID' name='DEM_ADHAR_ID' placeholder="Enter Adhar No." value="<?php if(isset($user_edit)){ echo $user_edit->DEM_ADHAR_ID; } ?>" maxlength="16" onkeypress="return isNumberKey(event)" pattern="^\S{10,}$" required readonly> 
              </div>      

              <div class="form-group col-md-3">
                <label for="DEM_PAN_ID">PAN No. <span style="color: #e22b0e;">*</span></label>
                <input type="text" class="form-control" id='DEM_PAN_ID' name='DEM_PAN_ID' placeholder="Enter PAN No." value="<?php if(isset($user_edit)){ echo $user_edit->DEM_PAN_ID; } ?>" required readonly> 
              </div>

              <div class="form-group col-md-2">
                <label for="DEM_START_DATE">Date of Joining <span style="color: #e22b0e;">*</span> </label>
                <input type="text" class="form-control" id='DEM_START_DATE' name='DEM_START_DATE' placeholder="Enter Joining Date" value="<?php if(isset($user_edit)){ echo date('d-M-Y',strtotime($user_edit->DEM_START_DATE)); } ?>" required autocomplete="false" readonly> 
              </div>          

              <div class="form-group col-md-3">
                <label class="control-label">Status <span style="color: #e22b0e;">*</span> </label>
                <select class="form-control" id='DEM_ACTIVE_FLAG'  name='DEM_ACTIVE_FLAG' required onchange="enable_end_date();" readonly>
                  <option value="">Select Status</option>
                  <option value="ACTIVE" <?php if($user_edit->DEM_ACTIVE_FLAG=="ACTIVE"){ echo "selected"; } ?>  >ACTIVE</option>
                  <option value="INACTIVE" <?php if($user_edit->DEM_ACTIVE_FLAG=="INACTIVE"){ echo "selected"; } ?>  >INACTIVE</option>
                  
                </select>                  
              </div>

              <div class="form-group col-md-3" style="display: none;">
                <label for="DEM_END_DATE">Date of Relieving<span style="color: #e22b0e;">*</span> </label>
                <input type="text" class="form-control" id='DEM_END_DATE' name='DEM_END_DATE' placeholder="Enter Relieving Date" value="<?php if(isset($user_edit)){ echo date('d-M-Y',strtotime($user_edit->DEM_END_DATE)); } ?>" autocomplete="off" readonly> 
              </div>

              <div class="form-group col-md-12">
                <h3>Payroll Details</h3>
                <hr style="border: 1px solid;">
              </div>

              <div class="form-group col-md-3">
                <label class="control-label">Role <span style="color: #e22b0e;">*</span> </label>
                <select class="form-control" id='DUL_USER_ROLE'  name='DUL_USER_ROLE' required readonly>
                  <option value="">Select Role</option>
                  <option value="permanant" <?php if($user_edit->DUL_USER_ROLE=="permanant"){ echo "selected"; } ?>  >Permanant</option>
                  <option value="contract" <?php if($user_edit->DUL_USER_ROLE=="contract"){ echo "selected"; } ?>>Contract Basis</option>
                  
                </select>                  
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_RATE">Payrole Rate  </label>
                <input type="text" class="form-control" id='DPM_RATE' name='DPM_RATE' placeholder="Enter Payrole Rate" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_RATE; } ?>" readonly> 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_BASIC_SALARY">Basic Salary  </label>
                <input type="text" class="form-control" id='DPM_BASIC_SALARY' name='DPM_BASIC_SALARY' placeholder="Enter Basic Salary" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_BASIC_SALARY; } ?>" readonly > 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_HRA">HRA  </label>
                <input type="text" class="form-control" id='DPM_HRA' name='DPM_HRA' placeholder="Enter HRA" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_HRA; } ?>" readonly > 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_OTHER_ALLOWANCE">Other Allowance  </label>
                <input type="text" class="form-control" id='DPM_OTHER_ALLOWANCE' name='DPM_OTHER_ALLOWANCE' placeholder="Enter Other Allowance" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_OTHER_ALLOWANCE; } ?>" readonly> 
              </div>

              <!-- <div class="form-group col-md-3">
                <label for="DPM_SPECIAL_ALLOWANCE">Special Allowance  </label>
                <input type="text" class="form-control" id='DPM_SPECIAL_ALLOWANCE' name='DPM_SPECIAL_ALLOWANCE' placeholder="Enter Special Allowance" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_SPECIAL_ALLOWANCE; } ?>" readonly> 
              </div> -->

              <div class="form-group col-md-3">
                <label for="DPM_GROSS_WAGES_PAYABLE">Gross Wages Payable  </label>
                <input type="text" class="form-control" id='DPM_GROSS_WAGES_PAYABLE' name='DPM_GROSS_WAGES_PAYABLE' placeholder="Enter Gross Wages Payable" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_GROSS_WAGES_PAYABLE; } ?>" readonly > 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_PROFESSIONAL_TAX">Professional Tax  </label>
                <input type="text" class="form-control" id='DPM_PROFESSIONAL_TAX' name='DPM_PROFESSIONAL_TAX' placeholder="Enter Professional Tax" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_PROFESSIONAL_TAX; } ?>" readonly> 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_PF_EMPLOYEE">Employee PF </label>
                <input type="text" class="form-control" id='DPM_PF_EMPLOYEE' name='DPM_PF_EMPLOYEE' placeholder="Enter Employee PF" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_PF_EMPLOYEE; } ?>" readonly> 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_PF_EMPLOYER">Employer PF </label>
                <input type="text" class="form-control" id='DPM_PF_EMPLOYER' name='DPM_PF_EMPLOYER' placeholder="Enter Employer PF" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_PF_EMPLOYER; } ?>" readonly> 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_ESIC_EMPLOYEE">Employee ESIC </label>
                <input type="text" class="form-control" id='DPM_ESIC_EMPLOYEE' name='DPM_ESIC_EMPLOYEE' placeholder="Enter Employee ESIC" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_ESIC_EMPLOYEE; } ?>" readonly> 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_ESIC_EMPLOYER">Employer ESIC </label>
                <input type="text" class="form-control" id='DPM_ESIC_EMPLOYER' name='DPM_ESIC_EMPLOYER' placeholder="Enter Employer ESIC" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_ESIC_EMPLOYER; } ?>" readonly> 
              </div>

              <div class="form-group col-md-3">
                <label for="DPM_CALCULATED_AMOUNT">Calculated Amount Payable</label>
                <input type="text" class="form-control" id='DPM_CALCULATED_AMOUNT' name='DPM_CALCULATED_AMOUNT' placeholder="Calculated Amount" value="<?php if(isset($user_edit)){ echo $user_edit->DPM_CALCULATED_AMOUNT; } ?>"  onkeypress="return isNumberKey(event)" readonly> 
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
  
<script type="text/javascript">
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31
    && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function enable_end_date() {
    var DEM_ACTIVE_FLAG = $('#DEM_ACTIVE_FLAG').val();
    if(DEM_ACTIVE_FLAG=="ACTIVE"){
      $('#DEM_END_DATE').parent().hide();
      $('#DEM_END_DATE').attr('required',false);

    }else{
      $('#DEM_END_DATE').parent().show();
      $('#DEM_END_DATE').attr('required',true);
    }
}

function copy_address() {
    if($('#sameascurrent').is(':checked')){

      $('textarea#DEM_PERMANENT_ADDRESS').val($('textarea#DEM_CURRRENT_ADDRESS').val());
      $('#DEM_PA_PINCODE').val($('#DEM_CA_PINCODE').val());
    }else{
      $('textarea#DEM_PERMANENT_ADDRESS').val('');
      $('#DEM_PA_PINCODE').val('');
    }
    
    
}

</script>
<!--//contact-->  
<script>
  $(function() {
    $( "#DEM_START_DATE,#DEM_END_DATE" ).datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: "1950:2050"
    });
  });
</script>

<script>
  function GetAge() {
    var birthDate = new Date($('.DEM_EMP_DOB').val());
    var today = new Date();
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    $('.DEM_EMP_AGE').val(age);
    
  }
</script>



  