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
                           <fieldset class="form-view">
                            <span>Store Name</span>
                            <input type="hidden" name="store_id" class="store_id">
                            <p class="form-control-static" id="store_id">-</p>
                          </fieldset>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                          <fieldset class="form-view">
                            <span>Supplier Name</span>
                            <p class="form-control-static" id="supplier_id">-</p>
                          </fieldset>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                           <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="<?=date('Y-m-d');?>">
                           <label for="floatingInputGrid">Goods Received Date</label>
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row g-3">
                     <div class="col-md-3">
                        <div class="form-floating">
                          <fieldset class="form-view">
                            <span>Terms</span>
                            <p class="form-control-static" id="terms">-</p>
                          </fieldset>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                          <fieldset class="form-view">
                            <span>Due Date</span>
                            <p class="form-control-static" id="due_date">-</p>
                          </fieldset>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating">
                          <fieldset class="form-view">
                            <span>Exchange Currency</span>
                            <p class="form-control-static" id="v_currency_id">-</p>
                          </fieldset>
                          <input type="hidden" name="base_currency_id" id="base_currency_id" value="">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-floating conv-currency" style="visibility: hidden;">
                          <fieldset class="form-view">
                            <span>Currency Rate</span>
                            <p class="form-control-static" id="currency_rate">-</p>
                          </fieldset>
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
                                          <fieldset class="form-view">
                                              <span>Location</span>
                                              <input type="hidden" name="location" class="location">
                                              <p class="form-control-static" id="location">-</p>
                                          </fieldset>
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