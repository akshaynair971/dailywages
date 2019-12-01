<?php
 
 if(!isset($_SESSION)){ session_start();} 

 include_once('connection.php');

 $invoice_settings=$db->get_row("SELECT * FROM general_setting WHERE inst_id='".$_SESSION['ad_id']."' AND user_type='".$_SESSION['user_type']."'");

?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/black-tie/jquery-ui.min.css">
<!-- <link href="plugins/jQueryUI/jquery-ui.css" rel="stylesheet" type="text/css" /> -->

<title><?php if (isset($invoice_settings)) {echo $invoice_settings->ins_name;} else { echo $title1->user_name; }  ?></title>



<?php

global $db;
 
$db->query('SET character_set_results=utf8');
$db->query('SET names=utf8');
$db->query('SET character_set_client=utf8');
$db->query('SET character_set_connection=utf8');
// $db->query('SET character_set_results=utf8');
$db->query('SET collation_connection=utf8_unicode_ci');
    
    

 // $invoice_settings= $db->get_row("SELECT * FROM general_setting WHERE ");

 
 
  extract($_GET);
 
  $sa_date = $stud_attend_date;

  $r = $db->get_results("SELECT * FROM student_admission WHERE admi_class='$class_id' AND admi_board='$board_id' AND admi_section='$sec_id' AND admi_acad_yr='$ay_id'");
  // $r=$db->get_results("SELECT * FROM student_admission WHERE admi_class='$bid' "); 
  // print_r($r);

 //$db->debug();
  $getdatearray=explode("-",$sa_date);
  $nod=cal_days_in_month(CAL_GREGORIAN,$getdatearray[1],$getdatearray[0]);
   

?>
<style type="text/css">
   .page {
    
      /*padding-top: 0.60cm;*/
      padding-right: 0.75cm;
      padding-bottom: 0.75cm;
      padding-left: 0.75cm;   
      /*width: 21cm;*/
      min-height: 29.7cm;     
      margin: 1cm auto;
      border: 1px #D3D3D3 solid;
      border-radius: 5px;
      background: white;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      font-family: Times New Roman;
    }
    .cap{
        text-transform:uppercase;
    }
    
    
    @page {
        /*size: A4;*/
        margin: 10px;


    }
   /* @page rotated { size : landscape }
   @media print{@page {size: landscape}}*/

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
 .watermark {
    position: fixed;
    opacity: 0.10;
    font-size: 67px;
    width: 100%;
    margin-top: 300px;
    text-align: center;
    z-index: 1000;
    background-repeat: repeat space;
    background-repeat: repeat repeat;
    background-repeat: round space;
}

 .table-bordered>thead>tr>th{
  border:1px solid black;
}
.table-bordered>tbody>tr>td{
  border:1px solid black;
}
                  
</style>
<style>
    .ui-tooltip, .arrow:after {
      background: black;
      border: 2px solid white;
    }
    .ui-tooltip {
      padding: 10px 20px;
      color: white;
      border-radius: 20px;
      font: bold 14px "Helvetica Neue", Sans-Serif;
      text-transform: uppercase;
      box-shadow: 0 0 7px black;
    }
    .arrow {
      width: 70px;
      height: 16px;
      overflow: hidden;
      position: absolute;
      left: 50%;
      margin-left: -35px;
      bottom: -16px;
    }
    .arrow.top {
      top: -16px;
      bottom: auto;
    }
    .arrow.left {
      left: 20%;
    }
    .arrow:after {
      content: "";
      position: absolute;
      left: 20px;
      top: -20px;
      width: 25px;
      height: 25px;
      box-shadow: 6px 5px 9px -9px black;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
    .arrow.top:after {
      bottom: -20px;
      top: auto;
    }
    </style>
    <br>
<div id="page-wrapper ">
  <button style="float:left; position: fixed; z-index: 999;" class="btn prnt" onclick="qouteprint();"><i class="fa fa-print"></i> Print</button>

  <!-- <button style="float:left; margin-top: 40px;  position: fixed; z-index: 999;" class="btn prnt" onclick="window.location.href='index.php?folder=students&file=add_student_attendance'";><i class="fa fa-close"></i> Close</button> -->

  <div class="container-fluid ">
  <!-- /.row -->
    <div class="row page">
      <!-- <div  class="watermark"><img style="height:300px;" src="images/aasawa.jpg"></div> -->
      
        <form action="" method="POST">
         <!--  <center><h3><b><u>QOUTATION</u></b></h3></center> -->
          <div class="row" >
            <div class="table-repsonsive">           
              <!-- Qoutation Print Page Header -->
                    <table class="table-repsonsive " style="width: 100%;">
                      <tr>
                        
                        <td rowspan="2" style="width:140px;">
                          <img class="img-responsive" src="images/logo/<?php echo $invoice_settings->ins_logo; ?>" style=" margin-left: 3px; height: 94px; width: 137px;">
                        </td>
                        <td colspan="3">                          
                          <center><h1 style="color:#9c4d55 !important ; font-weight:900; font-size: 32px;"><?php if(isset($invoice_settings)){ echo $invoice_settings->ins_name; }?></h1><span ><?php if(isset($invoice_settings)){ echo $invoice_settings->ins_address; }?></span></center>
                           
                        </td>   
                      </tr>
                     
                      <tr>                        
                        <td colspan="3">
                           <center><span ><b>Mob No. :-</b> <?php if(isset($invoice_settings)){ echo $invoice_settings->ins_mob; }?> </span></center><br>
                        </td>
                      </tr>
                    </table>

                      <table class="table-repsonsive " style="width: 100%;">
                       <tr>
                       <td colspan="1"  style="width:170px;" ><b>Class :</b> <?php 
                        $getclass = $db->get_row("SELECT * FROM course WHERE class_id='$class_id'");
                        $getsec = $db->get_row("SELECT * FROM section WHERE sec_id='$sec_id'");
                        echo $getclass->class_name." ( Sec-".$getsec->sec_name." )";
                        ?>  
                      </td>                        
                        <td>
                          <center><b>Monthly Attendance</b></center>
                        </td>
                        <td style="text-align: right;">
                          <b><?php echo date('F-Y',strtotime($sa_date)); ?></b>
                        </td>
                      </tr>
                    </table>
                    
                    <hr style="border:1px groove; margin-top: 8px; margin-bottom: 10px;">  

                    <table class="table table-repsonsive table-bordered" style="border:1px solid black;">
                      <thead>
                        <tr style="border:1px solid black !important;">
                          <th style="width: 5%; border:1px solid black !important;">S.N.</th> 
                          <th style="width: 80%;border:1px solid black !important;" >Student Name</th> 

                          <?php 
                          for($dc=1;$dc<=$nod;$dc++){
                            $weekname= date('D',strtotime($getdatearray[0]."-".$getdatearray[1]."-".$dc));
                           ?>   

                          <th title="<?php echo $weekname; ?>" style="text-align:center; border:1px solid black !important; <?php if($weekname=="Sun"){ echo "color:red;"; } ?>" ><?php echo $dc; ?></th> 
                        <?php } ?>
                          <th style="text-align:center; border:1px solid black !important;" >T</th> 

                           
                          <!-- <th style="width: 8%; text-align:right;" ></th>  -->
                          
                           
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $i=1;
                          foreach($r as $rw)
                          {  
                            // print_r($rw);
                            $getbatstat= $db->get_row("SELECT * FROM student_registration WHERE sr_id='$rw->regi_id'");
                          ?>
                              <tr>
                                <td style="border:1px solid black !important;"><?php echo $i;  $i++;?></td>
                                <td style="border:1px solid black !important;"><span style="<?php if($rw->cust_status=='4'){ echo 'text-decoration: underline;'; } ?>"><?php echo $getbatstat->stud_name; ?></span></td>

                                <?php 
                                $atcnt=0;
                                for($dc=1;$dc<=$nod;$dc++){
                                  $newdate= date('Y-m-d',strtotime($getdatearray[0]."-".$getdatearray[1]."-".$dc));

                                  $attstatus = $db->get_results("SELECT * FROM student_attendence WHERE class_id='$class_id' AND board_id='$board_id' AND sec_id='$sec_id' AND ay_id='$ay_id' AND stud_att_date='$newdate' ");
                                  // $db->debug();

                                  $getstudentatt= $db->get_row("SELECT * FROM student_attendence WHERE stud_id='$getbatstat->sr_id' AND class_id='$class_id' AND board_id='$board_id' AND sec_id='$sec_id' AND ay_id='$ay_id' AND stud_att_date='$newdate'");
                                  // $db->debug();
                                ?>                          
                                  <td style="text-align:center; border:1px solid black !important;" >
                                    
                                    <?php
                                    if($attstatus == FALSE)
                                    {
                                      echo "-";
                                    }else{
                                      if($getstudentatt == FALSE)
                                      {
                                       echo "<b style='color:green';>P</b>"; 
                                       $atcnt++;
                                      }else{
                                       echo "<b style='color:red';>A</b>"; 
                                      }
                                    } ?>
                                  </td>
                                <?php 
                                } 
                                ?>
                                <td style="text-align:center; border:1px solid black !important;" ><b><?php echo $atcnt; ?></b></td> 
                                <!-- <td></td> -->
                              <!-- <td>Batch Name Display Here</td> -->
                              </tr>
                            
                           
                            <?php
                          }
                        ?>

                      </tbody>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script src="plugins/jQueryUI/jquery-ui.js"></script> -->
<script type="text/javascript">
// function chk_delete(delreviewid){  
//   var r = confirm("Confirm to delete selected record?");
//   if (r == true) { location.href="home-page-banner.php?delid="+delreviewid; }
// }
</script>

<script>
  $( function() {
      $(document).tooltip({
        position: {
          my: "center bottom-20",
          at: "center top",
          using: function( position, feedback ) {
            $( this ).css( position );
            $( "<div>" )
              .addClass( "arrow" )
              .addClass( feedback.vertical )
              .addClass( feedback.horizontal )
              .appendTo( this );
          }
        }
      });
    } );
    </script>
    <script>
  function qouteprint(){ 
  window.print();
}
</script>
