 <?php  

    $r=$db->get_results("SELECT * FROM course WHERE inst_id='".$_SESSION['ad_id']."'");

?>
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
             <a href='index.php?folder=configuration&file=add_class' class='btn btn-primary btn-round' style="float: right;"><i class="fa fa-plus"></i> <b>Add New class</b></a>
            </div>
      
            <!-- /.box-header -->
            <div class="box-body table-responsive">   

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">Sr.No</th>
                  <th class="text-center">Class</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead> 


 
                <tbody>

                    <?php 
                      if (isset($r)){
                        $cl = 0;
                        foreach ($r as $row) {
                          $cl++
                    ?>

                    <tr>
                        <td class="text-center"><?php echo $cl; ?></td>
                        <td class="text-center"><?php echo $row->class_name; ?></td>
                        
                        <td class="text-center">

                            <a href="?folder=configuration&file=add_class&edit_stud=<?php echo $row->class_id; ?>"><i class="btn btn-success fa fa-edit"></i></a> 

                            <a onclick="return confirm('Are You Sure Delete..?')" href="?folder=configuration&file=class_view&class_del_id=<?php echo $row->class_id; ?>"><i class="btn btn-danger fa fa-trash-o"></i></a>
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
  