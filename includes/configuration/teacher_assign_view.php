 <?php

    $r=$db->get_results("SELECT * FROM class_teacher_assign WHERE inst_id='".$_SESSION['inst_id']."'");
?> 

<style>
  .btn-size
  {
    margin-top: 5px;
  }
</style>


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
							<div class="col-xs-12">
								<div class="add-button">
									<a class="pull-right btn btn-primary btn-w-xs btn-round" href="?folder=configuration&file=add_class_teacher"><i class="fa fa-plus"></i> &nbsp;<b>Assign Class Teacher</b></a>
								</div>
							</div>
					
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">Sr.No.</th>
                  <th class="text-center">Class & Board</th>
                  <th class="text-center">Section & Academic Year</th>
                  <th class="text-center">Teacher Name</th>
				          <th class="text-center">Action</th>
              
                </tr>
                </thead>
                <tbody>


                  <?php 
                      if (isset($r)) {
                        $yr = 0;
                        foreach ($r as $data) {
                          $yr++;

                        $get_standard = $db->get_row("SELECT * FROM course WHERE class_id='".$data->class_id."'");  
                        $get_section = $db->get_row("SELECT * FROM section WHERE sec_id='".$data->sec_id."'");  
                        $get_board = $db->get_row("SELECT * FROM board WHERE board_id='".$data->board_id."'");  
                        $get_acd_yr = $db->get_row("SELECT * FROM academic_year WHERE ay_id='".$data->ay_id."'");
                        $get_teach = $db->get_row("SELECT * FROM user WHERE user_id='".$data->user_id."'");   
                    ?>

                  <tr >
    									<td class="text-center"><?php echo $yr; ?></td>
                      <td>
                          <b style="color: red;">Class : </b> <?php echo $get_standard->class_name; ?><br>
                          <b style="color: red;">Board : </b> <?php echo $get_board->board_name; ?><br>
                      </td>

    									<td>  
                          <b style="color: red;">Section : </b> <?php echo $get_section->sec_name; ?><br>
                          <b style="color: red;">Acd Year : </b> <?php echo $get_acd_yr->start_year; ?> - <?php echo $get_acd_yr->end_year; ?>
                      </td>

                      <td class="text-center">
                        <b style="color: red;">Name : </b> <?php echo $get_teach->user_name; ?><br>
                        <b style="color: red;">Assign Date : </b> <?php echo date('M d, Y',strtotime($data->post_id)); ?>
                      </td>

                      <td class="text-center" width="15%">
        									<a href="?folder=configuration&file=add_class_teacher&edit_teach=<?php echo $data->teacher_id; ?>"><i class="btn btn-primary btn-size fa fa-pencil"></i></a>

        					        <a onclick="return confirm('Are You Sure...?')" class="" href="?folder=configuration&file=teacher_assign_view&tech_asig_del_id=<?php echo $data->teacher_id; ?>"><i class="btn btn-danger btn-size fa fa-trash"></i></a>
    								</td>
							  </tr>
												
                  <?php } } else { ?>
                        <tr>                      
                          <td colspan='6' class="pull-center" style="text-align: center;">
                                      <b>No Record Available</b>
                            </td>
                        </tr>
                    <?php }  ?> 
               
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
       
        </div>
        <!-- /.col -->
      </div>
          
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->