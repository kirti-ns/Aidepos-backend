<style type="text/css">
  .select2-container {
    text-align: left
  }
  .table input.form-control {
    border: 1px solid #fff;
  }
  .table .select2-container--default .select2-selection--single {
    border:1px solid #fff;
  }
</style>
<?php
$taxlist = json_decode($data['taxlist']); 
?>
<div class="app-content content">
   <div class="content-wrapper">
       <?= view('includes/breadcrumb.php');?> 
      <div class="content-body">
         <?php $value = isset($data['purchase'])?$data['purchase']:"";?>
         <form method="post" id="purchase_order_form" action="<?= base_url('post_data_purchase') ?>" name="purchase_order_form">
            <div class="card">
               <div class="card-body">
                  <input type="hidden" name="action" id="action" value="post_data_purchase">
                  <input type="hidden" name="table_name" id="table_name" value="purchaseorders">
                  <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                  <div class="row g-3">
                     <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="store_id" name="store_id" aria-label="Floating label select example">
                              <option value="">Select Store</option>
                              <?php if(!empty($data['stores'])){
                                 foreach($data['stores'] as $row){
                              ?>
                              <option <?= isset($value['store_id']) && ($value['store_id'] == $row['id'])/* || (isset($data['store_id']) && $data['store_id'] == $row['id'])*/?'selected':''?> value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                              <?php }} ?>
                           </select>
                           <label for="floatingSelectGrid">Store Name*</label>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                           <select class="form-select" id="supplier_id" name="supplier_id" aria-label="Floating label select example">
                              <option value="" selected>Select Supplier</option>
                              <?php if(!empty($data['supplier'])){
                                 foreach($data['supplier'] as $row){
                                 ?>
                              <option value="<?=$row['id']?>" <?php if(isset($value['supplier_id']) && $row['id'] == $value['supplier_id']){echo'selected';} ?>><?=$row['registered_name']?></option>
                              <?php } } ?>                              </select>
                           <label for="floatingSelectGrid">Supplier Name*</label>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                          <?php if(isset($data['order_number'])){?>
                            <input type="text" class="form-control" id="order_number" placeholder="Order No" name="order_number" value="<?= isset($data['order_number'])?$data['order_number']:''?>">
                         
                          <?php }else{?>
                            <input type="text" class="form-control" id="order_number" placeholder="Order No" name="order_number" value="<?= isset($value['order_number'])?$value['order_number']:''?>">
                         
                          <?php } ?>
                         <label for="floatingInputGrid">Order No*</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-floating">
                           <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="<?= isset($value['date'])?$value['date']:date('Y-m-d');?>">
                           <label for="floatingInputGrid">Purchase Order Date</label>
                        </div>
                        <!-- <div class="form-floating">
                           <select class="form-select" id="get_category_id" name="category_id" aria-label="Floating label select example">
                              <option value="">Select Category</option>
                              <?php if(!empty($data['category'])){
                                 foreach($data['category'] as $row){
                                 ?>
                              <option value="<?=$row['id']?>" <?php if(isset($value['category_id']) && $row['id'] == $value['category_id']){echo'selected';} ?>><?=$row['category_name']?></option>
                              <?php } } ?>   
                           </select>
                           <label for="floatingSelectGrid">Category*</label>
                        </div> -->
                     </div>
                  </div>
                  <br>
                  <div class="row g-3">
                    <div class="col-md-3">
                       <div class="form-floating">
                          <select class="form-select" id="terms" name="terms" aria-label="Floating label select example">
                             <option selected disabled>Select Terms</option>
                             <option value="15" <?= isset($value['terms'])&&($value['terms']=='15')?'selected':''?>>Net 15</option>
                             <option value="30" <?= isset($value['terms'])&&($value['terms']=='30')?'selected':''?>>Net 30</option>
                             <option value="45" <?= isset($value['terms'])&&($value['terms']=='45')?'selected':''?>>Net 45</option>
                             <option value="60" <?= isset($value['terms'])&&($value['terms']=='60')?'selected':''?>>Net 60</option>
                             <option value="0">Due end of the month</option>
                             <option value="1">Due end of next month</option>
                             <option value="2">Due on receipt</option>
                          </select>
                          <label for="floatingInputGrid">Terms</label>
                       </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                           <input type="date" class="form-control" id="due_date" name="due_date" placeholder="Due Date" value="<?= isset($value['due_date'])?$value['due_date']:''?>">
                           <label for="floatingInputGrid">Due Date</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                          <input type="hidden" name="base_currency_id" id="base_currency_id" value="<?= $data['base_currency_id'] ?>">
                           <select class="form-select" onchange="$('#currency_rate').val($(this).find(':selected').attr('data-rate'))" name="currency_id" data-type="purchase" id="currency_id" aria-label="Floating label select example">
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
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                          <div class="form-floating">
                                            <select class="form-select" name="location" id="location" aria-label="Floating label select example">
                                                  <option value="">Select Location</option>
                                                <?php 
                                                  if(!empty($data['location']))
                                                  {
                                                    foreach($data['location'] as $row)
                                                    { ?>
                                                       <option value="<?= $row['id']?>" <?= isset($value['location_id']) && ($value['location_id'] == $row['id'])?'selected':''?>><?=$row['location_description']?></option>
                                                      <?php
                                                    }
                                                  } 
                                                ?>
                                            </select>
                                            <label for="floatingSelectGrid">Location</label>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="repeater-default">
                                       <div data-repeater-list="car">
                                          <div class="">
                                             <table id="myTable" class="table  table-bordered VanderTable">
                                                <thead class="threadClass">
                                                   <tr>
                                                      <th>ID</th>
                                                      <th>Item Name</th>
                                                      <th>Qty</th>
                                                      <th>Rate</th>
                                                      <th>Discount</th>
                                                      <th>Tax</th>
                                                      <th>Tax(Excl)</th>
                                                      <!-- <th>Lot No.</th>
                                                      <th>DOM</th>
                                                      <th>Expiry Dt.</th> -->
                                                      <th>Amount</th>
                                                      <th>Action</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                  <?php
                                                   $items = json_decode($data['items']);
                                                   if(isset($data['purchaseitems']) && !empty($data['purchaseitems'])) { 
                                                      $total = 0;
                                                      foreach($data['purchaseitems'] as $k => $row) {
                                                          $total .= $row['rate'] * $row['qty'];
                                                          $i = $k+1;
                                                          $opt = json_decode($row['item_options']);
                                                      ?>
                                                      <tr class="new-row">
                                                      <td class="text-center vert-align-md"><?= $i; ?></td>
                                                      <td>
                                                         <input type="hidden" name="items[<?= $i; ?>][id]" value="<?= $row['id']; ?>">
                                                         <select class="form-control form-select item-add item_id-pr" name="items[<?= $i; ?>][item_id]" data-row="<?=$i;?>">
                                                            <option value="">Click to select item</option>
                                                           <?php foreach($items as $v) { ?>
                                                               <option value="<?= $v->id; ?>" <?php if($v->id == $row['item_id']) { echo 'selected';} ?>><?= $v->item_name; ?></option>
                                                            <?php } ?>
                                                         </select>
                                                         <?php if(isset($opt->track_serial_no) && $opt->track_serial_no == 1) {?>
                                                          <textarea class="form-control serial_no" name="items[<?=$i?>][serial_no]" placeholder="Add Serial Number"><?=$row['serial_no'];?></textarea>
                                                         <?php } ?>
                                                      </td>
                                                      <td>
                                                         <input class="form-control quantity" type="number" name="items[<?= $i; ?>][quantity]" value="<?= $row['qty']; ?>">
                                                         <div style="margin: 5px;" class="uom-v"><?= isset($row['uom_value'])?$row['uom_value']:'-'?></div>
                                                         <input class="uom form-control" type="hidden" name="items[<?= $i; ?>][uom]" value="<?= $row['uom_value']; ?>"><input class="uomid form-control " type="hidden" name="items[<?= $i; ?>][uomid]" value="<?= $row['uom_id']; ?>">
                                                      </td>
                                                      <td>
                                                         <input class="form-control rate" type="text" name="items[<?= $i; ?>][rate]" value="<?= $row['rate']; ?>">
                                                      </td>
                                                      <td>
                                                         <input class="discount form-control" type="number" name="items[<?= $i; ?>][discount]" value="<?= $row['discount']; ?>">&nbsp;<select class="form-control discount form-select" name="items[<?= $i; ?>][discount_type]"><option value="%" <?php $row['discount_type'] == '%' ? 'selected' : '' ?>>%</option><option value="ZMW" <?php $row['discount_type'] == 'ZMW' ? 'selected' : '' ?>>ZMW</option></select><input class="discount_amount form-control" type="hidden" name="items[<?= $i; ?>][discount_amount]" value="<?= $row['discount_amount']; ?>">
                                                      </td>
                                                      <td class="flex is_include_tax">
                                                         <input type="text" name="items[<?= $i; ?>][tax_amount]" class="form-control tax_amount" value="<?= $row['tax_amount']; ?>" readonly>
                                                         <input class="tax form-control tax" type="hidden" name="items[<?= $i; ?>][tax]" value="<?= $row['tax_value']; ?>" readonly>&nbsp;<input class="form-control form-border tax_type" type="hidden" name="items[<?= $i; ?>][tax_type]" value="<?= $row['tax_name']; ?>" readonly>
                                                      </td>
                                                      <td class="form-group text-center vert-align-md">
                                                         <input type="hidden" class="tax_exc_amt" name="items[<?= $i; ?>][tax_exc_amt]" value="<?= $row['tax_excl'] == 1 ? $row['tax_amount'] : '0'?>">
                                                         <input class="tax_excl" id="tax_excl<?= $i; ?>" type="checkbox" name="items[<?= $i; ?>][tax_excl]" value="<?= $row['tax_excl']; ?>" <?= $row['tax_excl'] == 1 ? 'checked':''; ?>>
                                                         <label for="tax_excl<?= $i;?>"></label>
                                                      </td>
                                                      <td>
                                                        <input type="hidden" class="form-control lot_no" name="items[<?= $i; ?>][lot_no]" value="<?=$row['lot_no'];?>">
                                                        <input type="hidden" name="items[<?= $i; ?>][dom]" class="form-control dom" value="<?=$row['dom'];?>">
                                                        <input type="hidden" name="items[<?= $i; ?>][expiry_date]" class="form-control expiry_date" value="<?=$row['expiry_date'];?>">
                                                         <input class="tabledit-input form-control amount" type="text" name="items[<?= $i; ?>][amount]" value="<?= $row['item_amount'] ?>">
                                                      </td>
                                                      <td>
                                                        <a href="javascript:void(0);" class="transh-icon-color add-more" data-no="<?= $i; ?>" title="Add more"><i class="fa fa-plus"></i></a><!-- <a href="#" data-table="purchaseorders" data-id="<?= $row['id']?>" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a> -->
                                                      </td>
                                                    </tr>
                                                   <?php }
                                                    } else { ?> 
                                                    <tr class="new-row">
                                                      <td class="text-center vert-align-md">1</td>
                                                      <td>
                                                         <select class="form-control form-select item-add item_id-pr" name="items[1][item_id]" data-row="1">
                                                            
                                                         </select>
                                                      </td>
                                                      <td>
                                                         <input class="form-control quantity" type="number" name="items[1][quantity]" value="1">
                                                         <div style="margin: 5px;" class="uom-v">kg</div>
                                                         <input class="uom form-control " type="hidden" name="items[1][uom]">
                                                         <input class="uomid form-control " type="hidden" name="items[1][uomid]">
                                                      </td>
                                                      <td>
                                                         <input class="form-control rate" type="text" name="items[1][rate]">
                                                      </td>
                                                      <td>
                                                         <input class="discount form-control " type="number" name="items[1][discount]"><select class="form-control discount_type form-select" name="items[1][discount_type]"><option value="%">%</option><option value="ZMW">ZMW</option></select>
                                                         <input class="discount_amount form-control " type="hidden" name="items[1][discount_amount]" value="0">
                                                      </td>
                                                      <td class="flex">
                                                         <input type="text" name="items[1][tax_amount]" class="form-control tax_amount" value="" readonly>
                                                         <input class="tax form-control tax" type="hidden" name="items[1][tax]" value="" readonly><input class="form-control form-border tax_type" type="hidden" name="items[1][tax_type]" value="" readonly>
                                                      </td>
                                                      <td class="form-group text-center vert-align-md">
                                                         <input type="hidden" class="tax_exc_amt" name="items[1][tax_exc_amt]" value="">
                                                         <input class="tax_excl" id="tax_excl1" type="checkbox" name="items[1][tax_excl]">
                                                         <label for="tax_excl1"></label>
                                                      </td>
                                                      <!-- <td class="flex is_include_tax">
                                                         <select class="form-control tax_type form-select" name="items[1][tax_type]">
                                                         <option value="">Select</option>
                                                          <?php
                                                          $taxlist = json_decode($data['taxlist']);
                                                           foreach($taxlist as $v) { ?>
                                                         <option data-rate="<?= $v->tax_rate; ?>" value="<?= $v->id; ?>"><?= $v->tax_type; ?></option>
                                                         <?php } ?>
                                                      </select>&nbsp;
                                                      <input type="hidden" name="items[1][tax_amount]" class="tax_amount">
                                                         <input class="tax form-control form-border tax" type="number" name="items[1][tax]">
                                                      </td> -->
                                                      <td>
                                                        <input type="hidden" class="form-control lot_no" name="items[1][lot_no]">
                                                        <input type="hidden" name="items[1][dom]" class="form-control dom">
                                                        <input type="hidden" name="items[1][expiry_date]" class="form-control expiry_date">
                                                        <input class="tabledit-input form-control amount" type="text" name="items[1][amount]">
                                                      </td>
                                                      <td class="text-center vert-align-md">
                                                         <a href="javascript:void(0);" class="transh-icon-color add-more" data-no="1" title="Add more"><i class="fa fa-plus"></i></a>
                                                      </td>
                                                      </tr>
                                                    <?php } ?>
                                                </tbody>
                                             </table> 
                                          </div>
                                       </div>
                                     
                                       <div class="form-group overflow-hidden">
                                          <div class="col-12">
                                             <button  onclick="addPurchaseOrderField();" type="button" class="btn btn-info" ><i class="fa fa-plus"></i> Add Item</button>
                                          </div><!-- data-repeater-create -->
                                       </div>
                                    
                                    </div>
                                    <div class="row">
                                       <div class="col-md-5">
                                          <textarea placeholder="Customer Notes" name="notes" rows="4" cols="50" class="form-control"><?= isset($value['customer_note']) ? $value['customer_note'] : '' ?></textarea>
                                       </div>
                                       <div class="col-md-3"></div>
                                       <div class="col-md-4 add-form-footer p-2">
                                          <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4 conv-currency" style="visibility: hidden;"><h4 class="conv-curr-symbol f-w-600" style="font-weight: 700;"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></h4></div>
                                            <div class="col-md-4"><h4 class="f-w-600" style="font-weight: 700;"><?= $data['currency_symbol'] ?></h4></div>
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
                                                <input type="hidden" value="<?= isset($value['total_discount']) ? $value['total_discount'] : '0.00' ?>" name="total-discount" id="total-discount">
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-4">
                                                <span>Subtotal</span>
                                             </div>
                                             <div class="col-md-4 conv-currency" style="visibility: hidden;">
                                                <span class="subCurrTotal"><?= isset($value['sub_curr_total']) ? $value['sub_curr_total'] : '0.00' ?></span>
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
                                             <div class="col-md-4">
                                                <span>Total</span>
                                             </div>
                                             <div class="col-md-4 conv-currency" style="visibility: hidden;">
                                              <div class="d-flex">
                                                <!-- <span class="pt-1 conv-curr-symbol"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></span>&nbsp; -->
                                                <span><input type="text" class="form-control form-border" name="conv_total_amount" id="conv-total-amount" value="<?= isset($value['currency_total']) ? $value['currency_total'] : '0.00' ?>" readonly></span>
                                              </div>
                                             </div>
                                             <div class="col-md-4 d-flex">
                                                <!-- <span class="pt-1 curr-symbol"><?= $data['currency_symbol'] ?></span>&nbsp;<span> --><input type="text" class="form-control form-border" name="total_amount" id="total-amount" value="<?= isset($value['total_amount']) ? $value['total_amount'] : '0.00' ?>" readonly></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-footer text-right">
                                      <input type="hidden" name="is_received" value="" id="is_received">
                                      <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                                      <?php if(!isset($value['id'])) { ?>
                                      <button type="submit" data-value="1" onclick="$('#is_received').val('1')" class="btn btn-info save_n_receive"><i class="fa fa-file-o"></i> Save & Receive</button>
                                      <?php } ?>
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
<div class="modal fade text-left" id="add-lot-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
     <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title" id="myModalLabel18">Please add Lot No, Manufacture Date and Expire Date</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button>
        </div>
        <div class="modal-body">
              <table id="purchase-details-tbl" class="table table-bordered module-items-tbl">
                 <thead class="threadClass">
                    <tr>
                       <th>Lot No.</th>
                       <th>Date of manufacture</th>
                       <th>Expiry Date</th>
                    </tr>
                 </thead>
                 <tbody>
                    <tr>
                      <td class="text-center">
                          <input type="hidden" class="a-lot-row" value="">
                          <input type="text" class="form-control a-lot-no" value="">
                      </td>
                      <td class="text-center">
                          <input type="date" class="form-control a-lot-dom" value="">
                      </td>
                      <td class="text-center">
                          <input type="date" class="form-control a-lot-expiry" value="">
                      </td>
                    </tr>
                 </tbody>
              </table>
        </div>
        <div class="modal-footer">
          <button id="btnLotSubmit" type="button" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
        </div>
     </div>
  </div>
</div> 
