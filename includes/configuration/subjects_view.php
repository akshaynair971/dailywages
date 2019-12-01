 <?php  

    $r=$db->get_results("SELECT * FROM subject WHERE inst_id='".$_SESSION['ad_id']."'");

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
            <div class="box-header">
             <a href='index.php?folder=configuration&file=add_subject' class='btn btn-primary btn-round' style="float: right;"><i class="fa fa-plus"></i> <b>Add New Subject</b></a>
            </div>
      
            <!-- /.box-header -->
            <div class="box-body table-responsive">   

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-align-center">Sr.No</th>
                  <th class="text-center">Class</th>
                  <th class="text-center">Board</th>
                  <th class="text-center">Subject</th>
                  <th style="width: 15%;" class="text-center">Action</th>
                </tr>
                </thead> 


 
                <tbody>

                    <?php 
                      if (isset($r)) {
                        $sub = 0;
                        foreach ($r as $row) {

                          $class=$db->get_row("SELECT * FROM course WHERE class_id='".$row->class."'");
                          $board=$db->get_row("SELECT * FROM board WHERE board_id='".$row->board."'");   
                        $sub++;
                    ?>

                    <tr>
                        <td class="text-center"><?php echo $sub; ?></td>
                        <td class="text-center"><?php echo $class->class_name; ?></td>
                        <td class="text-center"><?php echo $board->board_name; ?></td>
                        <td class="text-center"><?php echo $row->subject; ?></td>
                        <td class="text-center">
                          
                          <a href="?folder=configuration&file=edit_subject&ed_sub=<?php echo $row->sub_id; ?>" class="btn btn-success btn-size btn-size"><i class="fa fa-pencil"></i></a>

                          <a onclick="return confirm('Are You Sure Delete..?')" href="?folder=configuration&file=subjects_view&sub_del_sub=<?php echo $row->sub_id; ?>" class="btn btn-danger btn-size btn-size"><i class="fa fa-trash-o"></i></a>
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
  