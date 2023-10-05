<div class="app-content content">
   <div class="content-wrapper">
     <?= view('includes/breadcrumb.php');?> 
      <div class="content-body">
         <?php $value = isset($data['goods_received'])?$data['goods_received']:"";?>
         <form method="post" id="goods_received_form" action="<?= base_url('post_data_purchase') ?>" name="goods_received_form">
            <div class="card">
               <div class="card-body">
                  <input type="hidden" name="action" id="action" value="post_data_purchase">
                  <input type="hidden" name="table_name" id="table_name" value="goods_received">
                  <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                  <div class="row g-3">
                     <div class="col-md-3">
                        <div class="form-floating">
                           <select class="form-select order_number" data-type="received" id="order_number" name="order_number" aria-label="Floating label select example">
                              <option value="">Select Order Number</option>
                              <?php 
                                 if(!empty($data['order_number'])) {
                                    foreach($data['order_number'] as $row) { ?>
                                    <option <?= isset($value['id']) && ($value['p_o_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['order_number']?></option>
                                 <?php } } ?>                              
                           </select>
                           <label for="floatingInputGrid">Order No*</label>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                           <select class="form-select" id="store_id" name="store_id" aria-label="Floating label select example">
                                 <option value="">Select Store</option>
                                 <?php if(!empty($data['stores'])){
                                    foreach($data['stores'] as $row){
                                 ?>
                                 <!--<option value="<?=$row['id']?>" <?php if(isset($value['store_id']) && $row['id'] == $value['store_id']){echo'selected';}?>><?=$row['store_name']?></option>-->
                                  <option <?= isset($value['store_id']) && ($value['store_id'] == $row['id']) || (isset($data['store_id']) && $data['store_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                                 <?php }} ?>
                              </select>
                              <label for="floatingSelectGrid">Store Name*</label>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="supplier_id" name="supplier_id" aria-label="Floating label select example">
                                 <option value="" >Select Supplier</option>
                                <?php 
                                    if(!empty($data['supplier']))
                                    {
                                       foreach($data['supplier'] as $row)
                                          { ?>
                                             <option <?= isset($value['supplier_id']) && ($value['supplier_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['registered_name']?></option>
                                    <?php
                                          }
                                     } 
                                    ?>                              
                                 </select>
                           <label for="floatingSelectGrid">Supplier Name*</label>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                           <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="<?= isset($value['date'])?$value['date']:''?>">
                           <label for="floatingInputGrid">Purchase Order Date</label>
                        </div>
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
                                   <option value="90" <?= isset($value['terms'])&&($value['terms']=='90')?'selected':''?>>Net 90</option>
                                   <option value="120" <?= isset($value['terms'])&&($value['terms']=='120')?'selected':''?>>Net 120</option>
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
                           <select class="form-select" onchange="$('#currency_rate').val($(this).find(':selected').attr('data-rate'))" name="currency_id" data-type="purchase" id="v_currency_id" aria-label="Floating label select example">
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
                     <div class="col-md-3">
                        <div class="form-floating conv-currency" style="visibility: hidden;">
                           <input type="text" class="form-control" name="currency_rate" id="currency_rate" value="<?= isset($value['currency_rate'])?$value['currency_rate']:''?>" data-type="purchase" placeholder="Currency Rate">
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
                                             <table id="goodsReceivedItemTbl" class="table table-bordered module-items-tbl">
                                                <thead class="threadClass">
                                                   <tr>
                                                      <th>ID</th>
                                                      <th>Item Name</th>
                                                      <th>Ordered Qty.</th>
                                                      <th>Receive Qty.</th>
                                                      <th>Received Qty.</th>
                                                      <th>Reject Qty.</th>
                                                      <th>Rejected Qty.</th>
                                                      <th>Rate</th>
                                                      <th>Discount</th>
                                                      <th>Tax Amount</th>
                                                      <th>Amount</th>
                                                      <th>Action</th>
                                                   </tr>
                                                </thead>
                                                <tbody id="goods-received-section">

                                                   <?php 

                                                      $items = json_decode($data['items']);
                                                      if(isset($data['goods_received_items']) && !empty($data['goods_received_items'])) { 
                                                         $total = 0;
                                                         foreach($data['goods_received_items'] as $k => $row) {
                                                             $total .= $row['rate'] * $row['qty'];
                                                         ?>
                                                         <tr class="new-row">
                                                            <td class="text-center"><?=$k+1?></td>
                                                            <td>
                                                              <input class=" form-control" type="hidden" name="items[<?=$k?>][order_item_id]" value="<?=$row['id']?>">
                                                              <input type="hidden" name="items[<?= $k; ?>][id]" value="<?= $row['item_id']; ?>">
                                                              <select class="form-control form-select item-add" name="items[<?= $k; ?>][item_id]">
                                                                 <option value="">Click to select item</option>
                                                                <?php foreach($items as $v) { ?>
                                                                    <option value="<?= $v->id; ?>" <?php if($v->id == $row['item_id']) { echo 'selected';} ?>><?= $v->item_name; ?></option>
                                                                 <?php } ?>
                                                              </select>
                                                           </td>
                                                          <td>
                                                            <input class="form-control quantity" type="number" name="items[<?= $k; ?>][qty]" value="<?= $row['qty']; ?>">
                                                         </td>
                                                         <td>
                                                            <?php $recQty = isset($row['received_qty']) ? abs($row['received_qty'] - $row['qty']):$row['qty']?>
                                                            <input class="form-control quantity" type="number" name="items[<?= $k; ?>][received_qty]"  value="<?=$recQty?>">
                                                         </td>
                                                         <td>
                                                            <input type="text" class="form-control" name="items[<?=$k?>][old_received_qty]" value="<?=$row['received_qty']?>" readonly>
                                                         </td>
                                                         <td>
                                                            <input class="form-control" type="text" name="items[<?=$k?>][rejected_qty]" value="">
                                                         </td>
                                                         <td>
                                                            <input class="form-control" type="text" name="items[<?=$k?>][old_rejected_qty]" value="<?=$row['rejected_qty']?>" readonly>
                                                         </td>
                                                         <td>
                                                            <input type="text" class="form-control rate" name="items[<?=$k?>][rate]" value="<?= $row['rate']?>" readonly>
                                                         </td>
                                                         <td class="flex">
                                                           <input class="discount form-control" type="number" name="items[<?= $k; ?>][discount]" value="<?= $row['discount']; ?>">&nbsp;<select class="form-control discount form-select" name="items[<?= $k; ?>][discount_type]"><option value="%" <?php $row['discount_type'] == '%' ? 'selected' : '' ?>>%</option><option value="ZMW" <?php $row['discount_type'] == 'ZMW' ? 'selected' : '' ?>>ZMW</option></select><input class="discount_amount form-control" type="hidden" name="items[<?= $k; ?>][discount_amount]" value="<?= $row['discount_amount']; ?>">
                                                         </td>
                                                         <td>
                                                            <input type="text" name="items[<?= $k; ?>][tax_amount]" class="form-control tax_amount" value="<?= $row['tax_amount']; ?>" readonly>
                                                         </td>
                                                         <td>
                                                            <input class="tabledit-input form-control amount" readonly type="text" name="items[<?= $k; ?>][amount]" value="<?=$row['item_amount'];?>">
                                                         </td>
                                                         <td>
                                                          
                                                         </td>
                                                         </tr>
                                                      <?php }
                                                       } ?>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-5">
                                          <textarea name="received_note" placeholder="Goods Received Notes" rows="4" cols="50" class="form-control"><?= isset($value['received_note']) ? $value['received_note'] : '' ?></textarea>
                                       </div>
                                       <div class="col-md-3"></div>
                                       <div class="col-md-4 add-form-footer p-3">
                                          <div class="row"style="border-top: 1px solid #bcbcbc;border-bottom: 1px solid #bcbcbc;">
                                             <div class="col-md-4">
                                                <span>Discount</span>
                                             </div>
                                             <div class="col-md-4 conv-currency" style="visibility: hidden;"></div>
                                             <div class="col-md-4">
                                                <span class="discountAmount"><?= isset($value['total_discount']) ? $value['total_discount'] : '0.00' ?></span>
                                                <input type="hidden" value="<?= isset($value['total_discount']) ? $value['total_discount'] : '0.00' ?>" name="total-discount" id="total-discount">
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-4">
                                                <span>Subtotal</span>
                                             </div>
                                             <div class="col-md-4">
                                             </div>
                                             <div class="col-md-4">
                                                <span class="subTotal"><?= isset($value['sub_total']) ? $value['sub_total'] : '0.00' ?></span>
                                                <input type="hidden" value="<?= isset($value['sub_total']) ? $value['sub_total'] : '0.00' ?>" name="sub_total" id="sub-total">
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-4">
                                                <span>Tax</span>
                                             </div>
                                             <div class="col-md-4">
                                             </div>
                                             <div class="col-md-4">
                                                <span class="taxAmount"><?= isset($value['total_tax']) ? $value['total_tax'] : '0' ?></span>
                                                <input type="hidden" value="<?= isset($value['total_tax']) ? $value['total_tax'] : '0' ?>" name="total_tax" id="total-tax">
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-4">
                                                <span>Adjustment</span></div>
                                             <div class="col-md-4">
                                               
                                             </div>
                                             <div class="col-md-4 form-footer-center">
                                                 <input type="text" class="form-control amount-footer adjustment_value" name="adjustment_value"  placeholder="Amount" value="0">
                                                <i class="fa fa-info-circle"></i>
                                             </div>
                                          </div>
                                          <hr>
                                          <div class="row form-footer-right">
                                             <div class="col-md-4">
                                                <span>Total (ZWM)</span>
                                             </div>
                                             <div class="col-md-4">
                                             </div>
                                             <div class="col-md-4">
                                                <span><input type="text" class="form-control form-border" name="total_amount" id="total-amount" value="<?= isset($value['total_amount']) ? $value['total_amount'] : '0.00' ?>" readonly></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-footer text-right">
                                  <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                                   <button  type="submit" data-value="1" id="btnSubmit" class="btn btn-info save_n_complete"><i class="fa fa-file-o"></i> Save & Complete</button>
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