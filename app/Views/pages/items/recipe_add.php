<style type="text/css">
  #select2-group_name-container {
    height: 52px!important;
    line-height: 60px!important;
  }
</style>
<div class="app-content content">
   <div class="content-wrapper">
       <?= view('includes/breadcrumb.php');?>
      <div class="content-body">
         <div class="card">
            <div class="card-body">
                <?php $value = isset($data['recipe'])?$data['recipe']:"";  ?>
               <form method="post" id="recipe_form" name="recipe_form">
                  <input type="hidden" name="action" id="action" value="post_items_data">
                  <input type="hidden" name="table_name" id="table_name" value="recipes_master">
                  <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                  <section id="form-repeater">
                     <div class="row g-2">
                        <div class="col-md">
                           <div class="form-floating">
                              <select class="select2 form-control" id="group_name" name="group_name">
                                 <option value="" disabled selected>Please select</option>
                                  <?php if(!empty($data['is_recipe_items'])){
                                  foreach($data['is_recipe_items'] as $row){
                                  ?>
                                  <option <?= isset($value['group_name']) && ($value['group_name'] == $row['id'])?'selected':''?> value="<?=$row['id']?>"><?=$row['item_name']?></option>
                                  <?php } } ?>
                              </select>
                              <!-- <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Select Group" value="<?= isset($value['group_name'])?$value['group_name']:''?>" > -->
                              <label for="floatingInputGrid">Select Group</label>
                              <!-- <div class="form-control-position">
                                 <i class="fa fa-search" style="padding:25px;"></i>
                              </div> -->
                           </div>
                        </div>
                        <div class="col-md">
                        </div>
                     </div>
                     <hr>
                  </section>
                  <div class="card">
                     <div class="card-body">
                        <section id="form-repeater">
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <p class="text-bold-400">Add Items</p>
                                       <div class="repeater-default">
                                          <div data-repeater-list="car">
                                             <div class="">
                                                <table id="Add-Recipe" class="table  table-bordered ">
                                                   <thead class="threadClass">
                                                      <tr>
                                                         <th></th>
                                                         <th>Item ID</th>
                                                         <th>Unit</th>
                                                         <th>Cost</th>
                                                         <th>Action</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <?php
                                                      $items = json_decode($data['is_ingredient_items']);
                                                      if(isset($value['recipe_items']) && !empty($value['recipe_items'])){
                                                         foreach($value['recipe_items'] as $k=>$row){
                                                         ?>
                                                         <tr class="new-row">
                                                            <td class="text-center">1</td>
                                                            <td>
                                                               <input type="hidden" name="items[<?= $k+1; ?>][recipe_items_id]" value="<?= isset($row['id'])?$row['id']:""; ?>">
                                                               <select class="form-control form-select recipe-item" data-tab="recipe" name="items[<?= $k+1; ?>][item_id]">
                                                                  <option value="">Click to select item</option>
                                                                  <?php
                                                                   foreach($items as $v) { ?>
                                                                     <option value="<?= $v->id; ?>" <?php if($v->id == $row['item_id']) { echo 'selected';} ?>><?= $v->item_name; ?></option>
                                                                  <?php } ?>
                                                               </select>
                                                            </td>
                                                            <td>
                                                               <input class="form-control unit" type="number" name="items[<?= $k+1; ?>][unit]"  value="<?= isset($row['unit'])?$row['unit']:"" ?>">
                                                            </td>
                                                            <td>
                                                              <input class="form-control total_cost" type="number" name="items[<?= $k+1; ?>][total_cost]" value="<?= $row['total_cost']; ?>">
                                                              <input class="form-control cost" type="hidden" name="items[<?= $k+1; ?>][cost]" value="<?= $row['cost']; ?>">
                                                            </td>
                                                         </tr>
                                                         <?php 
                                                         }
                                                      }else{ 
                                                      ?>
                                                         <tr class="new-row">
                                                               <td class="text-center">1</td>
                                                               <td>
                                                                  <select class="form-control form-select item_id" data-tab="recipe" name="items[1][item_id]">
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
                                                                  <input class="form-control total_cost" type="number" name="items[1][total_cost]" value="">
                                                                  <input class="form-control cost" type="hidden" name="items[1][cost]" value="">
                                                               </td>
                                                               <td class="text-center">
                                                                  <a href="#" class="transh-icon-color item-remove " data-id="<?= isset($row2['id'])?$row2['id']:""?>" title="Remove"><i class="fa fa-trash-o"></i></a>
                                                               </td>
                                                         </tr>
                                                      <?php } ?>
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                          <div class="form-group overflow-hidden">
                                             <div class="col-12">
                                                <button onclick="addRecipeField();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                       
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                     <div class="form-footer pt-1">
                        <div class="row">
                           <div class="col-md-6">
                             <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                           </div>
                           <div class="col-md-6 text-right">
                             <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>