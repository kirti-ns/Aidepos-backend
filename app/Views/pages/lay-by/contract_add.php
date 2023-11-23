<style type="text/css">
   #contract .new-row td {
      padding: 0px 0px 0px 0px;
   }
   .discount, .discount_type {
      width: 100%!important;
   }
   .depositTbl .table tbody tr td:nth-child(1) {
      width: 15%;
   }
   .form-control-nx {
      position: relative;
      flex: 1 1 auto;
      width: 1%;
      min-width: 0;
      -webkit-box-flex: 1;
      margin-bottom: 0;
      border: 1px solid #D4D4D4;
      color: #5A5A5A;
      display: block;
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      -moz-appearance: none;
      appearance: none;
      border-radius: 0.25rem;
      transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
      height: calc(2.75rem + 2px);
   }
</style>
<div class="app-content content">
   <div class="content-wrapper">
      <?= view('includes/breadcrumb.php');?> 
      <div class="content-body">
         <?php $value = isset($data['contract'])?$data['contract']:"";?>
         <form method="post" id="layby_contract_form" name="layby_contract_form">
         <div class="card">
            <div class="card-body">
               <input type="hidden" name="action" id="action" value="post_layby_data">
               <input type="hidden" name="table_name" id="table_name" value="layby_contract">
               <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-floating">
                        <select class="form-select customer-id" name="customer_id" id="customer_id" aria-label="Floating label select example">
                              <option value="">Select Customer</option>
                              <?php 
                               if(!empty($data['customers']))
                               {
                                 foreach($data['customers'] as $row)
                                 { ?>
                                    <option value="<?= $row['id']?>" <?= isset($value['customer_id']) && ($value['customer_id'] == $row['id']) ?'selected':''?>><?=$row['registerd_name']?></option>
                                   <?php
                                 }
                               } 
                             ?>
                        </select>
                        <label for="floatingInputGrid">Customer*</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="firstname" id="f-name" value="<?= isset($value['first_name'])?$value['first_name']:''?>" placeholder="123...">
                        <label for="floatingInputGrid">Customer First Name*</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="lastname" id="l-name" value="<?= isset($value['last_name'])?$value['last_name']:''?>" placeholder="123..." >
                        <label for="floatingInputGrid">Last Name*</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="phone" id="tel-phone" value="<?= isset($value['phone'])?$value['phone']:''?>" placeholder="Phone">
                        <!-- <label for="floatingInputGrid">Phone*</label> -->
                     </div>
                  </div>
               </div>
               <br>
               <div class="row">
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
                     <!-- <div class="form-floating">
                        <input type="text" class="form-control" name="address" id="address" value="<?= isset($value['address'])?$value['address']:''?>" placeholder="123..." >
                        <label for="floatingInputGrid">Address</label>
                     </div> -->
                  </div>
                  <div class="col-md-3">
                    <div class="form-floating">
                      <input type="date" class="form-control" id="due_date" name="due_date" placeholder="Due Date" value="<?= isset($value['due_date'])?$value['due_date']:''?>">
                      <label for="floatingInputGrid">Due Date</label>
                    </div>
                     <!-- <div class="form-floating">
                        <input type="text" class="form-control" name="zip" id="zip" value="<?= isset($value['zipcode'])?$value['zipcode']:''?>" placeholder="123..." >
                        <label for="floatingInputGrid">ZIP</label>
                     </div> -->
                  </div>
                  <div class="col-md-3">
                    <div class="form-floating">
                        <input type="hidden" name="base_currency_id" id="base_currency_id" value="<?= $data['base_currency_id'] ?>">
                        <select class="form-select" name="exchange_rate" onchange="$('#currency_rate').val($(this).find(':selected').attr('data-rate'))" id="exchange-rate" aria-label="Floating label select example">
                               <option value="0">N/A</option>
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
                        <label for="floatingSelectGrid">Exchange Rate</label>
                     </div>
                     <!-- <div class="form-floating">
                        <input type="text" class="form-control" name="city" id="city" value="<?= isset($value['city'])?$value['city']:''?>" placeholder="123..." >
                        <label for="floatingInputGrid">City</label>
                     </div> -->
                  </div>
                  <div class="col-md-3">
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
                                 <div class="repeater-default">
                                    <div data-repeater-list="car">
                                       <div class="">
                                          <table id="contract" class="table table-bordered">
                                             <thead class="threadClass">
                                                <tr>
                                                   <th></th>
                                                   <th>Item ID</th>
                                                   <th>Item Name</th>
                                                   <th>UOM</th>
                                                   <th>Quantity</th>
                                                   <th>Rate</th>
                                                   <th>Discount</th>
                                                   <th>Tax Amount</th>
                                                   <th>Tax (Excl)</th>
                                                   <th>Amount</th>
                                                   <th>Action</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php 
                                                   $items = json_decode($data['items']);
                                                   if(isset($data['contract_items']) && !empty($data['contract_items'])) {
                                                   foreach($data['contract_items'] as $k => $row) { ?>
                                                   <tr class="new-row">
                                                      <td class="text-center">
                                                         <?= $k+1; ?>
                                                         <input type="hidden" name="items[<?= $k+1; ?>][id]" value="<?= $row['id']; ?>">
                                                      </td>
                                                      <td colspan="2">
                                                        <select class="form-control form-select select2 cont-item-add item_id-contract-1 text-left" name="items[<?= $k+1; ?>][item_id]">
                                                           <option value="">Click to select item</option>
                                                           <?php
                                                           $items = json_decode($data['items']);
                                                           
                                                            foreach($items as $v) { ?>
                                                              <option value="<?= $v->id; ?>" <?php if($v->id == $row['item_id']) { echo 'selected';} ?>><?= $v->item_name; ?></option>
                                                           <?php } ?>
                                                        </select>
                                                      </td>
                                                      <td>
                                                         <input class="uom form-control" type="text" name="items[<?= $k+1; ?>][uom]" value="<?= $row['uom_value']; ?>"><input class="uomid form-control" type="hidden" name="items[<?= $k+1; ?>][uomid]" value="<?= $row['uom_id']; ?>">
                                                      </td>
                                                      <td>
                                                         <input class="form-control quantity" type="number" name="items[<?= $k+1; ?>][quantity]" value="<?= $row['qty']; ?>">
                                                      </td>
                                                      <td>
                                                         <input class="form-control rate" type="text" name="items[<?= $k+1; ?>][rate]" value="<?= $row['rate']; ?>">
                                                      </td>
                                                      <td class="d-flex">
                                                         <input class="discount_amount form-control" type="hidden" name="items[<?= $k+1; ?>][discount_amount]" value="<?= $row['discount_amount']; ?>">
                                                         <input class="lb-discount form-control" type="number" name="items[<?= $k+1; ?>][discount]" value="<?= $row['discount']; ?>">
                                                         <select class="form-control lb-discount-type form-select" name="items[<?= $k+1; ?>][discount_type]">
                                                            <option value="%" <?php $row['discount_type'] == '%' ? 'selected' : '' ?>>%</option>
                                                            <option value="ZMW" <?php $row['discount_type'] == 'ZMW' ? 'selected' : '' ?>>ZMW</option>
                                                         </select>
                                                      </td>
                                                      <td>
                                                         <input type="text" name="items[<?= $k+1; ?>][tax_amount]" class="form-control tax_amount" value="<?= $row['tax_amount']; ?>" readonly>
                                                         <input class="form-control form-border tax" type="hidden" name="items[<?= $k+1; ?>][tax]" value="<?= $row['tax_value']; ?>">
                                                         <input class="form-control form-border tax_type" type="hidden" name="items[<?= $k+1; ?>][tax_type]" value="<?= $row['tax_name']; ?>">
                                                      </td>
                                                      <td class="form-group text-center">
                                                         <input type="hidden" class="tax_exc_amt" name="items[<?= $k+1; ?>][tax_exc_amt]" value="<?= $row['tax_excl'] == 1 ? $row['tax_amount'] : '0'?>">
                                                         <input class="tax_excl" id="tax_excl<?= $k+1; ?>" type="checkbox" name="items[<?= $k+1; ?>][tax_excl]" value="<?= $row['tax_excl']; ?>" <?= $row['tax_excl'] == 1 ? 'checked':''; ?>>
                                                         <label for="tax_excl1"></label>
                                                      </td>
                                                      <td>
                                                         <input class="tabledit-input form-control amount" type="text" name="items[<?= $k+1; ?>][amount]" value="<?= $row['item_amount'] ?>">
                                                      </td>
                                                      <td class="text-center">
                                                         <!-- <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a> -->
                                                      </td>
                                                   </tr>
                                                   <?php }
                                                   } else { ?>
                                                <tr class="new-row">
                                                   <td class="text-center">1</td>
                                                   <td colspan="2">
                                                     <select class="form-control form-select select2 cont-item-add item_id-contract-1 text-left" name="items[1][item_id]">
                                                        <option value="">Click to select item</option>
                                                        <?php
                                                        $items = json_decode($data['items']);
                                                        
                                                         foreach($items as $v) { ?>
                                                           <option value="<?= $v->id; ?>"><?= $v->item_name; ?></option>
                                                        <?php } ?>
                                                     </select>
                                                  </td>
                                                   <td>
                                                      <input class="uom form-control" type="text" name="items[1][uom]"><input class="uomid form-control " type="hidden" name="items[1][uomid]">
                                                   </td>
                                                   <td>
                                                      <input class="form-control quantity" type="number" name="items[1][quantity]" value="1">
                                                   </td>
                                                   <td>
                                                      <input class="form-control rate" type="text" name="items[1][rate]">
                                                   </td>
                                                   <td class="d-flex">
                                                      <input class="discount_amount form-control" type="hidden" name="items[1][discount_amount]" value="0.00">
                                                      <input class="lb-discount form-control" type="number" name="items[1][discount]">
                                                      <select class="form-control lb-discount-type form-select" name="items[1][discount_type]">
                                                         <option value="%">%</option>
                                                         <option value="ZMW">ZMW</option>
                                                      </select>
                                                   </td>
                                                   <td>
                                                      <input type="text" name="items[1][tax_amount]" class="form-control tax_amount" readonly>
                                                      <input class="form-control form-border tax" type="hidden" name="items[1][tax]">
                                                      <input class="form-control form-border tax_type" type="hidden" name="items[1][tax_type]">
                                                   </td>
                                                   <td class="form-group text-center">
                                                     <input type="hidden" class="tax_exc_amt" name="items[1][tax_exc_amt]" value="0">
                                                     <input class="tax_excl" id="tax_excl1" type="checkbox" name="items[1][tax_excl]" value="1">
                                                     <label for="tax_excl1"></label>
                                                   </td>
                                                   <td>
                                                      <input class="tabledit-input form-control amount" type="text" name="items[1][amount]" value="">
                                                   </td>
                                                   <td class="text-center">
                                                      <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>
                                                   </td>
                                                </tr>
                                             <?php } ?>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                    <div class="form-group overflow-hidden">
                                       <div class="col-12">
                                          <button  onclick="addContractField();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-5">
                                       <textarea placeholder="Customer Notes" name="notes" rows="4" cols="50" class="form-control"><?= isset($value['notes'])?$value['notes']:'' ?></textarea>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5 add-form-footer p-2">
                                      <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4 conv-currency" style="visibility: hidden;"><h4 class="conv-curr-symbol f-w-600"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></h4></div>
                                        <div class="col-md-4"><h4 class="f-w-600"><?= $data['currency_symbol'] ?></h4></div>
                                      </div>
                                       <div class="row">
                                          <div class="col-md-4">
                                             <span>Total Quantity</span>
                                          </div>
                                          <div class="col-md-4">
                                          </div>
                                          <div class="col-md-4">
                                             <span class="totalRow"><?= isset($value['total_quantity'])?$value['total_quantity']:'0'?></span>
                                             <input type="hidden" value="" name="total_quantity" id="total-quantity" value="<?= isset($value['total_quantity'])?$value['total_quantity']:'0'?>">
                                          </div>
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
                                             <span class="subTotal"><?= isset($value['sub_total']) ? $value['sub_total'] : '0.00' ?></span>
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
                                             <span><b>Lay-Bye Total</b></span>
                                          </div>
                                          <div class="col-md-4 conv-currency" style="visibility: hidden;">
                                            <div class="d-flex">
                                              <!-- <b class="conv-curr-symbol"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></b>&nbsp; -->
                                              <b><span class="conv-total-amount"><?= isset($value['currency_total']) ? $value['currency_total'] : '0.00' ?></span></b>
                                              <input type="hidden" class="form-control form-border conv-total-amount" name="conv_total_amount" id="conv-total-amount" value="<?= isset($value['currency_total']) ? $value['currency_total'] : '0.00' ?>">
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                             <!-- <b><?=$data['currency_symbol'];?></b> --><b><span class="total-amount"><?= isset($value['total_amount']) ? $value['total_amount'] : '0.00' ?></span></b>
                                             <input type="hidden" class="total-amount" name="total_amount" value="<?= isset($value['total_amount']) ? $value['total_amount'] : '0.00' ?>">
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-4 pt-1">
                                             <span>Deposit Percentage</span>
                                          </div>
                                          <div class="col-md-4 conv-currency pt-1" style="visibility: hidden;">
                                            <span class="curr-deposit_per"><?= isset($value['deposit_percentage'])?$value['deposit_percentage']:$data['layby_deposit']; ?></span>%
                                          </div>
                                          <div class="col-md-4 d-flex">
                                            <div class="input-group" style="width:90px;">
                                              <input type="text" name="layby_deposit_per" class="form-control-nx layby_deposit_per" value="<?= isset($value['deposit_percentage'])?$value['deposit_percentage']:$data['layby_deposit']; ?>">
                                              <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                              </div>
                                            </div>
                                          </div>
                                       </div>
                                       <!-- <div class="row">
                                          <div class="col-md-4">
                                             <span>Minimum Deposit</span>
                                          </div>
                                          <div class="col-md-4">
                                          </div>
                                          <div class="col-md-4"> -->
                                             <!-- <b><?=$data['currency_symbol'];?></b> <span class="deposit_amount"><?= isset($value['deposit_amount']) ? $value['deposit_amount'] : '0.00' ?></span>-->
                                             <!-- <input type="text" class="form-control deposit_amount" name="minimum_deposit" value="<?= isset($value['deposit_amount']) ? $value['deposit_amount'] : '0.00' ?>" style="width:90px;">
                                          </div>
                                       </div> -->
                                       <div class="row">
                                          <div class="col-md-4 pt-1">
                                             <span>Deposit</span>
                                          </div>
                                          <div class="col-md-4 conv-currency pt-1">
                                            <span class="currency_deposit"><?= isset($value['currency_deposit']) ? $value['currency_deposit'] : '0.00' ?></span>
                                            <input type="hidden" class="form-control amount-footer" name="currency_deposit" id="currency_deposit" value="<?= isset($value['currency_deposit']) ? $value['currency_deposit'] : '0.00' ?>">
                                          </div>
                                          <div class="col-md-4">
                                             <input type="text" class="form-control amount-footer deposit_amount" name="deposit_amount" id="deposit_amount" value="<?= isset($value['deposit_amount']) ? $value['deposit_amount'] : '0.00' ?>" <?= isset($value['deposit_amount']) ? 'readonly' : '' ?> placeholder="Amount" style="width: 90px;">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-footer text-right">
                                 <button type="button" class="btn btn-default_new"><i class="fa fa-close"></i> Cancel</button>
                                 <button type="submit" class="btn btn-info btAddContract"><i class="fa fa-file-o"></i> Save</button>
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
<!-- Model Start -->         
<div class="modal fade text-left" id="tender-media" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content" style="width: 105%;">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><b>Tender Media</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="d-flex">
                     <fieldset class="tender_media">
                        <input type="radio" name="layby_pay_type" class="inp-radio" id="input-radio-11" checked>
                        <label for="input-radio-11">Cash</label>
                     </fieldset>
                     <fieldset class="tender_media">
                        <input type="radio" name="layby_pay_type" class="inp-radio" id="input-radio-12">
                        <label for="input-radio-12">Credit Card</label>
                     </fieldset>
                     <fieldset class="tender_media">
                        <input type="radio" name="layby_pay_type" class="inp-radio" id="input-radio-13">
                        <label for="input-radio-13">Cheque</label>
                     </fieldset>
                     <fieldset class="tender_media">
                        <input type="radio" name="layby_pay_type" class="inp-radio" id="input-radio-14">
                        <label for="input-radio-14">Gift Voucher</label>
                     </fieldset>
                  </div><br>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <b><span>$371.95</span></b>
               </div>
               <div class="col-md-4">
                  <span>$00.00</span>
               </div>
               <div class="col-md-4 text-right">
                  <span style="color:red;" class="amount-to-pay">$225.00</span>
                  <input type="hidden" class="amount-to-pay">
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <span>Remaining</span>
               </div>
               <div class="col-md-4">
                  <span>Change Due</span>
               </div>
               <div class="col-md-4 text-right">
                  <span>Amount to Pay</span>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new"> <i class="fa fa-close"></i> Cancel</button>
               <button type="button" class="btn btn-info" id="sTenderMedia"> Submit</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Model End-->