<div class="app-content content">
<div class="content-wrapper">
   <?= view('includes/breadcrumb.php');?> 
   <div class="content-body">
      <div class="card">
         <div class="card-body">
            <?php $value = isset($data['stock_adjust'])?$data['stock_adjust']:"";  ?>
            <form method="post" id="stock_adjust_form" name="stock_adjust_form">
               <div class="card">
                  <div class="card-body">
                     <input type="hidden" name="action" id="action" value="post_data_inventory">
                     <input type="hidden" name="table_name" id="table_name" value="stockadjusts">
                     <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                     <input type="hidden" name="total_cost" class="total_cost" value="">
                     <input type="hidden" name="total_quantity" class="total_quantity" value="">
                     <div class="row g-3">
                        <div class="col-md">
                           <div class="form-floating">
                              <select class="form-select" id="reason" name="reason" aria-label="Floating label select example">
                                 <option value="">Select</option>
                                 <?php 
                                    if(!empty($data['reason']))
                                    {
                                       foreach($data['reason'] as $row)
                                       { ?>
                                 <option <?= isset($value['id']) && ($value['reason_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?=$row['reason']?> </option>
                                 <?php
                                    }
                                    } 
                                    ?>
                              </select>
                              <label for="floatingSelectGrid">Reason*</label>
                           </div>
                        </div>
                        <div class="col-md">
                           <div class="form-floating">
                              <select class="form-select store_id" id="store_id" name="store_id" aria-label="Floating label select example">
                                 <option value="">Select</option>
                                 <?php 
                                    if(!empty($data['store']))
                                    {
                                       foreach($data['store'] as $row)
                                       { ?>
                                 <option <?= isset($value['store_id']) && ($value['store_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                                 <?php
                                    }
                                    } 
                                    ?>
                              </select>
                              <label for="floatingSelectGrid">Store*</label>
                           </div>
                        </div>

                        <div class="col-md">
                           <div class="form-floating">
                              <select class="form-select" id="location_id" name="location_id" aria-label="Floating label select example">
                                 <option value="">Select</option>
                                 
                              </select>
                              <label for="floatingSelectGrid">Location*</label>
                           </div>
                        </div>
                        <div class="col-md">
                           <div class="form-floating">
                              <input type="text" class="form-control" id="narration" name="narration" placeholder="Narration" value="<?= isset($value['narration'])?$value['narration']:''?>" >
                              <label for="floatingInputGrid">Narration</label>
                           </div>
                        </div>
                     </div>
                     <br>
                     <div class="row">
                        <div class="col-md-12">
                           <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card">
                  <section id="form-repeater">
                     <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-content collapse show">
                                 <div class="card-body">
                                    <div class="repeater-default">
                                       <div data-repeater-list="car">
                                          <div class="">
                                             <table id="myTable" class="table table-bordered VanderTable">
                                                <thead class="threadClass">
                                                   <tr>
                                                      <th>Item Name</th>
                                                      <th>Quantity</th>
                                                      <th>Item Per Cost</th>
                                                      <th>Cost</th>
                                                      <th>Action</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php if(isset($data['stocks_item'])) { 
                                                      foreach($data['stocks_item'] as $k => $row) {
                                                       ?>
                                                   <tr class="new-row">
                                                      <input type="hidden" name="item[<?= $k;?>][stock_item_id]" value="<?= $row['id']?>">
                                                      <td class="text-center">
                                                         <select class="form-control form-select "  name="item[<?= $k;?>][item_id]" id="item[<?= $k;?>]item_id[]">
                                                            <option value="">Click to select item</option>
                                                            <?php if(isset($data['items'])){
                                                               $items = json_decode($data['items']);
                                                               foreach($items as $v){ 
                                                               ?>
                                                            <option value="<?= $v->id; ?>" <?php if($v->id == $row['item_id']) { echo 'selected';} ?>><?= $v->item_name; ?></option>
                                                            <?php
                                                               }
                                                                 } ?>
                                                         </select>
                                                      </td>
                                                      <td class="text-center"><input class="tabledit-input form-control quantity" type="number" name="item[<?= $k;?>][quantity]" id="qty" value="<?= $row['quantity']; ?>" ></td>
                                                      <td class="text-center"><input class="tabledit-input form-control item_per_cost" type="number" name="item[<?= $k;?>][item_per_cost]" id="item_per_cost" value="<?= $row['item_per_cost']; ?>"  ></td>
                                                      <td class="text-center"><input class="tabledit-input form-control cost" type="number" name="item[<?= $k;?>][cost]" id="item[<?= $k;?>]cost[]" value="<?= $row['cost']; ?>"  ></td>
                                                      <td class="text-center">
                                                         <!-- <a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp; -->
                                                         <a href="" data-id="<?= $row['id']; ?>" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>
                                                      </td>
                                                   </tr>
                                                   <?php }
                                                      }else{ ?>
                                                   <tr class="new-row">
                                                      <input type="hidden" name="item[0][stock_item_id]" value="<?= $row['id']?>">
                                                      <td class="text-center">
                                                         <select class="form-control form-select item_id "  name="item[0][item_id]" id="item[0]item_id[]">
                                                            <option  value="">Click to select item</option>
                                                            <?php if(isset($data['items'])){
                                                               $items = json_decode($data['items']);
                                                               foreach($items as $v){ 
                                                               ?>
                                                            <option data-price="<?= $v->supply_price?>" value="<?= $v->id; ?>" ><?= $v->item_name; ?></option>
                                                            <?php
                                                               }
                                                                 } ?>
                                                         </select>
                                                      </td>
                                                      <td class="text-center"><input class="tabledit-input form-control quantity" type="number" name="item[0][quantity]" id="qty" value="" ></td>

                                                      <td class="text-center"><input class="tabledit-input form-control item_per_cost" type="number" name="item[0][item_per_cost]" id="item_per_cost" value="" >
                                                      </td>

                                                      <td class="text-center"><input class="tabledit-input form-control cost" type="number" name="item[0][cost]" id="item[0]cost[]" value=""></td>
                                                      <td class="text-center">
                                                         <!-- <a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp; -->
                                                         <a href="" data-id="0" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>
                                                      </td>
                                                   </tr>
                                                   <?php } ?>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                       <div class="form-group overflow-hidden">
                                          <div class="col-12">
                                             <button  onclick="addStockAdjustment();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="col-md-4 float-right add-form-footer p-1">
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <span>Total Quantity</span>
                                                </div>
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                   <span id="total_qty"><?= isset($value['total_quantity'])?$value['total_quantity']:''?></span>
                                                </div>
                                             </div>
                                             <hr>
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <span>Total Cost</span>
                                                </div>
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                   <span id='total_cost'><?= isset($value['total_cost'])?$value['total_cost']:''?></span>
                                                </div>
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
                  </section>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>