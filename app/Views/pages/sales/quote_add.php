<style type="text/css">
  .nodisplay {
      display: none;
  }
  .display {
      display: all;
  }
  .f-w-600 {
    font-weight: 600;
  }
</style>
<div class="app-content content">
  <div class="content-wrapper">
  <?= view('includes/breadcrumb.php');?>
    <div class="content-body">
    <?php $value = isset($data['quotes'])?$data['quotes']:"";?>
      <form method="post" id="quotes_form" name="quotes_form">
        <div class="card">
          <div class="card-body">
            <input type="hidden" name="action" id="action" value="post_data_sales">
            <input type="hidden" name="table_name" id="table_name" value="quotes">
            <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
            <input type="hidden" name="store_id" id="store_id" value="<?= isset($data['store_id'])?$data['store_id']:''?>">
            <h6>Store Name</h6>
            <h5><b><?= isset($data['s_name']['store_name'])?$data['s_name']['store_name']:''?></b></h5>
            <div class="row g-4">
              <div class="col-md-3">
                <div class="form-floating">
                  <select class="form-select customer_list" name="customer_id" id="customer_id" aria-label="Floating label select example" >
                    <option value="">Select</option>
                    <?php 
                    if(!empty($data['customer'])) {
                      foreach($data['customer'] as $row) { ?>
                      <option <?= isset($value['customer_id']) && ($value['customer_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['registerd_name']?></option>
                    <?php } } ?>
                    <option class="font-color" value="others">Add Customer</option>
                  </select>
                  <label for="floatingSelectGrid">Customer Name*</label>
                </div>
              </div>
              <div class="col-md-3">
                 <div class="form-floating">
                    <?php
                     $quoteNo = isset($data['quote_number'])?$data['quote_number']:'';
                     $quote_number = 'QOT'.date('ymd').'0000'.$quoteNo; ?>
                    <input type="text" class="form-control" id="" name="quote_number" placeholder="Quote Number" value="<?= isset($value['id'])?$value['quote_number']:$quote_number;?>">
                    <label for="floatingSelectGrid">Quote Number*</label>
                 </div>
              </div>
              <div class="col-md-3">
                 <div class="form-floating">
                    <input type="Date" class="form-control" id="quote_date" name="quote_date" placeholder="Invoice Date" value="<?= isset($value['quote_date'])?$value['quote_date']:date('Y-m-d')?>">
                    <label for="floatingSelectGrid">Quote Date</label>
                 </div>
              </div>
              <div class="col-md-3">
                 <div class="form-floating">
                    <select class="form-select" id="terms" name="terms" aria-label="Floating label select example">
                       <option selected disabled>Select Terms</option>
                       <option value="15" <?= isset($value['terms'])&&($value['terms']=='15')?'selected':''?>>Net 15</option>
                       <option value="30" <?= isset($value['terms'])&&($value['terms']=='30')?'selected':''?>>Net 30</option>
                       <option value="45" <?= isset($value['terms'])&&($value['terms']=='45')?'selected':''?>>Net 45</option>
                       <option value="60" <?= isset($value['terms'])&&($value['terms']=='60')?'selected':''?>>Net 60</option>
                       <option value="90" <?= isset($value['terms'])&&($value['terms']=='90')?'selected':''?>>Net 90</option>
                       <option value="120" <?= isset($value['terms'])&&($value['terms']=='120')?'selected':''?>>Net 120</option>
                       <option value="0">Due end of the month</option>
                       <option value="1">Due end of next month</option>
                       <option value="2">Due on receipt</option>
                    </select>
                    <label for="floatingInputGrid">Terms</label>
                 </div>
              </div>
            </div>
            <br>
            <div class="row g-4">
                <div class="col-md-3">
                   <div class="form-floating">
                      <input type="date" class="form-control" id="due_date" name="due_date" placeholder="Due Date" value="<?= isset($value['due_date'])?$value['due_date']:''?>">
                      <label for="floatingInputGrid">Due Date</label>
                   </div>
                </div>
                <div class="col-md-3">
                   <div class="form-floating">
                        <input type="hidden" name="base_currency_id" id="base_currency_id" value="<?= $data['base_currency_id'] ?>">
                         <select class="form-select" onchange="$('#currency_rate').val($(this).find(':selected').attr('data-rate'))" name="currency_id" id="currency_id" aria-label="Floating label select example">
                            <option value="">N/A</option>
                          <?php 
                            if(!empty($data['currency']))
                            {
                              foreach($data['currency'] as $row)
                              { ?>
                                 <option data-rate="<?= $row['exchange_rate']?>" <?= isset($value['currency_id']) && ($value['currency_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?=$row['currency_code']?> (<?=$row['currency_symbol']?>) - <?=$row['currency_name']?></option>
                                <?php
                              }
                            } 
                          ?>
                      </select>
                      <label for="floatingSelectGrid">Exchange Currency</label>
                   </div>
                </div>
                <div class="col-md-3 curr-row d-none">
                  <div class="form-floating">
                    <input type="text" class="form-control" name="currency_rate" id="currency_rate" value="<?= isset($value['currency_rate'])?$value['currency_rate']:''?>" placeholder="Currency Rate">
                    <label for="floatingSelectGrid">Currency Rate</label>
                  </div>
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
                                <table id="quoteItemTable" class="table table-bordered module-items-tbl">
                                   <thead class="threadClass">
                                      <tr> 
                                         <th>#</th>
                                         <th>Item ID</th>
                                         <th>Item Name</th>
                                         <th>UOM</th>
                                         <th>Quantity</th>
                                         <th>Rate</th>
                                         <th>Discount</th>
                                         <th>Tax</th>
                                         <th>Tax (Excl)</th>
                                         <th>Amount</th>
                                         <th>Action</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      <?php if(isset($data['quote_items']) && !empty($data['quote_items'])){
                                         foreach($data['quote_items'] as $k=>$row){
                                         ?>
                                           <tr class="new-row">
                                            <td class="text-center"><?= $k+1 ?></td>
                                            <td colspan="2">
                                               <input type="hidden" name="items[<?= $k+1; ?>][id]" value="<?= $row['id']; ?>">
                                               <select class="form-control form-select select2 item-add quote-item-o text-left" data-tab="sell" name="items[<?= $k+1; ?>][item_id]">
                                                  <option value="">Click to select item</option>
                                                  <?php
                                                  $items = json_decode($data['items']);
                                                  
                                                   foreach($items as $v) { ?>
                                                     <option value="<?= $v->id; ?>" <?php if($v->id == $row['item_id']) { echo 'selected';} ?>><?= $v->item_name; ?></option>
                                                  <?php } ?>
                                               </select>
                                            </td>
                                             <td>
                                               <input class="uom form-control " type="text" name="items[<?= $k+1; ?>][uom]" value="<?= $row['uom_value']; ?>"><input class="uomid form-control " type="hidden" name="items[<?= $k+1; ?>][uomid]" value="<?= $row['uom_id']; ?>">
                                            </td>
                                            <td>
                                               <input class="form-control quantity" type="number" name="items[<?= $k+1; ?>][quantity]" value="<?= $row['qty']; ?>">
                                            </td>
                                            <td>
                                              <input class="form-control rate" type="text" name="items[<?= $k+1; ?>][rate]" value="<?= $row['rate']; ?>">
                                            </td>
                                            <td>
                                                <input class="discount form-control" type="number" name="items[<?= $k+1; ?>][discount]" value="<?= $row['discount']; ?>">&nbsp;<select class="form-control discount form-select" name="items[<?= $k+1; ?>][discount_type]"><option value="%" <?php $row['discount_type'] == '%' ? 'selected' : '' ?>>%</option><option value="ZMW" <?php $row['discount_type'] == 'ZMW' ? 'selected' : '' ?>>ZMW</option></select>
                                                <input class="discount_amount form-control" type="hidden" name="items[<?= $k+1; ?>][discount_amount]" value="<?= $row['discount_amount']; ?>">
                                            </td>
                                            <td class="flex is_include_tax">
                                               <input type="text" name="items[<?= $k+1; ?>][tax_amount]" class="form-control tax_amount" value="<?= $row['tax_amount']; ?>" readonly>
                                               <input class="tax form-control tax" type="hidden" name="items[<?= $k+1; ?>][tax]" value="<?= $row['tax_value']; ?>" readonly>&nbsp;<input class="form-control form-border tax_type" type="hidden" name="items[<?= $k+1; ?>][tax_type]" value="<?= $row['tax_name']; ?>" readonly>
                                            </td>
                                            <td class="form-group text-center">
                                               <input type="hidden" class="tax_exc_amt" name="items[<?= $k+1; ?>][tax_exc_amt]" value="<?= $row['tax_excl'] == 1 ? $row['tax_amount'] : '0'?>">
                                               <input class="tax_excl" id="tax_excl<?= $k+1; ?>" type="checkbox" name="items[<?= $k+1; ?>][tax_excl]" value="<?= $row['tax_excl']; ?>" <?= $row['tax_excl'] == 1 ? 'checked':''; ?>>
                                               <label for="tax_excl<?= $k+1; ?>"></label>
                                            </td>
                                             <td>
                                              <input class="tabledit-input form-control amount" type="text" name="items[<?= $k+1; ?>][amount]" value="<?= $row['item_amount'] ?>">
                                            </td>
                                            <td>
                                               <a href="#" class="transh-icon-color item-remove" data-del="1" data-row="<?= $k+1; ?>" title="Remove"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                         </tr>
                                         <?php }
                                      }else{ ?>
                                       <tr class="new-row">
                                            <td class="text-center">1</td>
                                            <td colspan="2">
                                               <select name="items[1][item_id]" class="quote-item-o item-add form-control">
                                               </select>
                                            </td>
                                            <td>
                                               <input class="uom form-control " type="text" name="items[1][uom]"><input class="uomid form-control " type="hidden" name="items[1][uomid]">
                                            </td>
                                            <td>
                                               <input class="form-control quantity" type="number" name="items[1][quantity]" value="1">
                                            </td>
                                            <td>
                                               <input class="form-control rate" type="text" name="items[1][rate]">
                                            </td>
                                            <td class="text-center">
                                               <input class="discount form-control " type="number" name="items[1][discount]">&nbsp;<select class="form-control discount form-select" name="items[1][discount_type]"><option value="%">%</option><option value="ZMW">ZMW</option></select>
                                                <input class="discount_amount form-control" type="hidden" name="items[1][discount_amount]" value="0.00">
                                            </td>
                                            <td class="flex is_include_tax">
                                               <input type="text" name="items[1][tax_amount]" class="form-control tax_amount" readonly>
                                               <input class="tax form-control form-border tax" type="hidden" name="items[1][tax]">&nbsp;
                                               <input class="form-control form-border tax_type" type="hidden" name="items[1][tax_type]">
                                            </td>
                                            <td class="form-group text-center">
                                               <input type="hidden" class="tax_exc_amt" name="items[1][tax_exc_amt]" value="0">
                                               <input class="tax_excl" id="tax_excl1" type="checkbox" name="items[1][tax_excl]" value="1">
                                               <label for="tax_excl1"></label>
                                            </td>
                                             <td>
                                               <input class="tabledit-input form-control amount" type="text" name="items[1][amount]">
                                            </td>
                                            <td>
                                               <!-- <a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a> -->
                                            </td>
                                         </tr>
                                        <?php } ?>
                                   </tbody>
                                </table>
                                <div class="form-group overflow-hidden">
                                   <div class="col-12">
                                      <button  onclick="addQuoteItem();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
                                   </div>
                                </div>
                                <input type="hidden" name="deleted_items" id="deleted-items">
                                 <div class="row">
                                    <div class="col-md-5">
                                       <textarea name="note" placeholder="Customer Notes" rows="4" cols="50" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5 add-form-footer p-2">
                                      <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4 conv-currency" style="visibility: hidden;"><h4 class="conv-curr-symbol f-w-600"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></h4></div>
                                        <div class="col-md-4"><h4 class="f-w-600"><?= $data['currency_symbol'] ?></h4></div>
                                      </div>
                                        <div class="row" style="border-top: 1px solid #bcbcbc;border-bottom: 1px solid #bcbcbc;">
                                           <div class="col-md-4">
                                              <span>Discount</span>
                                           </div>
                                           <div class="col-md-4 conv-currency" style="visibility: hidden;">
                                              <span class="currdiscountAmount"><?= isset($value['currency_discount']) ? $value['currency_discount'] : '0.00' ?></span>
                                              <input type="hidden" value="<?= isset($value['currency_discount']) ? $value['currency_discount'] : '0.00' ?>" name="currency_discount" id="curr-total-discount">
                                           </div>
                                           <div class="col-md-4">
                                              <span class="discountAmount"><?= isset($value['total_discount']) ? $value['total_discount'] : '0.00' ?></span>
                                              <input type="hidden" value="<?= isset($value['total_discount']) ? $value['total_discount'] : '0.00' ?>" name="total_discount" id="total-discount">
                                           </div>
                                        </div>
                                       <div class="row">
                                             <div class="col-md-4">
                                                <span>Subtotal</span>
                                             </div>
                                             <div class="col-md-4 conv-currency" style="visibility: hidden;">
                                                <!-- <span class="conv-curr-symbol f-w-600"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></span> --><span class="subCurrTotal"><?= isset($value['sub_curr_total']) ? $value['sub_curr_total'] : '0.00' ?></span>
                                                <input type="hidden" value="<?= isset($value['sub_curr_total']) ? $value['sub_curr_total'] : '0.00' ?>" name="sub_curr_total" id="sub-curr-total">
                                             </div>
                                             <div class="col-md-4">
                                                <!-- <span class="f-w-600"><?= $data['currency_symbol'] ?></span> --><span class="subTotal"><?= isset($value['sub_total']) ? $value['sub_total'] : '0.00' ?></span>
                                                <input type="hidden" value="<?= isset($value['sub_total']) ? $value['sub_total'] : '0.00' ?>" name="sub_total" id="sub-total">
                                             </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-md-4">
                                                <span id="tax_text">Tax</span>
                                           </div>
                                           <div class="col-md-4 conv-currency" style="visibility: hidden;">
                                              <span class="currTax"><?= isset($value['currency_tax']) ? $value['currency_tax'] : '0.00' ?></span>
                                                <input type="hidden" value="<?= isset($value['currency_tax']) ? $value['currency_tax'] : '0.00' ?>" name="currency_tax" id="curr-tax">
                                           </div>
                                           <div class="col-md-4">
                                              <span class="taxAmount"><?= isset($value['total_tax']) ? $value['total_tax'] : '0.00' ?></span>
                                              <input type="hidden" value="<?= isset($value['total_tax']) ? $value['total_tax'] : '0.00' ?>" name="total_tax" id="total-tax">
                                           </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-4">
                                                <span>Adjustment</span></div>
                                             <div class="col-md-4">
                                               
                                             </div>
                                             <div class="col-md-4 form-footer-center">
                                                 <input type="text" class="form-control amount-footer adjustment_value" name="adjustment_value" placeholder="Amount" value="0">
                                                <i class="fa fa-info-circle"></i>
                                             </div>
                                        </div>
                                        <hr>
                                        <div class="row form-footer-right">
                                          <div class="col-md-3"style="padding-top: 10px;">
                                              <span>Total <!-- (<span id="curr-name"><?= $data['currency_code'] ?></span>) --></span>
                                          </div>
                                          <div class="col-md-4 conv-currency" style="visibility: hidden;">
                                            <div class="d-flex">
                                              <span class="pt-1 conv-curr-symbol"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></span>&nbsp;
                                              <span><input type="text" class="form-control form-border" name="conv_total_amount" id="conv-total-amount" value="<?= isset($value['currency_total']) ? $value['currency_total'] : '0.00' ?>" readonly></span>
                                            </div>
                                          </div>
                                          <div class="col-md-5">
                                            <div class="d-flex">
                                              <span class="pt-1 curr-symbol"><?= $data['currency_symbol'] ?></span>&nbsp;
                                              <span><input type="text" class="form-control form-border" name="total_amount" id="total-amount" value="<?= isset($value['total_amount']) ? $value['total_amount'] : '0.00' ?>" readonly></span></div>
                                          </div>
                                        </div>
                                        <!-- <div class="row form-footer-right pt-1" style="display: none;">
                                          <div class="col-md-7">
                                              <span>Total (<span id="conv-curr-name"></span>)</span>
                                          </div>
                                          <div class="col-md-5 float-right" style="margin-top:-20px;">
                                              <div class="d-flex">
                                                <span class="pt-1 conv-curr-symbol"></span>
                                                <span><input type="text" class="form-control form-border" name="conv_total_amount" id="conv-total-amount" value="0.00" readonly></span>
                                              </div>
                                          </div>
                                        </div> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="form-footer text-right">
                                   <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>        
<!-- Model Start -->         
<div class="modal fade text-left" id="others" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Add Customer</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="model_customer_form" name="model_customer_form">
            <input type="hidden" name="action" id="action" value="post_data">
            <input type="hidden" name="table_name" id="table_name" value="customers">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="status" id="status" value="1">
            <div class="modal-body">
               <div class="row">
                   <div class="col-md-3 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="account_id" id="account_id" placeholder="Account ID" value="" >
                        <label for="Account ID">Account ID*</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="tpin_no" id="tpin_no" placeholder="TPIN No.*" value="" >
                        <label for="TPIN No.">TPIN No.</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="lpo_no" id="lpo_no" placeholder="LPO No." value="" >
                        <label for="LPO No.">LPO No.</label>
                     </div>
                  </div>
                   <div class="col-md-3 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="id_no" id="id_no" placeholder="ID No." value="" >
                        <label for="ID No.">ID No.*</label>
                     </div>
                  </div>
               </div><br>
               <div class="row">
                  <div class="col-md-4 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="registerd_name" id="registerd_name" placeholder="Registered Name" value="" >
                        <label for="Registered Name">Registered Name*</label>
                     </div>
                  </div>
                  <div class="col-md-4 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="tax_account_name" id="tax_account_name" placeholder="Tax Account Name" value="" >
                        <label for="Tax Account Name">Tax Account Name*</label>
                     </div>
                  </div>
                  <div class="col-md-4 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="" >
                        <label for="Address">Address*</label>
                     </div>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-md-3 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email Id" value="" >
                        <label for="Email Id">Email Id</label>
                     </div>
                  </div>
                   <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control"  name="phone" id="phone" placeholder="Phone"  style="height: 50px;">
                        <!-- <label for="floatingSelectGrid">Phone*</label> -->
                     </div>
                  </div>
                  <div class="col-md-3 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="receivables" id="receivables" placeholder="Receivable" value="" >
                        <label for="Receivable">Receivable</label>
                     </div>
                  </div>
                  <div class="col-md-3 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="loyalty" id="loyalty" placeholder="Loyalty" value="" >
                        <label for="Loyalty">Loyalty</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="addcustomer" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade text-left" id="edit_invoice_note_mdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Note down the reason for editing an invoice that has already been sent.</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="edit_invoice_note" name="edit_invoice_note">
            <input type="hidden" name="action" id="action" value="post_data_sales">
            <input type="hidden" name="table_name" id="table_name" value="sell_order_editnote">
            <input type="hidden" name="id" id="id" value="">
            <div class="modal-body">
               <div class="row">
                   
                   <div class="col-md-12">
                     <div class="form-floating">
                        <input type="hidden" name="invoice_id" id="edit_invoice_id" value="">
                        <textarea class="form-control" name="edit_notes" id="edit_notes" placeholder="Note" style="height: 100px"></textarea>
                        <label for="edit_notes">Note</label>
                     </div>
                  </div>
               </div><br>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="btnSubmit" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Model End -->

