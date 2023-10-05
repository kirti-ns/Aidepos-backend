      <div class="app-content content">
         <div class="content-wrapper">
            <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
                <?php $value = isset($data['transfer'])?$data['transfer']:"";  ?>
                <form method="post" id="transfer_form" name="transfer_form">
                       
                <div class="card">
                  <div class="card-body">
                    <input type="hidden" name="action" id="action" value="post_data_inventory">
                    <input type="hidden" name="table_name" id="table_name" value="transfer">
                    <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:""?>">
                    <div class="row g-3">
                        <div class="col-md-3">
                           <div class="form-floating">
                            <input type="hidden" id="supply_store_id" name="supply_store_id" value="<?=$value['supply_store_id']?>">
                            <input type="text" class="form-control" value="<?=$value['supply_store']?>" readonly>
                            <label for="floatingSelectGrid">Supply Store*</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                            <input type="hidden" id="location_id" name="location_id" value="<?=$value['location_id']?>">
                            <input type="text" class="form-control" value="<?=$value['supply_location']?>" readonly>
                              <label for="floatingSelectGrid">Location*</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                            <input type="hidden" id="receiver_store_id" name="receiver_store_id" value="<?=$value['receiver_store_id']?>">
                            <input type="text" class="form-control" value="<?=$value['receive_store']?>" readonly>
                              <label for="floatingSelectGrid">Receiving Store*</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                            <input type="hidden" id="rec_location_id" name="rec_location_id" value="<?=$value['receive_location_id']?>">
                            <input type="text" class="form-control" value="<?=$value['rec_location']?>" readonly>
                              <label for="floatingSelectGrid">Receiving Location*</label>
                           </div>
                        </div>
                     </div>
                     <div class="row pt-1">
                        <div class="col-md-3">
                          <div class="form-floating">
                            <input type="date" class="form-control" name="date" value="<?=$value['date'];?>" readonly>
                            <label>Transfer Date</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                              <?php if($data['act'] == "edit") { 
                                if(isset($value['receiver_store_id'])  && $data['sess_store'] == $value['receiver_store_id']) { ?>
                                <input type="hidden" name="status" id="status" value="1">
                              <!-- <select  class="form-select transfer-status" name="status" id="status" aria-label="Floating label select example" value="">
                                 <option value="">Select</option>
                                 <option  <?= isset($value['status']) && ($value['status'] == '0')?'selected':''?> value="0">Pending</option>
                                 <option <?= isset($value['status']) && ($value['status'] == '1')?'selected':''?> value="1" selected>Received</option>
                                 <option <?= isset($value['status']) && ($value['status'] == '2')?'selected':''?> value="2">Cancelled</option>
                              </select> -->
                            <?php } else { ?>
                              <input type="hidden" name="status" id="status" value="<?=$value['status'];?>">
                              <select class="form-select transfer-status" name="status" id="status" aria-label="Floating label select example"  disabled="disabled">
                                 <option value="">Select</option>
                                 <option  <?= isset($value['status']) && ($value['status'] == '0')?'selected':''?> value="0">Pending</option>
                                 <option <?= isset($value['status']) && ($value['status'] == '1')?'selected':''?> value="1">Received</option>
                                 <!-- <option <?= isset($value['status']) && ($value['status'] == '2')?'selected':''?> value="2">Cancelled</option> -->
                              </select>
                              <label for="floatingInputGrid">Status </label>
                            <?php } } ?>
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
                                                <table id="Add-Transfer" class="table table-bordered module-items-tbl">
                                                   <thead class="threadClass">
                                                      <tr>
                                                         <th>S/N</th>
                                                         <th>Item Name</th>
                                                         <th>SKU</th>
                                                         <th>DOM - Expiry Date(Lot No.)</th>
                                                         <th>Cost Price</th>
                                                         <th>Selling Price</th>
                                                         <th>Inventory Qty.</th>
                                                         <th>Qty</th>
                                                          <?php if(isset($value['receiver_store_id'])  && $data['sess_store'] == $value['receiver_store_id']) { ?>
                                                         <th>Received Qty</th>
                                                          <?php } ?>
                                                         <th class="approve-td d-none">Received Qty</th>
                                                         <!-- <th class="approve-td d-none">Variance</th> -->
                                                         <!-- <th>Action</th> -->
                                                      </tr>
                                                   </thead>
                                                   <tbody id="transfer-tbody">
                                                      <?php if(isset($data['transfer_items'])){
                                                        if($data['sess_store'] == $value['receiver_store_id']) {
                                                        foreach($data['transfer_items'] as $k=>$row2) { ?>                                         
                                                        <tr class="new-row">
                                                          <td class="text-center"><?= $k+1?></td>
                                                          <td class="text-center">
                                                            <input type="hidden" name="items[<?= $k;?>][transfer_item_id]" value="<?= $row2['id'] ?>">
                                                            <input type="hidden" name="items[<?= $k;?>][item_id]" value="<?= $row2['item_id'] ?>">
                                                            <span><?=$row2['item_name'];?></span>
                                                          </td>
                                                          <td class="text-center"><span><?= $row2['sku_barcode']?></span></td>
                                                          <td class="text-center"><input type="hidden" name="items[<?=$k;?>][manufacture_date]" value="<?=$row2['inventory_detail_id'];?>">
                                                            <span><?=isset($row2['manufacture_expiry_date'])?$row2['manufacture_expiry_date']:'-'?></span></td>
                                                          <td class="text-center"><span><?= $row2['cost_price'] ?></span></td>

                                                          <td class="text-center"><span><?= $row2['selling_price'] ?></span></td>

                                                          <td class="text-center"><span><?= $row2['inventory_quantity'] ?></span></td>
                                                          <td class="text-center"><span><?= $row2['quantity'] ?></span>
                                                            <input class="form-control qty" type="hidden" name="items[<?= $k;?>][quantity]" value="<?= $row2['quantity'] ?>" id="qty"  >
                                                           <input class="form-control" type="hidden" name="items[<?= $k;?>][old_quantity]" value="<?= $row2['quantity'] ?>" id="qty"></td>
                                                           <td><input type="text" name="items[<?= $k;?>][received_qty]" class="form-control received_qty"></td>
                                                          <!-- <td class="text-center"><a data-id="<?= $row2['id']; ?>" data-table="tranfer_items" href="" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a></td> -->
                                                        </tr>
                                                   <?php } } else { 
                                                    foreach($data['transfer_items'] as $k=>$row2) {
                                                    ?>
                                                        <tr class="new-row">
                                                          <td class="text-center"><?= $k+1?></td>
                                                          <td>
                                                            <input type="hidden" name="items[<?= $k;?>][transfer_item_id]" value="<?= $row2['id'] ?>">
                                                            <input type="hidden" name="items[<?= $k;?>][item_id]" value="<?= $row2['item_id'] ?>">
                                                            <input type="text" class="form-control" value="<?=$row2['item_name'];?>">
                                                          </td>
                                                          <td><input type="text" name="items[<?= $k;?>][barcode]" class="form-control sku_barcode" value="<?= $row2['sku_barcode']?>"></td>
                                                          <td><input type="hidden" name="items[<?=$k;?>][manufacture_date]" value="<?=$row2['inventory_detail_id'];?>">
                                                            <input type="text" class="form-control" value="<?=isset($row2['manufacture_expiry_date'])?$row2['manufacture_expiry_date']:'-'?>"></td>
                                                          <td><input class="form-control cost_price" type="text" name="items[<?= $k;?>][cost_price]" value="<?= $row2['cost_price'] ?>" ></td>

                                                          <td><input class="form-control selling_price" type="number" name="items[<?= $k;?>][selling_price]" value="<?= $row2['selling_price'] ?>" id=""></td>

                                                          <td><input class="form-control inventory_qty" type="number" name="items[<?= $k;?>][inventory_qty]" value="<?= $row2['inventory_quantity'] ?>"></td>
                                                          <td><input class="form-control qty" type="number" name="items[<?= $k;?>][quantity]" value="<?= $row2['quantity'] ?>" id="qty"  >
                                                           <input class="form-control" type="hidden" name="items[<?= $k;?>][old_quantity]" value="<?= $row2['quantity'] ?>" id="qty"  ></td>
                                                          <!-- <td class="text-center"><a data-id="<?= $row2['id']; ?>" data-table="tranfer_items" href="" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a></td> -->
                                                        </tr>
                                                   <?php } } }?>
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                          <div class="form-group overflow-hidden">
                                             <div class="col-12">
                                                <!-- <button  onclick="addTransferField();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button> -->
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
                     </section>
                  </div>
               </div>
            </form>
            </div>
         </div>
      </div>
      </div>