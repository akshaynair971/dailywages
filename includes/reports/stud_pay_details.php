
<?php
  
  if(isset($_GET['admis_id']))
  {
    $id=$_GET['admis_id'];

    $emp_det=$db->get_row("SELECT * FROM student_admission WHERE admi_id='$id'");

    $get_fees=$db->get_results("SELECT * FROM payment_details WHERE user_id='".$_SESSION['ad_id']."' AND insti_id='".$_SESSION['inst_id']."' AND user_type='".$_SESSION['user_type']."' AND admi_id='$id'");
  }
  
?>

<section>
<div class="col-md-12">
               <div class="box box-primary">
               
               <div class="box-header">
               <h3 class="box-title"><b>Student Fee Report</b></h3>
               <div class="box-tools">
                        <a href="student_all_payment_report.php?ser_id=<?php echo $id; ?>" class="btn btn-default btn-round"><i class="fa fa-print"></i> <b>All Print</b></a>
               </div>
               </div>
               
               
              <div class="box-body table-responsive">
        
              <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
              <thead class="table-border">
              <tr>
                <th class="text-center">Sr. No.</th>
                <th class="text-center">Invoice No</th>
                <th class="text-center">Student Name</th>
                <th class="text-center">Mobile No</th>
                <th class="text-center">Address</th>
                <th class="text-center">Paid Amount</th>
                <th class="text-center">Action</th>
              </tr>
              
              </thead>
              <tbody>
              <?php
              $i=0;
               if($get_fees){ 
              foreach($get_fees as $rw)
              {
                $res = $db->get_row("SELECT * FROM student_registration WHERE sr_id='$emp_det->regi_id'");
                  $i++;
               ?>
              <tr>
              <td class="text-center"><?php echo $i; ?></td>
              <td class="text-center"><?php echo $rw->inv_no; ?></td>
              <td class="text-center"><?php echo $res->stud_name; ?></td>
              <td class="text-center"><?php echo $res->stud_phone; ?></td>
              <td class="text-center"><?php echo $res->stud_address1; ?></td>
              <td class="text-center"><i class="fa fa-inr"></i> <?php echo $rw->paid_amount; $paid+= $rw->paid_amount;?>/-</td>
              <td class="text-center">
                <a href="student_single_payment_report.php?ser_id=<?php echo $rw->admi_id;?>&inv_no=<?php echo $rw->inv_no;?>" class="btn btn-warning"><i class="fa fa-print"></i></a>
              </td>
              </tr>
              <?php } } else{ ?>
                  <tr>
                    <td colspan="7" class="text-center">
                      <b>Fee Report Not Available</b>
                    </td>
                  </tr>
                <?php } ?>
          </tbody>
            </table>

            <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
              <tbody>
                <tr>
                  <td colspan="7" style="width:205px; text-align:right;"><B>Total Amount</B></td>
                  <td style="background-color:blue; color:white;"><b><i class="fa fa-rupee"></i> </b><?php if(isset($emp_det->ad_year_tot_fee)){echo $emp_det->ad_year_tot_fee; } else {echo '0';}?></td>
              
                </tr>  
                <tr>
                  <td colspan="7" style="width:205px; text-align:right;"><B>Paid Amount</B></td>
                  <td style="background-color:green; color:white;"><b><i class="fa fa-rupee"></i></b> <?php if(isset($paid)){echo $paid;} else { echo '0'; } ?></td>
                </tr>
                <tr>
                  <td colspan="7" style="width:205px; text-align:right;"><B>Balance Amount</B></td>
                  <td style="background-color:red; color:white;"><b><i class="fa fa-rupee"></i> </b><?php echo ($emp_det->ad_year_tot_fee)-($paid); ?></td>
                </tr> 
                </tbody>
            </table>
           
            
           
          </div>
        </div>
      </div>
    </section>