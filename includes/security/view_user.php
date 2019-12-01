<?php  

    $r=$db->get_results("SELECT * FROM user");

?>
<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
             <a href='index.php?folder=security&file=add_user' class='btn btn-success' style="float: right;"><i class="fa fa-user"></i> Add New User</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">Sr.No</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Mobile No.</th>
                  <th class="text-center">Address</th>
                  <th class="text-center">E-Mail</th>
                  <th class="text-center">Profile</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead> 


 
                <tbody>

                    <?php 
                      if (isset($r)) {
                        foreach ($r as $row) {
                            
                       
                    ?>

                    <tr>
                        <td><?php echo $row->user_id; ?></td>
                        <td><?php echo $row->user_name; ?></td>
                        <td><?php echo $row->user_mob; ?></td>
                        <td><?php echo $row->user_address; ?></td>
                        <td><?php echo $row->user_email; ?></td>
                        <td class="text-center"><img src="./images/user_profile/<?php echo $row->user_profile; ?>"  style="height: 70px;width: 100px;"></td>

              				  <td align="center">
                  					<input type="hidden" name="_token" value="#">
                            <a href="?folder=security&file=add_user&edit_user=<?php echo $row->user_id; ?>"><i class="btn btn-success fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a onclick="return confirm('Are You Sure Delete..?')" href="?folder=security&file=view_user&delete_user=<?php echo $row->user_id; ?>"><i class="btn btn-danger fa fa-trash-o"></i></a>
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
  