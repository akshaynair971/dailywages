<style type="text/css">
     .btn-primary
     {
        margin-top: 10px;
     }
     .table-border{
       background-color: #337ab7;
     }
   </style>
 <br>

 <?php 
     $expense = $db->get_results("SELECT * FROM expanse WHERE user_id='".$_SESSION['ad_id']."'");

     if($expense)
         {
           foreach($expense as $exp)
           {
           
           $credit+=$exp->credit_amt;
           $debit+=$exp->debit_amount;


         }
       }


       $payments = $db->get_results("SELECT * FROM payment_details WHERE insti_id='".$_SESSION['ad_id']."'");

       if($expense)
           {
             foreach($payments as $total_amount)
             {
             
             $paid_amt+=$total_amount->paid_amount;


           }
         }
?>
  <div class="container">
     <div class="col-lg-6 col-md-6 col-sm-12">
           <div class="box box-primary">
                <div class="box-header">
                <h3 class="box-title"><label><i class="fa fa-inr"></i> Opening Balance Details</label></h3>
                <form method="POST"><br>
                 <div class="row">
                   <div class="box-body">
                  <div class="table-responsive">
                  <table class="table table-bordered" role="grid">
                      <tbody>
                          <tr>
                            <th class="text-center">Name</th>
                              <td class="text-center"><b>Amount</b></td>
                          </tr>
                          <tr>
                            <th class="text-center" style="color: green;">Credit Amount</th>
                              <td class="text-center"><i class="fa fa-inr"></i> <?php echo $credit; ?>/-</td>
                          </tr>
                          <tr>
                            <th class="text-center" style="color: red;">Debit Amount</th>
                              <td class="text-center"><i class="fa fa-inr"></i> <?php echo $debit; ?>/-</td>
                          </tr>
                        <tr>
                            <th class="text-center" style="color: green;">Payment Amount</th>
                              <td class="text-center"><i class="fa fa-inr"></i> <?php echo $paid_amt; ?>/-</td>
                          </tr>
                           <tr>
                            <th class="text-center" style="color: blue;">Opening Total Amount</th>
                              <td class="text-center"><i class="fa fa-inr"></i> <?php echo $paid_amt+$credit-$debit; ?>/-</td>
                          </tr>
                      </tbody>
                  </table>
                </div>
              </div>
           </div>
         </form>
       </div>   
     </div>
   </div>