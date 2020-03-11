<?php  

    $r=$db->get_results("SELECT * FROM user_type");

?>
<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
             <a href='index.php?folder=security&file=add_user_type' class='btn btn-primary' style="float: right;"><i class="fa fa-user"></i> Add New User</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
                </thead> 


 
                <tbody>

                    <?php 
                      if (isset($r)) {
                        foreach ($r as $row) {
                            if ($row->usr_id!=1 && $row->usr_id!=2) {  
                       
                    ?>

                    <tr>
                        <td><?php echo $row->usr_id; ?></td>
                        <td><?php echo $row->usr_type; ?></td>

              				  <td align="center">
                  					<input type="hidden" name="_token" value="#">
                            <a href="?folder=security&file=add_user_type&edit_user_type=<?php echo $row->usr_id; ?>"><i class="btn btn-primary fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <!-- <a onclick="return confirm('Are You Sure Delete..?')" href="?folder=security&file=view_user_type&delete_user_type=<?php echo $row->usr_id; ?>"><i class="btn btn-danger fa fa-trash-o"></i></a> -->
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
  