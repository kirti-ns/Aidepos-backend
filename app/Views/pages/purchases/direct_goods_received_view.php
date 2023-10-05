<div class="app-content content">
  <div class="content-wrapper">
    <?= view('includes/breadcrumb.php');?> 
    <div class="content-body">
        <?php $value = isset($data['goods_received'])?$data['goods_received']:"";?>
          <div class="card">
            <div class="card-body">
              <div class="row g-3">
                  <div class="col-md-3">
                     <div class="form-floating">
                           <input type="text" class="form-control" id="store_name" name="date" placeholder="Store Name" value="<?= isset($value['store_name'])?$value['store_name']:''?>">
                           <label for="floatingSelectGrid">Store Name</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control" id="" name="date" placeholder="Supplier Name" value="<?= isset($value['location_description'])?$value['location_description']:''?>">
                         <label for="floatingSelectGrid">Location</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control" id="" name="date" placeholder="Supplier Name" value="<?= isset($value['supplier_name'])?$value['supplier_name']:''?>">
                         <label for="floatingSelectGrid">Supplier Name</label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-floating">
                        <input type="text" class="form-control" id="" name="date" placeholder="Purchase Order Date" value="<?= isset($value['date'])?date('Y-m-d',strtotime($value['date'])):''?>">
                         <label for="floatingSelectGrid">Received Date</label>
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
                               <div class="repeater-default">
                                  <div data-repeater-list="car">
                                     <div class="">
                                        <table id="" class="table  table-bordered">
                                           <thead class="threadClass">
                                              <tr>
                                                <th>ID</th>
                                                <th>Item Name</th>
                                                <th>Qty</th>
                                                <th>Rate</th>
                                                <th>Discount</th>
                                                <th>Tax</th>
                                                <th>Tax(Excl)</th>
                                                <th>Lot No.</th>
                                                <th>DOM</th>
                                                <th>Expiry Dt.</th>
                                                <th>Amount</th>
                                              </tr>
                                           </thead>
                                           <tbody id="goods-received-section">
                                              <?php
                                                 if(isset($data['goods_received_items']) && !empty($data['goods_received_items'])) { 
                                                    $total = 0;
                                                    foreach($data['goods_received_items'] as $k => $row) {
                                                        $total .= $row['rate'] * $row['qty'];
                                                        $i = $k+1;
                                                        $opt = json_decode($row['item_options']);
                                                    ?>
                                                    <tr class="new-row">
                                                      <td class="text-center vert-align-md"><?= $i; ?></td>
                                                      <td>
                                                         <?= $row['item_name']; ?>
                                                         <?php if(isset($opt->track_serial_no) && $opt->track_serial_no == 1) {?>
                                                          <br/>
                                                          <span>Serial No: </span><?=$row['serial_no'];?>
                                                         <?php } ?>
                                                      </td>
                                                      <td>
                                                         <?= $row['qty']; ?>
                                                         <div class="uom-v"><?= isset($row['uom_value'])?$row['uom_value']:'-'?></div>
                                                      </td>
                                                      <td>
                                                        <?= $row['rate']; ?>
                                                      </td>
                                                      <td>
                                                        <?= $row['discount'] != "" ? $row['discount'] != "".' '.$row['discount_type']: '-'; ?>
                                                      </td>
                                                      <td>
                                                         <?= $row['tax_amount']; ?>
                                                      </td>
                                                      <td class="form-group text-center">
                                                        <?= $row['tax_excl'] == 1 ? 'Yes':'No'; ?>
                                                      </td>
                                                      <td>
                                                        <?=$row['lot_no'];?>
                                                      </td>
                                                      <td>
                                                        <?=$row['dom'];?>
                                                      </td>
                                                      <td>
                                                        <?=$row['expiry_date'];?>
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
                                     <textarea name="received_note" placeholder="Notes" rows="4" cols="50" class="form-control" value="<?= isset($value['received_note']) ? $value['received_note'] : '' ?>"><?= isset($value['received_note']) ? $value['received_note'] : '' ?></textarea>
                                  </div>
                                  <div class="col-md-3"></div>
                                  <div class="col-md-4 add-form-footer p-2">
                                      <div class="row">
                                           <div class="col-md-4">
                                              <span>Subtotal</span>
                                           </div>
                                           <div class="col-md-4">
                                           </div>
                                           <div class="col-md-4">
                                              <span class="subTotal"><?= $value['sub_total'];?></span>
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
                                              <span class="taxAmount"><?= $value['total_tax'];?></span>
                                              <input type="hidden" value="<?= isset($value['total_tax']) ? $value['total_tax'] : '0' ?>" name="total_tax" id="total-tax">
                                           </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-md-4">
                                              <span>Adjustment</span></div>
                                           <div class="col-md-4">
                                             
                                           </div>
                                           <div class="col-md-4 form-footer-center">
                                               <?= $value['adjustment_value']?>
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
                                              <span><input type="text" class="form-control form-border" name="total_amount" id="total-amount" value="<?= $value['total_amount']; ?>" readonly></span>
                                           </div>
                                        </div>
                                  </div>
                               </div>
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