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
                            <input type="text" class="form-control" value="<?= $value['supply_store'] ?>" disabled>
                            <label for="floatingSelectGrid">Supply Store*</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                              <div class="form-floating">
                                <input type="text" class="form-control" value="<?= $value['supply_loc'] ?>" disabled>  
                                <label for="floatingSelectGrid">Location*</label>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                              <input type="text" class="form-control" value="<?= $value['receiver_store'] ?>" disabled>
                              <label for="floatingSelectGrid">Receiving Store*</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                            <input type="text" class="form-control" value="<?= $value['receive_loc'] ?>" disabled>
                            <label for="floatingSelectGrid">Receiving Location*</label>
                           </div>
                        </div>
                      </div>
                      <!-- <div class="row pt-1">
                        <div class="col-md-3">
                           <div class="form-floating">
                              
                              <?php
                                $status = "Pending";
                                if($value['status'] == "1") {
                                  $status = "Approved";
                                } else if($value['status'] == "2") {
                                  $status = "Cancelled";
                                }
                              ?>
                                <input type="text" class="form-control" value="<?= $status; ?>" disabled>
                              
                              <label for="floatingInputGrid">Status </label>
                           </div>
                        </div>
                     </div> -->
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
                                                <table class="table  table-bordered ">
                                                   <thead class="threadClass">
                                                      <tr>
                                                         <th>#</th>
                                                         <th>Item Name</th>
                                                         <th>Barcode</th>
                                                         <th>DOM - Expiry Date (Lot No.)</th>
                                                         <th>Cost Price</th>
                                                         <th>Selling Price</th>
                                                         <th>Inventory Qty.</th>
                                                         <th>Qty</th>
                                                         <th>Received Qty</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                     <?php if(isset($data['transfer_items']) && !empty($data['transfer_items'])) { 
                                                      foreach($data['transfer_items'] as $k => $row2) { ?>
                                                      <tr class="new-row">
                                                        <td><?=$k+1?></td>
                                                        <td><?= $row2['item_name'] ?></td>
                                                        <td><?= $row2['sku_barcode'] ?> </td>
                                                        <td><?= $row2['dom'] ?> - <?=$row2['expiry_date']?> (<?=$row2['lot_no']?>) </td>
                                                        <td><?= $row2['cost_price']  ?> </td>
                                                        <td><?= $row2['selling_price'] ?></td>
                                                        <td><?= $row2['inventory_quantity'] ?></td>
                                                        <td><?= $row2['quantity'] ?></td>
                                                        <td><?= $row2['received_quantity'] != "" ? $row2['received_quantity'] :'-'; ?></td>
                                                      </tr>
                                                   <?php } } ?>
                                                   </tbody>
                                                </table>
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