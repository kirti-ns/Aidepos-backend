<div class="app-content content">
         <div class="content-wrapper">
             <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <?php $value = isset($data['goods_purchase'])?$data['goods_purchase']:"";?>
               <form method="post" id="purchase_order_form" action="<?= base_url('post_data_purchase') ?>" name="purchase_order_form">
                  <div class="card">
                     <div class="card-body">
                        <input type="hidden" name="action" id="action" value="post_data_purchase">
                        <input type="hidden" name="table_name" id="table_name" value="purchaseorders">
                        <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row g-3">
                           <div class="col-md-3">
                              <div class="form-floating">
                                   <input type="text" class="form-control" id="store_name" name="date" placeholder="Store Name" value="<?= isset($value['store_name'])?$value['store_name']:''?>">
                                 <label for="floatingSelectGrid">Store Name*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="" name="date" placeholder="Supplier Name" value="<?= isset($value['supplier_name'])?$value['supplier_name']:''?>">
                               <label for="floatingSelectGrid">Supplier Name*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                  <input type="text" class="form-control" id="order_number" name="date" placeholder="Order No" value="<?= isset($value['order_number'])?$value['order_number']:''?>"> 
                               <label for="floatingSelectGrid">Order No</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="<?= isset($value['date'])?date('Y-m-d',strtotime($value['date'])):''?>">
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
                                 <input type="text" name="currency_id" id="v_currency_id" value="<?= isset($data['currency'])?$data['currency']['currency_code']:'N/A'; ?>" class="form-control">
                                 <label for="floatingSelectGrid">Exchange Currency</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
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
                                          <div class="repeater-default">
                                             <div data-repeater-list="car">
                                                <div class="">
                                                   <table  class="table  table-bordered VanderTable">
                                                      <thead class="threadClass">
                                                         <tr>
                                                            <th>Item ID</th>
                                                            <th>Item Name</th>
                                                            <th>UOM</th>
                                                            <th>Quantity</th>
                                                            <th>Rate</th>
                                                            <th>Discount</th>
                                                            <th>Tax Amount</th>
                                                            <th>Tax (Excl)</th>
                                                            <th>Amount</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                        <?php 

                                                         if(isset($data['purchase_items']) && !empty($data['purchase_items'])) { 
                                                            $total = 0;
                                                            foreach($data['purchase_items'] as $k => $row) {
                                                                $total .= $row['rate'] * $row['qty'];
                                                            ?>
                                                            <tr class="new-row">
                                                               <td>
                                                                  <?= $k+1; ?>
                                                               </td>
                                                            <td>
                                                               <?= $row['item_name']; ?>
                                                            </td>
                                                            <td>
                                                               <?= $row['uom_value']; ?>
                                                            </td>
                                                            <td>
                                                               <?= $row['qty']; ?>
                                                            </td>
                                                            <td>
                                                               <?= $row['rate']; ?>
                                                            </td>
                                                            <td>
                                                              <?= $row['discount'] > 0 ? $row['discount'].' '.$row['discount_type']:'-'; ?>
                                                            </td>
                                                            <td>
                                                                <?= isset($row['tax_amount'])?$row['tax_amount']:'0.00'; ?>
                                                            </td>
                                                            <td>
                                                               <?= $row['tax_excl'] == 1 ? 'Exclusive':'Inclusive'; ?>
                                                            </td>
                                                            <td>
                                                               <?= $row['item_amount'] ?>
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
                                                <textarea placeholder="Customer Notes" name="notes" rows="4" cols="50" class="form-control"><?= $value['customer_note']; ?></textarea>
                                             </div>
                                             <div class="col-md-3"></div>
                                             <div class="col-md-4 add-form-footer p-2">
                                                <div class="row">
                                                  <div class="col-md-4"></div>
                                                  <div class="col-md-4 conv-currency" style="visibility: hidden;"><h4 class="conv-curr-symbol f-w-600"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></h4></div>
                                                  <div class="col-md-4"><h4 class="f-w-600"><?= $data['currency_code'] ?></h4></div>
                                                </div>
                                                <div class="row"style="border-top: 1px solid #bcbcbc;border-bottom: 1px solid #bcbcbc;">
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
                                                      </span><span class="subCurrTotal"><?= isset($value['sub_curr_total']) ? $value['sub_curr_total'] : '0.00' ?></span>
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
                                                      <?= isset($value['adjustment_value']) ? $value['adjustment_value'] : '0.00' ?>
                                                      <i class="fa fa-info-circle"></i>
                                                   </div>
                                                </div>
                                                <hr>
                                                <div class="row form-footer-right">
                                                   <div class="col-md-4">
                                                      <span>Total (ZWM)</span>
                                                   </div>
                                                   <div class="col-md-4 conv-currency" style="visibility: hidden;">
                                                    <div class="d-flex">
                                                      <span class="pt-1 conv-curr-symbol"><?= isset($value['currency_code']) ? $value['currency_code'] : '' ?></span>&nbsp;
                                                      <span><input type="text" class="form-control form-border" name="conv_total_amount" id="conv-total-amount" value="<?= isset($value['currency_total']) ? $value['currency_total'] : '0.00' ?>" readonly></span>
                                                    </div>
                                                   </div>
                                                   <div class="col-md-4 d-flex">
                                                      <span class="pt-1 curr-symbol"><?= $data['currency_symbol'] ?></span>&nbsp;<span><input type="text" class="form-control form-border" name="total_amount" id="total-amount" value="<?= isset($value['total_amount']) ? $value['total_amount'] : '0.00' ?>" readonly></span>
                                                   </div>
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
                  </div>
               </form>
            </div>
         </div>
      </div>
      </div>     
