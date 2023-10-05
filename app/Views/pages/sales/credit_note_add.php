<style type="text/css">
  .nodisplay {
      display: none;
  }
  .display {
      display: all;
  }
</style>
<div class="app-content content">
  <div class="content-wrapper">
  <?= view('includes/breadcrumb.php');?>
    <div class="content-body">
      <form method="post" id="credit_note_form" name="credit_note_form">
        <div class="card">
          <div class="card-body">
            <input type="hidden" name="action" id="action" value="post_data_sales">
            <input type="hidden" name="table_name" id="table_name" value="credit_notes">
            <input type="hidden" name="id" id="id" value="">
            <?php $value = isset($data['invoice'])?$data['invoice']:""; ?>
            <input type="hidden" name="invoice_id" value="<?= $value['id']; ?>">
            <input type="hidden" name="store_id" id="store_id" value="<?= isset($data['store_id'])?$data['store_id']:''?>">
            <h6>Store Name</h6>
            <h5><b><?= isset($data['s_name']['store_name'])?$data['s_name']['store_name']:''?></b></h5>
            <div class="row g-4">
              <div class="col-md">
                <div class="form-floating">
                  <select class="form-select" name="customer_id" id="customer_id" aria-label="Floating label select example" >
                    <option value="">Select</option>
                    <?php 
                    if(!empty($data['customer'])) {
                      foreach($data['customer'] as $row) { ?>
                      <option <?= isset($value['customer_id']) && ($value['customer_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['registerd_name']?></option>
                    <?php } } ?>
                  </select>
                  <label for="floatingSelectGrid">Customer Name*</label>
                </div>
              </div>
              <div class="col-md">
                <div class="form-floating">
                  <?php $creditnote = $data['creditnote']+1; ?>
                  <input type="text" id="credit_note_no" name="credit_note_no" class="form-control" value="<?= $creditnote; ?>" placeholder="Credit Note">
                  <label for="floatingSelectGrid">Credit Note*</label>
                </div>
              </div>
              <div class="col-md">
                 <div class="form-floating">
                    <input type="date" class="form-control" id="credit_date" name="credit_date" placeholder="Credit Note Date" value="<?= date('Y-m-d'); ?>">
                    <label for="floatingSelectGrid">Credit Note Date</label>
                 </div>
              </div>
              <!-- <div class="col-md">
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
                         <option value="2">Due end of receipt</option>
                      </select>
                      <label for="floatingInputGrid">Terms</label>
                   </div>
                </div> -->
            </div>
            <div class="row pt-1">
              <!-- <div class="col-md-3">
                   <div class="form-floating">
                      <input type="date" class="form-control" id="due_date" name="due_date" placeholder="Due Date" value="<?= isset($value['due_date'])?$value['due_date']:''?>">
                      <label for="floatingInputGrid">Due Date</label>
                   </div>
                </div> -->
                <div class="col-md-4">
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
                <div class="col-md-4 curr-row d-none">
                  <div class="form-floating">
                    <input type="text" class="form-control" name="currency_rate" id="currency_rate" value="<?= isset($value['currency_rate'])?$value['currency_rate']:''?>" placeholder="Currency Rate">
                    <label for="floatingSelectGrid">Currency Rate</label>
                  </div>
                </div>
            </div>
            <br>
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
                                <table id="sellItemTable" class="table table-bordered  module-items-tbl">
                                   <thead class="threadClass">
                                      <tr>
                                         <th>#</th>
                                         <th>Item</th>
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
                                      <?php if(isset($data['sell_items']) && !empty($data['sell_items'])){
                                         foreach($data['sell_items'] as $k=>$row){
                                         ?>
                                           <tr class="new-row">
                                            <td class="text-center"><?= $k+1; ?></td>
                                            <td>
                                               <input type="hidden" name="items[<?= $k+1; ?>][item_id]" value="<?= $row['item_id']; ?>">
                                               <input type="text" data-tab="sell" name="items[<?= $k+1; ?>][item_name]" class="form-control item-add" value="<?= $row['item_name']; ?>" readonly>
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
                                            <td class="text-center">
                                              <?php if($k > 0) { ?>
                                               <a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a>
                                              <?php } ?>
                                            </td>
                                         </tr>
                                         <?php 
                                         } } ?>
                                   </tbody>
                                </table>
                                <!-- <div class="form-group overflow-hidden">
                                   <div class="col-12">
                                      <button  onclick="addSellItem();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
                                   </div>
                                </div> -->
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
                                              <span>
                                                <input type="text" class="form-control form-border" name="total_amount" id="total-amount" value="<?= isset($value['total_amount']) ? $value['total_amount'] : '0.00' ?>" readonly>
                                                <input type="hidden" class="form-control form-border" name="pre_total_amount" value="<?= isset($value['total_amount']) ? $value['total_amount'] : '0.00' ?>" readonly>
                                              </span>
                                            </div>
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