<div class="app-content content">
   <div class="content-wrapper">
      <?= view('includes/breadcrumb.php');?> 
      <div class="content-body">
               <?php $value = isset($data['payment_invoice'])?$data['payment_invoice']:"";  ?>
                <form method="post" id="payment_invoice_form" name="payment_invoice_form">
         <div class="card">
            <div class="card-body">
               <input type="hidden" name="action" id="action" value="post_data_sales">
                  <input type="hidden" name="table_name" id="table_name" value="sales_payment">
                  <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
              <div class="row g-4">
                 <div class="col-md">
                   <div class="form-floating">
                      <select class="form-select" name="customer_id" id="customer_id" aria-label="Floating label select example" >
                        <option value="">Select</option>
                      <?php 
                           if(!empty($data['customer']))
                           {
                              foreach($data['customer'] as $row)
                                 { ?>
                                    <option <?= isset($value['customer_id']) && ($value['customer_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['registerd_name']?></option>
                           <?php
                                 }
                            } 
                           ?>
                              </select>
                    <label for="floatingSelectGrid">Customer Name*</label>
                 </div>
              </div>
              <div class="col-md">
                <div class="form-floating">
                  <input type="text" class="form-control" id="amount_received" name="amount_received" placeholder="Amount Received" value="<?= isset($value['amount_received'])?$value['amount_received']:''?>">
                 <label for="floatingSelectGrid">Amount Received $*</label>
              </div>
           </div>
           <div class="col-md">
                <div class="form-floating">
                  <input type="text" class="form-control" id="bank_charge" name="bank_charge" placeholder="Bank Charges" value="<?= isset($value['bank_charge'])?$value['bank_charge']:''?>">
                 <label for="floatingSelectGrid">Bank Charges(if any)</label>
              </div>
           </div>
           <div class="col-md">
                <div class="form-floating">
                  <input type="Date" class="form-control" id="payment_date" name="payment_date" placeholder="Payment Date" value="<?= isset($value['payment_date'])?$value['payment_date']:''?>">
                 <label for="floatingSelectGrid">Payment Date</label>
              </div>
           </div>
     </div>

     <br>
     <div class="row g-4">
        <div class="col-md">
       <div class="form-floating">
         <input type="text" class="form-control" id="payment_id" name="payment_id" placeholder="Payment" value="<?= isset($value['payment_id'])?$value['payment_id']:''?>">
         <label for="floatingInputGrid">Payment#*</label>
      </div>
   </div>
      <div class="col-md">
       <div class="form-floating">
         <select class="form-select" id="payment_mode" name="payment_mode" aria-label="Floating label select example">
            <option>Select</option>
           <option value="Bank Transfer">Bank Transfer</option>
           <option value="Cash">Cash</option>
           <option value="Card">Card</option>
        </select>
        <label for="floatingSelectGrid">Payment Mode</label>
      </div>
   </div>

   <div class="col-md">
       <div class="form-floating">
         <input type="text" class="form-control" id="reference_id" name="reference_id" placeholder="Reference" value="<?= isset($value['reference_id'])?$value['reference_id']:''?>">
         <label for="floatingInputGrid">Reference#  <i class="fa fa-info-circle"></i></label>
      </div>
   </div>
               <div class="col-md">
                <div class="form-floating">
                  <select class="form-select" name="currency_id" id="currency_id" aria-label="Floating label select example">
                     <option value="">Select</option>
                     <?php 
                        if(!empty($data['currency']))
                        {
                           foreach($data['currency'] as $row)
                           { ?>
                              <option <?= isset($value['currency_id']) && ($value['currency_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?=$row['currency_code']?> (<?=$row['currency_symbol']?>) - <?=$row['currency_name']?></option>
                        <?php
                           }
                         } 
                        ?>
                  </select>
                 <label for="floatingSelectGrid">Exchange Currency</label>
              </div>
           </div>
</div>
<br>
<div class="row">
   
  <div class="col-md-6">
   <input type="radio"  id="tax_deduction" name="tax_deduction"><label for="No Tax deducted" class="mr-1" value="1">No Tax deducted</label>
   <input type="radio"  id="tax_deduction" name="tax_deduction"><label for="Yes,TDS" class="mr-1" value="1">Yes,TDS</label>
</div>
<div class="col-md-6">
    <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
</div>
</div>

</div>
</div>
<div class="card">
<div class="card-body">
<section id="form-repeater">
 <div class="row">
  <div class="col-12">
   <div class="card">
    <div class="card-content collapse show">
     <div class="card-body">
      <div class="repeater-default">
       <div data-repeater-list="car">
         <div class="">
            <div class="row">
               <div class="col-md-6">
                  <div class="row">
                     <div class="col-md-3">
                        <span>Unpaid Invoices</span>
                     </div>
                     <div class="col-md-6">
                        <input type="date" class="form-control" id="floatingInputGrid" placeholder="" value="">
                     </div>
                  </div>
            </div>
           
            <div class="col-md-6 text-right">
            <a href="" style="color:red;"><u>Clear Applied Amount</u></a>
            </div>
            </div>
            <br>
            <table id="myTable" class="table  table-bordered zero-configuration">

               <thead class="threadClass"> 
                  <tr> 
                     <th></th>
                     <th>Date</th> 
                     <th>Due Date</th> 
                     <th>Invoice No.</th> 
                     <th>Currency</th> 
                     <th>Invoice Amount</th> 
                     <th>Amount Due</th>
                     <th>Payment</th> 
                  </tr> 
               </thead> 
               <tbody> 
                  <tr>
                     <td>..</td> 
                     <td class="text-center">05 Jun,2022</td> 
                     <td class="text-center">08,Jun,2022</td> 
                     <td class="text-center">INV-000002</td> 
                     <td class="text-center">ZAR 108281.35</td> 
                     <td class="text-center">$6256.00</td> 
                     <td class="text-center">$1,526.00</td> 
                     <td class="text-center">$100.00</td>
                  </tr>
                   
                 </tbody>
              </table>
              <div class="row">
               <div class="col-md-10">
              <h6>*List contains only SENT invoices</h6>
           </div>
           <div class="col-md-2" style="text-align: right;">
              <h6>Total : $100.00</h6>
           </div>
           </div>
           <br>
        </div>
       
   </div>
   <div class="row">
     <div class="col-md-5">
        <textarea placeholder="Notes (Internal use. Not visible to customer)" rows="4" cols="50" class="form-control"></textarea>
     </div>
      <div class="col-md-3"></div>
      <div class="col-md-4 add-form-footer p-2">
        <div class="row">
            <div class="col-md-7">
               <span>Amount Received</span>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
               <span>$100.00</span>
            </div>
         </div>
         <div class="row">
            <div class="col-md-7">
               <span>Amount used for Payments</span>

            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
               <span>$100.00</span>
            </div>
         </div>
         <div class="row">
            <div class="col-md-7">
               <span>Amount Refunded</span>

            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
               <span>$00.00</span>
            </div>
         </div>
         <div class="row">
            <div class="col-md-7">
               <span>Amount in Excess</span>

            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
               <span>$00.00</span>
            </div>
         </div>

      </div>

   </div>
</div> 
<br>
      <div class="row">
      <div class="col-md-6">
      <div class="form-footer text-left">
         <button  type="file" class="btn btn-outline-info " style="color:red;"><i class="fa fa-cloud-upload"></i> Upload File</button> You can upload a maximum of 3 files, 5MB each
      </div>
      </div>
      <div class="col-md-6">
         <div class="form-footer text-right">
         <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
         </div>
      </div>
      </div>
</div>
</div>
</div>
</div>
</div>
</section>
</div>
</form>
</div>

</div>
</div>
</div>

