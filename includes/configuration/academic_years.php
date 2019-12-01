 <?php

    $r=$db->get_results("SELECT * FROM academic_year WHERE inst_id='".$_SESSION['ad_id']."'");

    // echo base_url();
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
									<a class="pull-right btn btn-primary btn-w-xs btn-round" href="?folder=configuration&file=add_academic_year"><i class="fa fa-plus"></i> <b>Add Academic Year</b></a>
								</div>
							</div>
					
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Start Month Year</th>
                  <th>End Month Year</th>
				          <th>Action</th>
              
                </tr>
                </thead>
                <tbody>


                  <?php 
                      if (isset($r)) {
                        $yr = 0;
                        foreach ($r as $row) {
                          $yr++;
                            if ($row->usr_id!=1 && $row->usr_id!=2) {  
                       
                    ?>

                  <tr >
    									<td><?php echo $yr; ?></td>
    									<td><?php echo $row->start_year; ?></td>
    				          <td><?php echo $row->end_year; ?></td>
                      <td width="15%">
        									<a href="?folder=configuration&file=add_academic_year&edit_ay=<?php echo $row->ay_id; ?>"><i class="btn btn-primary btn-size fa fa-pencil"></i></a>

        					        <a onclick="return confirm('Are You Sure...?')" class="" href="?folder=configuration&file=academic_years&acd_yr_del_id=<?php echo $row->ay_id; ?>"><i class="btn btn-danger btn-size fa fa-trash"></i></a>
    								</td>
							  </tr>
												
                  <?php }} ?>
                    <?php }
                    else { ?>
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