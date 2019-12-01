<?php  

    $r=$db->get_results("SELECT * FROM user_type");

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
             <a href='index.php?folder=configuration&file=add_designation' class='btn btn-primary' style="float: right;"><i class="fa fa-plus"></i> <b>Add New designation</b></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">Sr.No</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead> 


 
                <tbody>

                    <?php 
                      if (isset($r)){
                        $usr = 0;
                        foreach ($r as $row){
                            if ($row->usr_id!=1 && $row->usr_id!=2){  
                        $usr++;
                    ?>

                    <tr>
                        <td class="text-center"><?php echo $usr; ?></td>
                        <td class="text-center"><?php echo $row->usr_type; ?></td>

              				  <td class="text-center">

                            <a href="?folder=configuration&file=add_designation&edit_user_type=<?php echo $row->usr_id; ?>"><i class="btn btn-primary fa fa-edit"></i></a>

                            <a onclick="return confirm('Are You Sure Delete..?')" href="?folder=configuration&file=designations&desig_del_id=<?php echo $row->usr_id; ?>"><i class="btn btn-danger fa fa-trash-o"></i></a>
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
  