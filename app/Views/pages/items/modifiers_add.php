      <div class="app-content content">
         <div class="content-wrapper">
            <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <div class="card">
                  <div class="card-body">
                     <?php $value = isset($data['modifier'])?$data['modifier']:"";  ?>
                     <form method="post" id="modifier_form" name="modifier_form">
                         <input type="hidden" name="action" id="action" value="post_items_data">
                        <input type="hidden" name="table_name" id="table_name" value="modifiers">
                        <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="form-floating">
                                       <input type="text" class="form-control" name="name" id="name" value="<?= isset($value['name'])?$value['name']:''?>" placeholder="name" >
                                       <label for="name">Modifier Name</label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 pt-1">
                              <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                           </div>
                        </div>
                        <hr>
                        <div class="card">
                           <div class="card-body">
                              <section id="form-repeater">
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="card">
                                          <div class="card-content collapse show">
                                             <p class="text-bold-400">Add Items</p>
                                             <div class="repeater-default">
                                                <div>
                                                   <div class="">
                                                      <table id="add-modifier" class="table table-bordered">
                                                         <thead class="threadClass">
                                                            <tr>
                                                               <th></th>
                                                               <th>Modifier Item</th>
                                                               <th style="width:300px;">Item</th>
                                                               <th>Quantity</th>
                                                               <th>Cost per Qty</th>
                                                               <th>Total Cost</th>
                                                               <th>Action</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                            <?php $items = json_decode($data['items']);
                                                            if(isset($value['modifier_items']) && !empty($value['modifier_items'])){
                                                               foreach($value['modifier_items'] as $k=>$row){
                                                               ?>
                                                               <tr class="new-row">
                                                                  <td class="text-center"><?= $k+1; ?></td>
                                                                  <td>
                                                                     <input type="hidden" name="items[<?= $k+1; ?>][modifier_item_id]" value="<?= isset($row['id'])?$row['id']:""; ?>">
                                                                     <input class="form-control modifier-item" type="text" name="items[<?= $k+1; ?>][modifier_item]" value="<?= isset($row['modifier_item_name'])?$row['modifier_item_name']:""; ?>">
                                                                  </td>
                                                                  <td>
                                                                    <select class="form-control form-select item_id" name="items[<?= $k+1; ?>][item_id]">
                                                                        <option value="">Click to select item</option>
                                                                        <?php
                                                                        
                                                                         foreach($items as $v) { ?>
                                                                           <option value="<?= $v->id; ?>" <?php if($v->id == $row['item_id']) { echo 'selected';} ?>><?= $v->item_name; ?></option>
                                                                        <?php } ?>
                                                                     </select>
                                                                  </td>
                                                                  <td>
                                                                     <input class="form-control unit" type="number" name="items[<?= $k+1; ?>][unit]"  value="<?= isset($row['quantity'])?$row['quantity']:"" ?>">
                                                                  </td>
                                                                  <td>
                                                                     <input class="form-control cost" type="text" name="items[<?= $k+1; ?>][cost]" value="<?= isset($row['cost'])?$row['cost']:"" ?>">
                                                                  </td>
                                                                  <td>
                                                                     <input class="form-control total_cost" type="text" name="items[<?= $k+1; ?>][total_cost]" value="<?= isset($row['total_cost'])?$row['total_cost']:"" ?>">
                                                                  </td>
                                                                  <td></td>
                                                               </tr>
                                                               <?php 
                                                               }
                                                            } else{ ?>
                                                            <tr class="new-row">
                                                                  <td class="text-center">1</td>
                                                                  <td>
                                                                     <input class="form-control modifier-item" type="text" name="items[1][modifier_item]" value="">
                                                                  </td>
                                                                  <td>
                                                                     <select class="form-control form-select select2 item_id" name="items[1][item_id]">
                                                                        <option value="">Click to select item</option>
                                                                        <?php
                                                                        
                                                                         foreach($items as $v) { ?>
                                                                           <option value="<?= $v->id; ?>"><?= $v->item_name; ?></option>
                                                                        <?php } ?>
                                                                     </select>
                                                                  </td>
                                                                  <td>
                                                                     <input class="form-control unit" type="text" name="items[1][unit]" value="">
                                                                  </td>
                                                                  <td>
                                                                     <input class="form-control cost" type="text" name="items[1][cost]" value="">
                                                                  </td>
                                                                  <td>
                                                                     <input class="form-control total_cost" type="text" name="items[1][total_cost]" value="">
                                                                  </td>
                                                                  <td class="text-center">
                                                                     <a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a>
                                                                  </td>
                                                            </tr>
                                                            <?php } ?>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                                <div class="form-group overflow-hidden">
                                                   <div class="col-12">
                                                      <button onclick="addModifierField();" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
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
                     
                        <div class="form-footer pt-1">
                           <div class="row">
                               <div class="col-md-6">
                              </div>
                              <div class="col-md-6 text-right">
                                 <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               
            </div>
         </div>
      </div>