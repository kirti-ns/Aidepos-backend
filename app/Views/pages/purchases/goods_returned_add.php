<style type="text/css">
  .form-control:disabled, .form-control[readonly] {
    background-color: #f6f6f6;
    opacity: 1;
  }
</style>
<div class="app-content content">
   <div class="content-wrapper">
      <?= view('includes/breadcrumb.php');?> 
      <div class="content-body">
         <?php $value = isset($data['goods_returned'])?$data['goods_returned']:"";?>
          <form method="post" id="goods_returned_form" action="<?= base_url('post_data_purchase') ?>" name="goods_returned_form">
         <div class="card">
            <div class="card-body">
            <input type="hidden" name="action" id="action" value="post_data_purchase">
            <input type="hidden" name="table_name" id="table_name" value="goods_returned">
            <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
               <div class="row g-3">
                  <div class="col-md-3">
                     <div class="form-floating">
                       <select class="form-select" id="order_number" name="order_number" aria-label="Floating label select example">
                           <option value="">Select Order Number</option>
                           <?php 
                              if(!empty($data['purchase']))
                              {
                                 foreach($data['purchase'] as $row)
                                    { ?>
                                       <option <?= isset($value['order_number']) && ($value['order_number'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['order_number']?></option>
                              <?php
                                    }
                               } 
                              ?>                              
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
                        <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="<?= date('Y-m-d')?>">
                        <label for="floatingInputGrid">Goods Return Date</label>
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
                                       <table id="Goods-Return" class="table  table-bordered table-striped ">
                                          <thead class="threadClass">
                                             <tr>
                                                <th></th>
                                                <th>Item ID</th>
                                                <th>Item Name</th>
                                                <!-- <th>UOM</th> -->
                                                <th>Qty</th>
                                                <th>Return Qty</th>
                                                <th>Returned Qty</th>
                                                <th>Rate</th>
                                                <th>Discount</th>
                                                <th class="is_include_tax">Tax</th>
                                                <th>Amount</th>
                                               <!--  <th>Action</th> -->
                                             </tr>
                                          </thead>
                                          <tbody id="goods-returned-section">
                                             
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                                 <!-- <div class="form-group overflow-hidden">
                                    <div class="col-12">
                                       <button  onclick="addGoodsReturned();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
                                    </div>
                                 </div> -->
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
                                          <span class="subTotal">0.00</span>
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
                                          <span class="taxAmount">0.00</span>
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
                           </div>
                          
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
      </div>
   </div>
</div>