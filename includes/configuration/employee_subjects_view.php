 <?php  

    $r=$db->get_results("SELECT * FROM employee_subject WHERE inst_id='".$_SESSION['ad_id']."'");

    $currentPage="?folder=configuration&file=employee_subjects";

?>
<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12"> 
         
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
             <a href='index.php?folder=configuration&file=add_employee_subject' class='btn btn-primary btn-round' style="float: right;"><i class="fa fa-plus"></i> <b>Add New Employee Subject</b></a>
            </div>
      
            <!-- /.box-header -->
            <div class="box-body table-responsive">   

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">Sr.No</th>
                <!--   <th class="text-center">Class</th>
                  <th class="text-center">Board</th>
                  <th class="text-center">Employee Name</th> -->
                  <th class="text-center">Subject Details</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead> 


 
                <tbody>

                    <?php 
                      if ($r){
                        $emp = 0;
                        foreach ($r as $row){
                          $emp++;
                          // $class=$db->get_row("SELECT * FROM class WHERE class_id='".$row->class."'");
                          // $board=$db->get_row("SELECT * FROM board WHERE board_id='".$row->board."'"); 
                          // $emp=$db->get_row("SELECT * FROM user WHERE user_id='".$row->emp_name."'"); 
                          // $sub=$db->get_row("SELECT * FROM subject WHERE sub_id='".$row->emp_sub."'");
                       
                    ?>

                    <tr>
                        <td class="text-center"><?php echo $emp; ?></td>
                  
                        <td>
                               <table class="table table-bordered">
                            <thead>
                              <th class="text-center">Sr No</th>
                              <th class="text-center">Class Name</th>
                              <th class="text-center">Board Name</th>
                              <th class="text-center">Subject Name</th>
                              <th class="text-center">Employee Name</th>
                            </thead>
                            <tbody>
                            <?php

                            $json = json_decode($row->teach_subject_all_details);

                              for($i=0; $i<count($json->class); $i++)
                            {
                              
                                $c=$i+1;
                          
                            ?>
                            
                            <tr> 
                              <td class="text-center"><?php echo $c; ?></td>
                              <td class="text-center">
                                <?php   
                                  $job_spec = $db->get_row("SELECT * FROM course WHERE class_id='".$json->class[$i]."'");
                                  echo $job_spec->class_name; ?>
                              </td>

                               <td class="text-center">
                                <?php   
                                  $job_bord = $db->get_row("SELECT * FROM board WHERE board_id='".$json->board_name[$i]."'");
                                  echo $job_bord->board_name; ?>
                              </td>

                              <td class="text-center">
                                <?php   
                                  $job_subject = $db->get_row("SELECT * FROM subject WHERE sub_id='".$json->subject[$i]."'");
                                  echo $job_subject->subject; ?>
                              </td>

                               <td class="text-center">
                                <?php   
                                  $job_emp = $db->get_row("SELECT * FROM user WHERE user_id='".$json->emp_name[$i]."'");
                                  echo $job_emp->user_name; ?>
                              </td>

                            </tr>
                          <?php } ?>
                            </tbody>
                          </table>
                        </td>
                        <td align="center">

                            <a href="?folder=configuration&file=add_employee_subject&edit_emp_sub=<?php echo $row->emp_id; ?>"><i class="btn btn-success fa fa-edit"></i></a>
                            
                            <a onclick="return confirm('Are You Sure Delete..?')" href="?folder=configuration&file=employee_subjects_view&del_emp_sub=<?php echo $row->emp_id; ?>"><i class="btn btn-danger fa fa-trash-o"></i></a>
                        </td>

                    </tr>

                    <?php } ?>
                    <?php }
                    else { ?>
                        <tr>                      
                          <td colspan='6' class="pull-center" style="text-align: center;">
                                      <b>No Record Available</b>
                            </td>
                        </tr>
                    <?php }  ?>  
              
               
                </tbody>




                <tfoot>
               
                </tfoot>
              </table>
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
  