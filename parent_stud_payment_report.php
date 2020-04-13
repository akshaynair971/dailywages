<?php if(!isset($_SESSION)){ session_start();} ?>
  
  <?php
  include_once('connection.php');

  $r=$db->get_row("SELECT * FROM general_setting WHERE inst_id='".$_SESSION['inst_id']."' AND user_type='".$_SESSION['inst_user_type']."'");

   $title1 =$db->get_row("SELECT * FROM user WHERE user_type='".$_SESSION['user_type']."' AND inst_id='".$_SESSION['ad_id']."'"); 

  // $query = $db->get_row("SELECT * FROM general_setting");

  ?>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Welcome <?php if (isset($r)) {echo $r->ins_name;} else { echo $title1->user_name; }  ?></title>
<link rel="shortcut icon" href="<?php if(isset($r)){?>images/logo/<?php echo $r->ins_logo; ?> <?php } else { ?> images/user.jpg <?php } ?>" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">



<?php  
              
    if(isset($_GET['ser_id']))
  {
    $id=$_GET['ser_id'];

    $emp_det=$db->get_row("SELECT * FROM student_admission WHERE admi_id='$id'");

    $rw=$db->get_results("SELECT * FROM payment_details WHERE user_id='".$_SESSION['inst_id']."' AND insti_id='".$_SESSION['inst_id']."' AND user_type='".$_SESSION['inst_user_type']."' AND admi_id='$id'");

  }
?>


<style type="text/css">
   .page {
    
      /*padding-top: 0.60cm;*/
      padding-right: 0.75cm;
      padding-bottom: 0.75cm;
      padding-left: 0.75cm;   
      width: 21cm;
      min-height: 29.7cm;     
      margin: 1cm auto;
      border: 1px #D3D3D3 solid;
      border-radius: 5px;
      background: white;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      font-family: Times New Roman;
      background-color: #f3f1f1;
    }
    .cap{
        text-transform:uppercase;
    }
    
    
    @page {
        size: A4;
        margin: 0;

    }
   
    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
        .prnt{
          display: none;
        }

    }
    .addr-marg{
      margin-left: -35px;
    }
    .title-size
    {
      font-size: 18px;
    }
    .heading-color{
      background-color: #d2decb;
    }
</style><br>

<div id="page-wrapper ">
  <button style="float:left; position: fixed; z-index: 999;" class="btn prnt" onclick="qouteprint();"><i class="fa fa-print"></i> Print</button>
            
  <button style="float:left; margin-top: 40px;  position: fixed; z-index: 999;" class="btn prnt" onclick="window.location.href='index.php?folder=parents&file=stud_payment_report'";><i class="fa fa-close"></i> Close</button>

  <div class="container-fluid ">
  <!-- /.row -->
    <div class="row page">
      
        <form action="" method="POST">
          <div class="row" >
            <div class="table-repsonsive"><br><br><br>          
              <!-- Qoutation Print Page Header -->
                    <table class="table table-bordered">

                        <tr>
                        <td colspan="1" style="width:134px; text-align: left;">
                        <img class="img-resposive" src="images/logo/<?php echo $r->ins_logo; ?>" style=" margin-left: 0px; height: 100px; width: 117px;">
                        </td>
                        <td colspan="2">
                        <center><h1 style="font-weight:700; font-size: 27px; margin-bottom: 0px;margin-left: -30px; margin-top:0px;" class="cap"><?php echo $r->ins_name; ?></h1></center>

                             <center><span style="margin-left: -20px;"><?php echo $r->ins_address; ?></span></center>

                              <center><span class="addr-marg"><?php echo $query->address_2; ?></span></center> 
                           <!--   <center><span style="margin-left: -30px;"><b>Web : </b>divyacomputers.com</span></center>
                              <center><span style="margin-left: -30px;"><b>Email : </b><?php echo $query->email_id; ?></span></center> -->

                        </td>
                         <td colspan="1" style="width:134px; text-align: right;">
                          <span><img src="images/vol.png" style="height: 50px; width: 25px; margin-right: 80px; margin-bottom: -45px;"></span>
                          <span><b><?php echo $r->ins_mob; ?></span></b>
                          <!-- <span><b><?php echo $query->alternate_no; ?></b></span> -->
                        </td>
                      </tr>

                       <tr>
                          <td colspan="4" class="heading-color">
                            <center><span style="color: #41a3ad; font-weight: 700;"><u>STUDENT PAYMENT REPORT</u></span></center>

                           </td>
                      </tr>

                      <?php $get_stud = $db->get_row("SELECT * FROM student_registration WHERE sr_id=$emp_det->regi_id"); ?>

                      <tr>
                        <td colspan="2" rowspan="4"><b style="font-size: 15px;">To,</b><br><b style="font-size: 15px;"><?php echo strtoupper ($get_stud->stud_name); ?></b><br><?php echo $get_stud->stud_address1; ?>, <?php echo $get_stud->stud_address2; ?><br><b style="font-size: 15px;">Mob : <?php echo $get_stud->stud_phone; ?></td>
                      </tr>

                        <?php $get_class = $db->get_row("SELECT * FROM course WHERE class_id='$emp_det->admi_class'"); ?>

                        <?php $get_adm_yr = $db->get_row("SELECT * FROM academic_year WHERE ay_id='$emp_det->admi_acad_yr'"); ?>

                      <tr>
                        <td colspan="2"><b style="font-size: 14px;">CLASS : </b> <?php echo $get_class->class_name; ?> ( <?php echo $get_adm_yr->start_year; ?> - <?php echo $get_adm_yr->end_year; ?> )</td>
                      </tr>

                        <?php $get_board = $db->get_row("SELECT * FROM board WHERE board_id='$emp_det->admi_board'"); ?>
                      <tr>
                        <td colspan="2"><b style="font-size: 14px;">BOARD : </b> <?php echo $get_board->board_name; ?></td>
                      </tr>
                      <tr>
                        <td colspan="2"><b style="font-size: 14px;">PAYMENT TERM : </b></td>
                      </tr>

                      <tr>
                        <td colspan="4">
                          <table class="table table-bordered">
                              <thead class="heading-color">
                                <tr>
                                  <th class="text-center">Sr No.</th>
                                  <th class="text-center">Invoice No</th>
                                  <th class="text-center">Payment Date</th>
                                  <th class="text-center">Amount</th>
                                </tr>  
                              </thead>
                              <tbody>  
                                <tr>
                               
                                    <?php

                                      if($rw){
                                        $st = 0;
                                        foreach($rw as $stud){
                                        $st++;
                                    ?>
                                    
                                    <tr> 
                                      <td class="text-center"><?php echo $st; ?></td>

                                      <td class="text-center"><?php echo $stud->inv_no; ?></td>
                                 
                                      <td class="text-center"><?php echo date('M d, Y',strtotime($stud->amt_post_date)); ?></td>

                                      <td class="text-center"><i class="fa fa-rupee"></i> <?php echo $stud->paid_amount; $paid+= $stud->paid_amount; ?>/-</td>
                                  </tr>
                                  <?php } } ?>
                                </tr>

                                <tr>
                                  <td colspan="2" rowspan="4"></td>
                                  <td><b style="float: right;">Total</b></td>
                                  <td class="text-center heading-color"><i class="fa fa-rupee"></i> <?php if(isset($emp_det)){ echo $emp_det->ad_year_tot_fee; $total+=$emp_det->ad_year_tot_fee;} else { echo '0'; } ?>/-</td>
                                </tr>
                                
                               <!--   <tr>
                                  <td><b class="title-size" style="font-size:15px;">Extra Amount</b></td>
                                  <td class="text-center heading-color"><i class="fa fa-rupee"></i> <?php echo $r->extra_amount; ?></td>
                                </tr> -->
                                
                                <!--  <tr>
                                  <td><b class="title-size">Total</b></td>
                                  <td class="text-center heading-color"><i class="fa fa-rupee"></i> <?php echo $total+$r->extra_amount; ?></td>
                                </tr> -->
                                
                                <tr>
                                  <td><b style="float: right;">Paid</b></td>
                                  <td class="text-center heading-color"><i class="fa fa-rupee"></i> <?php if(isset($paid)){ echo $paid; } else { echo '0'; } ?>/-</td>
                                </tr>  
                                <tr>
                                  <td><b style="float: right;">Balance</b></td>
                                  <td class="text-center heading-color"><i class="fa fa-rupee"></i> <?php echo ($total)-($paid); ?>/-</td>
                                </tr>  
                              </tbody>
                          </table>
                        </td>
                      </tr>
                       <tr>
                        <td colspan="4">
                          <h5><b>Term And Condition :</b></h5>
                          <?php echo $r->terms_condi;?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4" class="heading-color"></td>
                      </tr>
                        <tr>
                        <td colspan="4">
                          <!-- <span style="float: left; font-size: 16PX;"><b>Bank Details : </b></span> --><b style="float: right; font-size: 14px;">For <?php echo $r->ins_name; ?></b><br>
                       <!--    <span style="font-size: 13px;"><?php echo $query->bank_name; ?></span><br>
                          <span style="font-size: 13px;">A/c No. <?php echo $query->ac_no; ?></span><br>
                          <span style="font-size: 13px;">IFSC Code : <?php echo $query->ifc_no; ?></span><br> -->
                          <span style="font-size: 15px; float: right; margin-right: 30px; margin-top: 50px;"><b>Auth. Signatory</b></span>
                        </td>
                      </tr>
                </table>       
            </div>
          </div>
        </form>        
      </div>
    </div>
  <!-- /.row -->
  <!-- /.container-fluid -->
  </div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- jQuery -->
<!--<script src="js/jquery.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<!--<script src="js/bootstrap.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php
if(isset($_GET['printqt_id'])){
  echo "<script>
  window.print();
</script>";

}
?>

<script>
  function qouteprint(){ 
  window.print();
}
</script>


