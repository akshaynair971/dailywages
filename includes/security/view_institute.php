<?php  

    $r=$db->get_results("SELECT * FROM institute");

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
             <a href='index.php?folder=security&file=add_institute' class='btn btn-success btn-round' style="float: right;"><i class="fa fa-plus"></i>&nbsp; <b>Add New Institute</b></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">Sr.No</th>
                  <th class="text-center">Institute Name</th>
                  <th class="text-center">School Address</th>
                  <th class="text-center">Login Details</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                      if (isset($r)) {
                        foreach ($r as $row) {
                  ?>
                    <tr>
                        <td class="text-center"><?php echo $row->inst_id; ?></td>
                        <td class="text-center"><?php echo $row->inst_name; ?></td>
                        <td class="text-center"><?php echo $row->inst_address; ?></td>
                        <td class="text-center">
                          <b style="color: green;">User Name : </b> <?php echo $row->inst_user;?><br>
                          <b style="color: green;">Password : </b> <?php echo $row->inst_password;?><br>
                        </td>
              				  <td class="text-center">

                  					<a href="?folder=security&file=add_institute&edit_ins=<?php echo $row->inst_id; ?>"><i class="btn btn-success btn-size fa fa-pencil"></i></a>

                  				  <a onclick="return confirm('Are You Sure Delete..?')" href="?folder=security&file=view_institute&delete_ins=<?php echo $row->inst_id; ?>"><i class="btn btn-danger btn-size fa fa-trash-o"></i></a><br>

                            <!-- <a class="btn btn-info" href="#" style="margin-top: 5px; width: 90px;">Login</i></a> -->
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
  