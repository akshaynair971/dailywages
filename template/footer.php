
<footer class="main-footer">
    <strong>
      Copyright &copy; 2019 
        <a style="color:white;" href="#"> <?php if (isset($title)) {echo $title->ins_name;}  ?></a> . 
    </strong>
    All Rights Reserved.
</footer>


<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- SlimScroll -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="abc.js"></script> -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>







<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- Datepicker Script Start-->

<script src="dist/js/jquery-ui.js"></script>
<!-- Datepicker Script End-->
<script src="plugins/select2/select2.full.min.js" type="text/javascript"></script>
<script src="plugins/timepicker/mdtimepicker.js" type="text/javascript"></script>
<!-- <script src="plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script> -->

<script>
  $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script> 

<script>
  $(function () {

    $('#example1').DataTable();
    $('#example2').DataTable();
    // $('.timepicker').wickedpicker();
    $('.timepicker').mdtimepicker();
  })

<?php
  // if($toast_handler['toast_disp']==1){ 

  ?>
  // $.toast({
    <?php // if($toast_handler['toast_status']=="success"){ ?>
    // text: "<?php // echo $toast_handler['toast_msg']; ?>",
    // bgColor: '#2a586f',
    // textColor: 'white',
    // icon: 'success',
    
    <?php 
   // $toast_handler['toast_disp']=0;
    //  
   // } ?>

    <?php // if($_SESSION['toast_handler']['toast_status']=="failed"){ ?>
    // text: "<?php // echo $_SESSION['toast_handler']['toast_msg']; ?>",
    // bgColor: '#2a586f',
    // textColor: 'white',
    // icon: 'error',
    <?php 
    // unset($_SESSION['toast_handler']);
    // } ?>

    // showHideTransition: 'fade', 
    // allowToastClose: true, 
    // hideAfter: 3000, 
    // stack: 5, 
    // position: 'top-right',
    // textAlign: 'left',  
    // loader: true,  
    // loaderBg: '#9EC600',  
    // heading: 'Note', 
     
    
    // beforeShow: function () {}, 
    // afterShown: function () {}, 
    // beforeHide: function () {}, 
    // afterHidden: function () {}  
 // });
<?php // } ?>

</script>

<script>
  $(function() {
    $( "#datepicker" ).datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: "1950:2050",
      
    });
  });
  </script>
  <script>
  $(function() {
    $( "#datepicker1" ).datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: "1970:2050"
    });
  });
  </script>
<script type="text/javascript">
  $(document).ready(function($){
    var url = window.location.href;
    $('.nav li a[href="'+url+'"]').addClass('active');
});
</script>

<script>
     $(document).ready(function() {
    $('.select2').select2();
});
  </script> 

 
<!-- </div> -->
</body>
</html>
