<style type="text/css">
  .avatar-upload {
    position: relative;
    max-width: 145px;
  }
  .avatar-upload .avatar-edit {
    position: absolute;
    right: -50px;
    z-index: 1;
    top: 10px;
  }
  .avatar-upload .avatar-edit input {
    display: none;
  }
  .avatar-upload .avatar-edit input + label {
    display: inline-block;
    margin-bottom: 0;
    background: #FFFFFF;
    border: 1px solid F05624;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;
  }
  .avatar-upload .avatar-edit input + label:hover {
    background-color: #F05624;
      color: #FFF!important;
  }
  .avatar-upload .avatar-preview {
    width: 65px;
    height: 65px;
    position: relative;
    border-radius: 100%;
    border: 3px solid #F8F8F8;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
  }
  #imagePreview  {
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  .align-center {
    align-items: center;
  }
  .select2-container {
    width:100%!important;
  }
  .table.price-table td, .table.br-table td {
    padding: 5px;
  }
  
  #variant-table .new-row td, #composite-item-table .new-row td {
    padding: 0px;
  }
  #variant-table .new-row td {
    text-align: left;
  }
  .variant-item-pr {
    table-layout: fixed;
    margin-bottom: 0px;
  }
  .variant-item-pr td, .variant-item-tbl td {
    padding: 5px;
  }
</style>
<div class="app-content content">
<div class="content-wrapper">
   <?= view('includes/breadcrumb.php');?> 
   <div class="content-body">
      <div class="card">
         <div class="card-body">
            <div class="row">
              
               <!-- Icon Tab with bottom line -->
               <div class="col-xl-12 col-lg-12">
                  <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                     <li class="nav-item">
                        <a class="nav-link item-tab-heads active" id="linkIcon12-tab1" data-toggle="tab" href="#standard-item" aria-controls="linkIcon12" aria-expanded="true">
                           <h4 class="card-title"><span>Standard Item</span> <small class="block">This Item has one SKU<br> with its own inventory</small></h4>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link item-tab-heads" id="linkIcon12-tab2" data-toggle="tab" href="#item-with-varience" aria-controls="linkIcon12" aria-expanded="false">
                           <h4 class="card-title"><span>Item With Attribute</span> <small class="block">This item has different<br>variants like sizes, colors</small></h4>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link item-tab-heads" id="linkIcon12-tab3" data-toggle="tab" href="#composite-item" aria-controls="linkIcon12" aria-expanded="false">
                           <h4 class="card-title"><span>Combo Item</span> <small class="block">This item contains a specified<br>
                              quantity of other items</small>
                           </h4>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="tab-content ">
               <div role="tabpanel" class="tab-pane active show" id="standard-item" aria-labelledby="linkIcon12-tab1" aria-expanded="true">
                  <div class="card card-content collapse show">
                    <div class="card-body card-dashboard">
                      <form method="post" id="standard_item_form" name="standard_item_form" enctype="multipart/form-data">
                        <?php 
                          $value = isset($data['item'])?$data['item']:"";
                          $type = isset($value['item_type'])?$value['item_type']:'';
                          $modifiers = [];
                          if(!empty($value)){
                            $modifiers = json_decode($value['modifier_id']);
                          }
                        ?>
                        <input type="hidden" name="action" id="action" value="post_items_data">
                        <input type="hidden" name="table_name" id="table_name" value="items">
                        <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <input type="hidden" name="item_type" id="item_type" value="1">
                        <input type="hidden" name="item_image_old" id="item_image_old" value="<?= isset($value['item_image'])?$value['item_image']:''?>">
                        <input type="hidden" name="item_image" id="item_image">
                        <input type="hidden" name="item_image_variance" id="item_image_variance">
                        <input type="hidden" name="item_image_composite" id="item_image_composite">
                        <input type="hidden" name="profile_image_name" id="imagePreview_name" value="">
                        
                        <div class="row">

                          <div class="col-md-12">
                             <h5 class="text-bold-500">Item Price</h5>
                             <div class="repeater-default">
                               <div class="">
                                  <table class="table price-table" style="table-layout: fixed;">
                                     <thead class="threadClass">
                                        <tr>
                                           <th>Store</th>
                                           <th>Supply Price</th>
                                           <th>Markup</th>
                                           <th>Retail Price</th>
                                           <th><span data-toggle="tooltip" data-placement="top" title="Minimum Retail Price(%)">MRP(%)</span></th>
                                           <th><span data-toggle="tooltip" data-placement="top" title="Minimum Retail Price">MRP</span></th>
                                           <th>Current Inventory</th>
                                           <th>Inventory Value</th>
                                           <th>ReOrder Point</th>
                                        </tr>
                                     </thead>
                                     <tbody>
                                      <?php 
                                      if(!empty($data['stores'])) {
                                        foreach($data['stores'] as $k => $row) { ?>
                                        <tr class="new-row">
                                           <td>
                                            <input type="hidden" value="<?= isset($row['p_id']) && $type==1?$row['p_id']:''?>" name="items_pr[<?=$k;?>][id]">
                                            <input type="hidden" value="<?= $row['id']; ?>" name="items_pr[<?=$k;?>][store_id]">
                                             <input type="text" class="form-control store" name="items_pr[<?=$k;?>][store_name]" placeholder="Store" value="<?= $row['store_name']; ?>" readonly> 
                                           </td>
                                           <td>
                                              <input type="text" class="form-control p-supply_price" name="items_pr[<?=$k;?>][supply_price]" placeholder="Supply Price" value="<?= isset($row['supply_price']) && $type==1?$row['supply_price']:''?>">  
                                           </td>
                                           <td>
                                              <input type="text" class="form-control p-markup" name="items_pr[<?=$k;?>][markup]" placeholder="Markup" value="<?= isset($row['markup']) && $type==1?$row['markup']:''?>">  
                                           </td>
                                           <td>
                                              <input type="text" class="form-control p-retail_price" name="items_pr[<?=$k;?>][retail_price]" placeholder="Retail Price" value="<?= isset($row['retail_price']) && $type==1?$row['retail_price']:''?>">
                                           </td>
                                           <td class="text-center">
                                              <input type="text" class="form-control p-mrp_percent" name="items_pr[<?=$k;?>][mrp_percent]" placeholder="Minimum Price(%)" value="<?= isset($row['mrp_percent']) && $type==1?$row['mrp_percent']:''?>">
                                           </td>
                                           <td class="text-center">
                                              <input type="text" class="form-control p-mrp" name="items_pr[<?=$k;?>][mrp]" placeholder="Minimum Price" value="<?= isset($row['mrp']) && $type==1?$row['mrp']:''?>">
                                           </td>
                                           <td>
                                              <input type="text" class="form-control p-current_inventory" name="items_pr[<?=$k;?>][current_inventory]" placeholder="Current Inventory" value="<?= isset($row['current_inventory']) && $type==1?$row['current_inventory']:''?>">
                                           </td>
                                           <td class="text-center">
                                              <input type="text" class="form-control p-inventory_value" name="items_pr[<?=$k;?>][inventory_value]" placeholder="Inventory Value" value="<?= isset($row['inventory_value']) && $type==1?$row['inventory_value']:''?>">
                                           </td>
                                           <td class="text-center">
                                              <input type="text" class="form-control p-reorder_point" name="items_pr[<?=$k;?>][reorder_point]" placeholder="ReOrder Point" value="<?= isset($row['re_order_point']) && $type==1?$row['re_order_point']:''?>">
                                           </td>
                                        </tr>
                                      <?php } } else { ?>
                                        <tr>
                                          <td style="text-align: center;" colspan="9">No Data Available</td>
                                        </tr>
                                      <?php } ?>
                                     </tbody>
                                  </table>
                               </div>
                             </div>
                          </div>
                          <div class="col-md-12 pt-2"></div>
                          <div class="col-md-8 border-right">
                              <h5 class="text-bold-500">Item Details</h5>
                              <div class="row pt-1">
                                  <div class="col-md-4">
                                     <div class="form-floating">
                                        <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Item Name" value="<?= isset($value['item_name']) && $type==1 ?$value['item_name']:''?>" >
                                        <label for="floatingInputGrid">Item Name</label>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-floating">
                                        <select class="form-select category_list category_id" name="category_id" id="category_id" data-type="standard" aria-label="Floating label select example">
                                           <option value="">Please select</option>
                                           <?php if(!empty($data['category'])){
                                              foreach($data['category'] as $row){
                                              ?>
                                           <option <?php echo isset($value['category_id']) && ($value['category_id'] == $row['id']) && $type==1 ?"selected":""; ?> value="<?=$row['id']?>"><?=$row['category_name']?></option>
                                           <?php } } ?>
                                           <option class="font-color" value="category">Add Category</option>
                                        </select>
                                        <label for="category_id">Category</label>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-floating">
                                      <select class="form-select subcategory_id " name="subcategory_id" id="subcategory_id" aria-label="Floating label select example">
                                         <option value="">Please select</option>
                                         <?php if(isset($data['sub_category'])){ ?>
                                         <?php
                                            foreach($data['sub_category'] as $row){
                                            ?>
                                         <option <?php echo isset($value['subcategory_id']) && ($value['subcategory_id'] == $row['id']) && $type==1 ?"selected":""; ?>  value="<?=$row['id']?>"><?=$row['subcategory_name']?></option>
                                      <?php } } ?>
                                      <option class="font-color" value="subcategory">Add Subcategory</option>
                                      </select>
                                      <label for="subcategory_id">Sub Category</label>
                                    </div>
                                  </div>
                              </div>
                              <div class="row pt-1">
                                  <div class="col-md-4">
                                     <div class="form-floating">
                                        <input type="text" class="form-control" name="sku_barcode" id="sku_barcode" placeholder="SKU" value="<?= isset($value['sku_barcode']) && $type==1 ?$value['sku_barcode']:''?>" >
                                        <label for="sku_barcode">SKU</label>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-floating">
                                        <input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" value="<?= isset($value['barcode']) && $type==1 ?$value['barcode']:''?>" >
                                        <label for="barcode">Barcode</label>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-floating">
                                      <input type="number" class="form-control" name="shelflife" id="shelflife" placeholder="Shelflife" value="<?= isset($value['shelflife'])?$value['shelflife']:''?>">
                                      <label for="shelflife">Shelflife</label>
                                    </div>     
                                  </div>
                              </div>
                              <div class="row pt-1">
                                <div class="col-md-4">
                                  <div class="form-floating">
                                    <select class="form-select uom_list uom_id " name="uom_id" id="uom_id" aria-label="Floating label select example">
                                       <option value="">Please select</option>
                                       <?php if(!empty($data['uom'])){
                                          foreach($data['uom'] as $row){
                                       ?>
                                       <option <?php echo isset($value['uom_id']) && ($value['uom_id'] == $row['id']) && $type==1 ?"selected":""; ?> value="<?= $row['id']?>"><?= $row['uom']?></option>
                                       <?php }
                                          } ?>
                                       <option class="font-color" value="uom">Add UOM</option>
                                    </select>
                                    <label for="uom_id">UOM</label>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-floating">
                                      <input type="number" class="form-control" name="pack_size" id="pack_size" placeholder="Shelflife" value="<?= isset($value['pack_size'])?$value['pack_size']:''?>">
                                      <label for="pack_size">Pack Size</label>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-floating">
                                      <select class="form-select tax_list" name="tax_id" id="tax_id" aria-label="Floating label select example">
                                         <!-- <option value="">Please select</option> -->
                                         <?php if(!empty($data['tax'])){
                                            foreach($data['tax'] as $row){
                                               ?>
                                         <option <?php echo isset($value['tax_id']) && ($value['tax_id'] == $row['id']) && $type==1 ?"selected":""; ?> value="<?= $row['id']?>"><?= $row['tax_type']?></option>
                                         <?php }
                                            } ?>
                                             <option class="font-color" value="tax">Add Tax</option>
                                      </select>
                                      <label for="tax_id">Tax</label>
                                   </div>
                                </div>
                              </div>
                              <div class="row pt-1">
                                <div class="col-md-4">
                                   <div class="form-floating">
                                      <select class="form-select " name="purchase_tax_id" id="purchase_tax_id" aria-label="Floating label select example">
                                         <!-- <option value="">Please select</option> -->
                                         <?php if(!empty($data['tax'])){
                                            foreach($data['tax'] as $row){
                                               ?>
                                         <option <?php echo isset($value['purchase_tax_id']) && ($value['purchase_tax_id'] == $row['id']) && $type==1 ?"selected":""; ?>  value="<?= $row['id']?>"><?= $row['tax_type']?></option>
                                         <?php }
                                            } ?>
                                      </select>
                                      <label for="purchase_tax_id">Purchase Tax</label>
                                   </div>
                                </div> 
                                <div class="col-md-4">
                                   <div class="form-floating">
                                      <select class="form-select brand_list" name="brand_id" id="brand_id" aria-label="Floating label select example">
                                         <option value="">Please select</option>
                                         <?php if(!empty($data['brand'])){
                                            foreach($data['brand'] as $row){
                                               ?>
                                         <option <?php echo isset($value['brand_id']) && ($value['brand_id'] == $row['id']) && $type==1 ?"selected":""; ?> value="<?= $row['id']?>"><?= $row['brand_name']?></option>
                                         <?php }
                                            } ?>
                                            <option class="font-color" value="brand">Add Brand</option>
                                      </select>
                                      <label for="brand_id">Brand</label>
                                   </div>
                                </div> 
                                <!-- <div class="col-md-4">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" name="item_description" id="item_description" placeholder="Item Description" value="<?= isset($value['item_description'])?$value['item_description']:''?>" >
                                    <label for="item_description">Item Description</label>
                                  </div>     
                                </div> -->
                                <div class="col-md-4">
                                   <div class="form-floating" style="padding-top: 5px">
                                    <button type="button" class="btn" style="width:100%;" data-target="#select-modifiers-item" data-toggle="modal">Modifiers</button>
                                    <input type="hidden" class="u-modifiers" name="modifier_id" value='<?= isset($value['modifier_id']) && $type==1 ?$value['modifier_id']:"" ?>'>
                                   </div>
                                </div> 
                              </div>
                              <div class="row pt-1">
                                <div class="col-md-12">
                                   <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                                </div>
                              </div>

                              <br><br>
                              <h5 class="text-bold-500">Item Specification</h5>
                              <div class="row pt-1">
                                  <div class="col-md-12">
                                    <table class="table br-table" id="br-table">
                                      <thead class="threadClass">
                                        <th>Specification</th>
                                        <th>Barcode</th>
                                        <th>Unit</th>
                                        <th>Coefficient</th>
                                        <th>Action</th>
                                      </thead>
                                      <tbody>
                                        <tbody>
                                          <?php if(isset($value['barcode_specification']) && !empty($value['barcode_specification'])) { 
                                            $bJson = json_decode($value['barcode_specification']);
                                            foreach($bJson as $k => $v) {
                                          ?>
                                          <tr class="new-row">
                                           <td><input type="text" name="br[<?= $k+1 ?>][specification]" class="form-control" value="<?=$v->specification?>"></td>
                                           <td><input type="text" name="br[<?= $k+1 ?>][barcode]" class="form-control" value="<?=$v->barcode?>"></td>
                                           <td><input type="text" name="br[<?= $k+1 ?>][unit]" class="form-control" value="<?=$v->unit?>"></td>
                                           <td><input type="text" name="br[<?= $k+1 ?>][coefficient]" class="form-control" value="<?=$v->coefficient?>"></td>
                                           <td></td>
                                          </tr>
                                        <?php } } else { ?>
                                          <tr class="new-row">
                                           <td><input type="text" name="br[0][specification]" class="form-control"></td>
                                           <td><input type="text" name="br[0][barcode]" class="form-control"></td>
                                           <td><input type="text" name="br[0][unit]" class="form-control"></td>
                                           <td><input type="text" name="br[0][coefficient]" class="form-control"></td>
                                           <td></td>
                                         </tr>
                                       <?php } ?>
                                        </tbody>
                                      </tbody>
                                    </table>
                                    <div class="col-12">
                                        <button  onclick="addBarcodeSpec();" data-repeater-create type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add</button>
                                     </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-4">
                             <h5 class="text-bold-500">Item Image</h5>
                             <div class="row align-center">
                                <div class="col-md-6">
                                   <div class="uploadOuter">
                                      <input type="file" name="item_image" id="item_image" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"  />
                                      
                                      <label for="uploadFile" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i>  Browse Files</label>
                                      <p>128 * 128 Size</p>
                                      <p>Supported upto to 25 MB</p>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <img id="imagePreview" style="width:180px;height:180px;border-radius: 5px;" src="<?=GetImagePath(isset($value['item_image']) && $type==1 ?$value['item_image']:'','items')?>">
                                </div>
                             </div>
                             <?php $item_option = isset($data['item']['item_options']) && $type==1 ?json_decode($data['item']['item_options']):"";

                              ?>
                             <p class="text-bold-400 pt-1">Item Options</p>
                             <div class="row ">
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[stockable]" id="stockable" <?= isset($item_option->stockable) && ($item_option->stockable == 1)?"checked":""; ?> value="1"  >
                                      <label for="stockable">Stockable</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[can_sale]" id="cansale" value="1" <?= isset($item_option->can_sale) && ($item_option->can_sale == 1)?"checked":""; ?> >
                                      <label for="cansale">Can Sale</label> 
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[weighing_scale]" id="weighing_scale" value="1" <?= isset($item_option->weighing_scale) && ($item_option->weighing_scale == 1)?"checked":""; ?> >
                                      <label for="weighing_scale">Weighing Scale</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[weight_item]" id="weight_item" value="1" <?= isset($item_option->weight_item) && ($item_option->weight_item == 1)?"checked":""; ?> >
                                      <label for="weight_item">Weight Item</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[favourite]" id="favourite" value="1" <?= isset($item_option->favourite) && ($item_option->favourite == 1)?"checked":""; ?> >
                                      <label for="favourite">Favourite</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[is_service]" id="is_service" value="1" <?= isset($item_option->is_service) && ($item_option->is_service == 1)?"checked":""; ?>  >
                                      <label for="is_service">Is Service</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[is_recipe]" id="is_recipe" value="1" <?= isset($item_option->is_recipe) && ($item_option->is_recipe == 1)?"checked":""; ?>  >
                                      <label for="is_recipe">Recipe</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[is_ingredient]" id="is_ingredient" value="1" <?= isset($item_option->is_ingredient) && ($item_option->is_ingredient == 1)?"checked":""; ?>  >
                                      <label for="is_ingredient">Ingredient</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[can_purchase]" id="can_purchase" value="1" <?= isset($item_option->can_purchase) && ($item_option->can_purchase == 1)?"checked":""; ?>  >
                                      <label for="can_purchase">Can Purchase</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[pre_production]" id="pre_production" value="1" <?= isset($item_option->pre_production) && ($item_option->pre_production == 1)?"checked":""; ?>  >
                                      <label for="pre_production">Pre Production</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[track_expiry]" id="track_expiry" value="1" <?= isset($item_option->track_expiry) && ($item_option->track_expiry == 1)?"checked":""; ?>  >
                                      <label for="track_expiry">Track Expiry</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <input type="checkbox" name="item_option[track_serial_no]" id="track_serial_no" value="1" <?= isset($item_option->track_serial_no) && ($item_option->track_serial_no == 1)?"checked":""; ?>  >
                                      <label for="track_serial_no">Track Serial Number</label>
                                      <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="col-md-12 pt-2">
                            <div class="form-footer text-right">
                                <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                            </div>
                          </div>
                        </div>
                      </form>
                     </div>
                  </div>
               </div>
               <div class="tab-pane" id="item-with-varience" role="tabpanel" aria-labelledby="linkIcon12-tab2" aria-expanded="false">
                  <form method="post" id="variance_item_form" name="variance_item_form">
                     <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                           <input type="hidden" name="action" id="action" value="post_items_data">
                           <input type="hidden" name="table_name" id="table_name" value="items">
                           <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                           <input type="hidden" name="item_type" id="item_type" value="2">
                           <div class="row">
                              <div class="col-md-12 pt-2"></div>
                              <div class="col-8 border-right">
                                <h5 class="text-bold-500">Item Details</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Item Name" value="<?= isset($value['item_name']) && $type==2 ?$value['item_name']:''?>" >
                                          <label for="floatingInputGrid">Item Name</label>
                                       </div>
                                    </div>
                                  <!-- <div class="col-md-4">
                                     <div class="form-floating">
                                        <input type="text" class="form-control" name="sku_barcode" id="sku_barcode" placeholder="SKU" value="<?= isset($value['sku_barcode'])?$value['sku_barcode']:''?>" >
                                        <label for="sku_barcode">SKU</label>
                                     </div>
                                  </div>
                                 <div class="col-md-4">
                                     <div class="form-floating">
                                        <input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" value="<?= isset($value['barcode'])?$value['barcode']:''?>" >
                                        <label for="barcode">Barcode</label>
                                     </div>
                                  </div> -->
                                </div>
                                <div class="row pt-1">
                                    <div class="col-md-4">
                                      <div class="form-floating">
                                        <input type="number" class="form-control" name="shelflife" id="shelflife" placeholder="Shelflife" value="<?= isset($value['shelflife'])?$value['shelflife']:''?>" >
                                        <label for="shelflife">Shelflife</label>
                                      </div>     
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select category_list category_id variance_category_id " name="category_id" id="variance_category_id" data-type="variance" aria-label="Floating label select example">
                                             <option value="">Please select</option>
                                             <?php if(!empty($data['category'])){
                                                foreach($data['category'] as $row){
                                                ?>
                                             <option <?php echo isset($value['category_id']) && ($value['category_id'] == $row['id']) && $type==2 ?"selected":""; ?> value="<?=$row['id']?>"><?=$row['category_name']?></option>
                                             <?php } } ?>
                                          <option class="font-color" value="category">Add Category</option>
                                          </select>
                                          <label for="category_id">Category</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select variance_subcategory_id" name="subcategory_id" id="subcategory_id" aria-label="Floating label select example">
                                             <option>Please select</option>
                                             <?php if(isset($data['sub_category'])){ ?>
                                             <?php
                                                foreach($data['sub_category'] as $row){
                                                ?>
                                             <option <?php echo isset($value['subcategory_id']) && ($value['subcategory_id'] == $row['id']) && $type==2 ?"selected":""; ?>  value="<?=$row['id']?>"><?=$row['subcategory_name']?></option>
                                          <?php } } ?>
                                            <option class="font-color" value="subcategory">Add Subcategory</option>
                                          </select>
                                          <label for="subcategory_id">Sub Category</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row pt-1">
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select uom_list uom_id" name="uom_id" id="uom_id" aria-label="Floating label select example">
                                             <option value="">Please select</option>
                                             <?php if(!empty($data['uom'])){
                                                foreach($data['uom'] as $row){
                                             ?>
                                           <option <?php echo isset($value['uom_id']) && ($value['uom_id'] == $row['id']) && $type==2 ?"selected":""; ?> value="<?= $row['id']?>"><?= $row['uom']?></option>
                                             <?php }
                                                } ?>
                                                <option class="font-color" value="uom">Add UOM</option>
                                          </select>
                                          <label for="uom_id">UOM</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-floating">
                                          <input type="number" class="form-control" name="pack_size" id="pack_size" placeholder="Shelflife" value="<?= isset($value['pack_size'])?$value['pack_size']:''?>">
                                          <label for="pack_size">Pack Size</label>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select tax_list tax_id" name="tax_id" id="tax_id" aria-label="Floating label select example">
                                             <!-- <option value="">Please select</option> -->
                                             <?php if(!empty($data['tax'])){
                                                foreach($data['tax'] as $row){
                                                   ?>
                                            <option <?php echo isset($value['tax_id']) && ($value['tax_id'] == $row['id']) && $type==2 ?"selected":""; ?> value="<?= $row['id']?>"><?= $row['tax_type']?></option>
                                             <?php }
                                                } ?>
                                                <option class="font-color" value="tax">Add Tax</option>
                                          </select>
                                          <label for="tax_id">Tax</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row pt-1">
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select" name="purchase_tax_id" id="purchase_tax_id" aria-label="Floating label select example">
                                             <!-- <option value="">Please select</option> -->
                                             <?php if(!empty($data['tax'])){
                                                foreach($data['tax'] as $row){
                                                   ?>
                                              <option <?php echo isset($value['purchase_tax_id']) && ($value['purchase_tax_id'] == $row['id']) && $type==2 ?"selected":""; ?>  value="<?= $row['id']?>"><?= $row['tax_type']?></option>
                                             <?php }
                                                } ?>
                                          </select>
                                          <label for="floatingSelectGrid">Purchase Tax</label>
                                       </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                             <option>Select Status</option>
                                             <option value="Sell">Sell</option>
                                          </select>
                                          <label for="floatingSelectGrid">Status</label>
                                       </div>
                                    </div> -->
                                    <!-- <div class="col-md-4">
                                       <div class="form-floating">
                                          <input type="text" class="form-control" name="item_description" id="item_description" placeholder="Item Description" value="<?= isset($value['item_description'])?$value['item_description']:''?>"  >
                                          <label for="item_description">Item Description</label>
                                       </div>
                                    </div> -->
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select brand_id brand_list" name="brand_id" id="brand_id" aria-label="Floating label select example">
                                             <option value="">Please select</option>
                                             <?php if(!empty($data['brand'])){
                                                foreach($data['brand'] as $row){
                                                   ?>
                                              <option <?php echo isset($value['brand_id']) && ($value['brand_id'] == $row['id']) && $type==2 ?"selected":""; ?> value="<?= $row['id']?>"><?= $row['brand_name']?></option>
                                             <?php }
                                                } ?>
                                                <option class="font-color" value="brand">Add Brand</option>
                                          </select>
                                          <label for="brand_id">Brand</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating" style="padding-top: 5px">
                                        <button type="button" class="btn" style="width:100%;" data-target="#select-modifiers-item" data-toggle="modal">Modifiers</button>
                                        <input type="hidden" class="u-modifiers" name="modifier_id" value='<?= isset($value['modifier_id'])?$value['modifier_id']:"" ?>'>
                                       </div>
                                    </div> 
                                 </div>
                                  <div class="row pt-1">
                                    <div class="col-md-12">
                                     <?= StatusInput(isset($value['status']) ? $value['status'] : '1') ?>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-4">
                                 <p class="text-bold-400">Item Image</p>
                                  
                                 <div class="row align-center">
                                    <div class="col-md-6">
                                       <div class="uploadOuter">
                                          <input type="file" name="item_image_variance" id="item_image_variance" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"  />
                                          <label for="uploadFile" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i>  Browse Files</label>
                                          <p>128 * 128 Size</p>
                                          <p>Supported upto to 25 MB</p>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <img id="imagePreview" src="<?=GetImagePath(isset($value['item_image']) && $type==2 ?$value['item_image']:'','items')?>">
                                    </div>
                                 </div>
                                  <?php $item_option = isset($data['item']['item_options']) && $type==2 ?json_decode($data['item']['item_options']):"";
                                  ?>
                                 <p class="text-bold-400 pt-1">Item Options</p>
                                 <div class="row ">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[stockable]" <?= isset($item_option->stockable) && ($item_option->stockable == 1)?"checked":""; ?> id="stockable1" value="1"  >
                                          <label for="stockable1">Stockable</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[can_sale]" id="cansale1" value="1" <?= isset($item_option->can_sale) && ($item_option->can_sale == 1)?"checked":""; ?> >
                                          <label for="cansale1">Can Sale</label> 
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[weighing_scale]" id="weighing_scale1" value="1" <?= isset($item_option->weighing_scale) && ($item_option->weighing_scale == 1)?"checked":""; ?> >
                                          <label for="weighing_scale1">Weighing Scale</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[weight_item]" id="weight_item1" value="1" <?= isset($item_option->weight_item) && ($item_option->weight_item == 1)?"checked":""; ?> >
                                          <label for="weight_item1">Weight Item</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[favourite]" id="favourite1" value="1"<?= isset($item_option->favourite) && ($item_option->favourite == 1)?"checked":""; ?> >
                                          <label for="favourite1">Favourite</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6 ">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[is_service]" id="is_service1" value="1" <?= isset($item_option->is_service) && ($item_option->is_service == 1)?"checked":""; ?> >
                                          <label for="is_service1">Is Service</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[is_recipe]" id="is_recipe1" value="1" <?= isset($item_option->is_recipe) && ($item_option->is_recipe == 1)?"checked":""; ?>  >
                                          <label for="is_recipe1">Recipe</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[is_ingredient]" id="is_ingredient1" value="1" <?= isset($item_option->is_ingredient) && ($item_option->is_ingredient == 1)?"checked":""; ?>  >
                                          <label for="is_ingredient1">Ingredient</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[can_purchase]" id="can_purchase1" value="1" <?= isset($item_option->can_purchase) && ($item_option->can_purchase == 1)?"checked":""; ?>  >
                                          <label for="can_purchase1">Can Purchase</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[pre_production]" id="pre_production1" value="1" <?= isset($item_option->pre_production) && ($item_option->pre_production == 1)?"checked":""; ?>  >
                                          <label for="pre_production1">Pre Production</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[track_expiry]" id="track_expiry1" value="1" <?= isset($item_option->track_expiry) && ($item_option->track_expiry == 1)?"checked":""; ?>  >
                                          <label for="track_expiry1">Track Expiry</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[track_serial_no]" id="track_serial_no1" value="1" <?= isset($item_option->track_serial_no) && ($item_option->track_serial_no == 1)?"checked":""; ?>  >
                                          <label for="track_serial_no1">Track Serial Number</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
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
                                             <h4 class="card-title pb-1">Variants <small class="block">Choose variable attributes for this product to create and manage SKUs and their inventory levels.</small></h4>
                                             <div class="repeater-default">
                                                <div data-repeater-list="car">
                                                   <div class="">
                                                      <table id="variant-table" class="table table-bordered VanderTable module-items-tbl">
                                                         <thead class="threadClass">
                                                            <tr>
                                                               <th></th>
                                                               <th>Product Variant</th>
                                                               <th>Attribute (e.g. Colour)</th>
                                                               <th>Action</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                          <?php if(isset($data['variantData']) && !empty($data['variantData'])){ 
                                                            foreach($data['variantData'] as $k => $v) {
                                                            $attr = json_decode($v['attribute']); 
                                                            $class = "st-tags";
                                                            if($k == 1) {
                                                              $class = "st-tags-dynamic";
                                                            } else if($k == 2) {
                                                              $class = "st-tags-3";
                                                            }
                                                            ?>
                                                            <tr class="new-row">
                                                               <td class="text-center"><?= $k+1; ?></td>
                                                               <input type="hidden" name="variant[<?= $k+1; ?>][id]" value="<?= $v['id']; ?>">
                                                               <td style="width: 20%;" class="text-left">
                                                                  <select name="variant[<?= $k+1; ?>][variant_id]" class="form-control form-select var-1 variant_data" data-type="var-<?= $k+1 ?>" id="variant_data">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if(!empty($data['variant'])){
                                                                        foreach($data['variant'] as $row){
                                                                           ?>
                                                                     <option value="<?= $row['id']?>" <?php if($v['variant_id'] == $row['id']) { echo 'selected';} ?>><?= $row['product_name']?></option>
                                                                     <?php }
                                                                        } ?>
                                                                     <option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Variants</option>
                                                                  </select>
                                                               </td>
                                                               <td class="text-left">
                                                                  <input type="text" name="variant[<?= $k+1; ?>][attributes]" class="form-control <?=$class?>" id="tag-input-<?=$k?>" value="<?=$v['attribute']?>" data-role="tagsinput" />
                                                               </td>
                                                               <td class="text-center">
                                                                  <a href="#" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>
                                                               </td>
                                                            </tr>
                                                        <?php  } 
                                                        if(count($data['variantData']) == 2) {
                                                          ?>
                                                          <tr class="new-row">
                                                               <td class="text-center">3</td>
                                                               <td style="width: 20%;">
                                                                  <select name="variant[2][variant_id]" class="form-control form-select var-3 variant_data" data-type="var-3" id="variant_data3">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if (!empty($data['variant'])) {
                                                                         foreach ($data['variant'] as $row) { ?>
                                                                     <option value="<?= $row['id'] ?>"><?= $row['product_name'] ?></option>
                                                                     <?php }
                                                                     } ?>
                                                                     <option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Variants</option>
                                                                  </select>
                                                               </td>
                                                               <td class="text-left">
                                                                  <!-- <div class="form-control"> -->
                                                                    <input type="text" name="variant[2][attributes]" data-num="3" class="form-control st-tags-3" id="tag-input-3" value="" data-role="tagsinput" />
                                                                  <!-- </div> -->
                                                               </td>
                                                               <td class="text-center">
                                                                  <a href="#" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>
                                                               </td>
                                                            </tr>
                                                          <?php
                                                        }
                                                        } else { ?>
                                                            <tr class="new-row">
                                                               <td class="text-center">1</td>
                                                               <td style="width: 20%;">
                                                                  <select name="variant[0][variant_id]" class="form-control form-select var-1 variant_data" data-type="var-1" id="variant_data">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if (!empty($data['variant'])) {
                                                                         foreach ($data['variant'] as $row) { ?>
                                                                     <option value="<?= $row['id'] ?>"><?= $row['product_name'] ?></option>
                                                                     <?php }
                                                                     } ?>
                                                                     <option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Variants</option>
                                                                  </select>
                                                               </td>
                                                               <td class="text-left">
                                                                  <!-- <div class="form-control"> -->
                                                                    <input type="text" name="variant[0][attributes]" data-num="1" class="form-control st-tags" id="tag-input" value="" data-role="tagsinput" />
                                                                  <!-- </div> -->
                                                               </td>
                                                               <td class="text-center">
                                                                  <a href="#" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>
                                                               </td>
                                                            </tr>
                                                            <tr class="new-row">
                                                               <td class="text-center">2</td>
                                                               <td style="width: 20%;">
                                                                  <select name="variant[1][variant_id]" class="form-control form-select var-2 variant_data" data-type="var-2" id="variant_data2">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if (!empty($data['variant'])) {
                                                                         foreach ($data['variant'] as $row) { ?>
                                                                     <option value="<?= $row['id'] ?>"><?= $row['product_name'] ?></option>
                                                                     <?php }
                                                                     } ?>
                                                                     <option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Variants</option>
                                                                  </select>
                                                               </td>
                                                               <td class="text-left">
                                                                  <!-- <div class="form-control"> -->
                                                                    <input type="text" name="variant[1][attributes]" data-num="2" class="form-control st-tags-dynamic" id="tag-input-2" value="" data-role="tagsinput" />
                                                                  <!-- </div> -->
                                                               </td>
                                                               <td class="text-center">
                                                                  <a href="#" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>
                                                               </td>
                                                            </tr>

                                                            <tr class="new-row">
                                                               <td class="text-center">3</td>
                                                               <td style="width: 20%;">
                                                                  <select name="variant[2][variant_id]" class="form-control form-select var-3 variant_data" data-type="var-3" id="variant_data3">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if (!empty($data['variant'])) {
                                                                         foreach ($data['variant'] as $row) { ?>
                                                                     <option value="<?= $row['id'] ?>"><?= $row['product_name'] ?></option>
                                                                     <?php }
                                                                     } ?>
                                                                     <option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Variants</option>
                                                                  </select>
                                                               </td>
                                                               <td class="text-left">
                                                                  <!-- <div class="form-control"> -->
                                                                    <input type="text" name="variant[2][attributes]" data-num="3" class="form-control st-tags-3" id="tag-input-3" value="" data-role="tagsinput" />
                                                                  <!-- </div> -->
                                                               </td>
                                                               <td class="text-center">
                                                                  <a href="#" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>
                                                               </td>
                                                            </tr>
                                                          <?php  } ?>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                                <div class="form-group overflow-hidden">
                                                   <div class="col-12">
                                                      <!-- <button  onclick="addVarient();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Variants</button> -->
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                   <table class="table table-bordered variant-item-tbl">
                                     <thead>
                                       <tr>
                                         <th>Variant name</th>
                                         <th>SKU</th>
                                         <th>Supply Price</th>
                                         <th>Markup(%)</th>
                                         <th>Retail Price</th>
                                         <th>MRP</th>
                                         <th>Enable</th>
                                         <th>Action</th>
                                       </tr>
                                      </thead>
                                      <tbody class="tag-table-body">
                                        <?php if(isset($data['variant_items']) && !empty($data['variant_items'])) {  
                                          foreach($data['variant_items'] as $k => $v) { 
                                          $name = str_replace($value['item_name'], '', $v['item_name']);
                                        ?>
                                            <tr class="item">
                                             <td style="padding-left: 10px;">
                                              <input type="hidden" name="items[<?=$k?>][id]" class="v_id" value="<?= $v['id'] ?>">
                                              <span class="exploder fa fa-angle-right" data-toggle="collapse" data-id="<?=$k?>" data-target="#cat<?=$k?>" class="accordion-toggle"></span> <span class="variant"><?= $name; ?></span>
                                              <input type="hidden" name="items[<?=$k?>][name]" class="v_name" value="<?= $name; ?>">
                                             </td>
                                             <td><input type="text" class="form-control" name="items[<?=$k?>][sku]" placeholder="SKU" value="<?= $v['sku_barcode'] ?>"></td>
                                             <td><input type="text" class="form-control" name="items[<?=$k?>][supply_price]" placeholder="Supply Price" value="<?= $v['supply_price'] ?>"></td>
                                             <td><input type="text" class="form-control" name="items[<?=$k?>][mrp_percent]" placeholder="Markup(%)" value="<?= $v['markup'] ?>"></td>
                                             <td><input type="text" class="form-control" name="items[<?=$k?>][retail_price]" placeholder="Retail Price" value="<?= $v['retail_price'] ?>"></td>
                                             <td><input type="text" class="form-control" name="items[<?=$k?>][mrp]" placeholder="MRP" value="<?= $v['mrp'] ?>"></td>
                                             <td class="text-center"><input type="checkbox" checked value="1" data-size="sm" data-color="danger" name="items[<?=$k?>][status]" class="switchery"/></td>
                                             <td class="text-center"><a href="javascript:void(0);" data-id="<?= $v['id'] ?>" class="transh-icon-color deleteRow" data-table="variant_items"><i class="fa fa-trash-o"></i></a></td>
                                           </tr>
                                           <tr id="cat<?=$k?>" class="collapse">
                                            <td colspan="8" style="padding: 1rem 1rem">
                                              <table class="table table-striped table-bordered variant-item-pr">
                                                <thead>
                                                  <tr>
                                                    <th>Store</th>
                                                    <th>Retail Price</th>
                                                    <th>Min. Retail Price</th>
                                                    <th>Current Inventory</th>
                                                    <th>Inventory Value</th>
                                                    <th>ReOrder Point</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php if(isset($v['stores'])) {
                                                    foreach($v['stores'] as $i => $j) {
                                                  ?>
                                                  <tr>
                                                    <input type="hidden" name="items[<?=$k?>][stores][<?=$i?>][id]" value="<?=$j['id']?>">
                                                    <td><input type="hidden" value="<?=$j['store_id']?>" name="items[<?=$k?>][stores][<?=$i?>][store_id]">
                                                     <input type="text" class="form-control store" name="items[<?=$k?>][stores][<?=$i?>][store_name]" placeholder="Store" value="<?=$j['store_name']?>" readonly></td>
                                                    <td><input type="text" class="form-control p-retail_price" name="items[<?=$k?>][stores][<?=$i?>][retail_price]" placeholder="Retail Price" value="<?=$j['retail_price']?>"></td>
                                                    <td><input type="text" class="form-control p-mrp" name="items[<?=$k?>][stores][<?=$i?>][mrp]" placeholder="Minimum Price" value="<?=$j['mrp']?>"></td>
                                                    <td>
                                                      <input type="text" class="form-control p-current_inventory" name="items[<?=$k?>][stores][<?=$i?>][current_inventory]" placeholder="Current Inventory" value="<?=$j['current_inventory']?>">
                                                   </td>
                                                   <td class="text-center">
                                                      <input type="text" class="form-control p-inventory_value" name="items[<?=$k?>][stores][<?=$i?>][inventory_value]" placeholder="Inventory Value" value="<?=$j['inventory_value']?>">
                                                   </td>
                                                   <td class="text-center">
                                                      <input type="text" class="form-control p-reorder_point" name="items[<?=$k?>][stores][<?=$i?>][reorder_point]" placeholder="ReOrder Point" value="<?=$j['re_order_point']?>">
                                                   </td>
                                                  </tr>
                                                <?php } } ?>
                                                </tbody>
                                              </table>
                                            </td>
                                           </tr>
                                        <?php }  } ?>
                                      </tbody>
                                   </table>
                                 </div>
                                 <table id="pr-variance-tbl" style="display: none;">
                                   <tbody></tbody>
                                 </table>
                                 <div class="col-12">
                                    <div class="form-footer">
                                        <div class="row">
                                           <div class="col-md-12 text-right">
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
               <div class="tab-pane" id="composite-item" role="tabpanel" aria-labelledby="linkIcon12-tab3" aria-expanded="false">
                  <form method="post" id="composite_item_form" name="composite_item_form">
                      <input type="hidden" name="action" id="action" value="post_items_data">
                      <input type="hidden" name="table_name" id="table_name" value="items">
                      <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                      <input type="hidden" name="item_type" id="item_type" value="3">
                      <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                           <div class="row">
                              <div class="col-md-12">
                                 <h5 class="text-bold-500">Item Price</h5>
                                 <div class="repeater-default">
                                   <div class="">
                                      <table class="table price-table" style="table-layout: fixed;">
                                         <thead class="threadClass">
                                            <tr>
                                               <th>Store</th>
                                               <th>Supply Price</th>
                                               <th>Markup</th>
                                               <th>Retail Price</th>
                                               <th><span data-toggle="tooltip" data-placement="top" title="Minimum Retail Price(%)">MRP(%)</span></th>
                                               <th><span data-toggle="tooltip" data-placement="top" title="Minimum Retail Price">MRP</span></th>
                                               <th>Current Inventory</th>
                                               <th>Inventory Value</th>
                                               <th>ReOrder Point</th>
                                            </tr>
                                         </thead>
                                         <tbody>
                                          <?php 
                                          if(!empty($data['stores'])) {
                                            foreach($data['stores'] as $k => $row) { ?>
                                            <tr class="new-row">
                                               <td>
                                                <input type="hidden" value="<?= isset($row['p_id']) && $type==3 ?$row['p_id']:''?>" name="items_pr[<?=$k;?>][id]">
                                                <input type="hidden" value="<?= $row['id']; ?>" name="items_pr[<?=$k;?>][store_id]">
                                                 <input type="text" class="form-control store" name="items_pr[<?=$k;?>][store_name]" placeholder="Store" value="<?= $row['store_name']; ?>" readonly> 
                                               </td>
                                               <td>
                                                  <input type="text" class="form-control p-supply_price" name="items_pr[<?=$k;?>][supply_price]" placeholder="Supply Price" value="<?= isset($row['supply_price']) && $type==3?$row['supply_price']:''?>">  
                                               </td>
                                               <td>
                                                  <input type="text" class="form-control p-markup" name="items_pr[<?=$k;?>][markup]" placeholder="Markup" value="<?= isset($row['markup']) && $type==3?$row['markup']:''?>">  
                                               </td>
                                               <td>
                                                  <input type="text" class="form-control p-retail_price" name="items_pr[<?=$k;?>][retail_price]" placeholder="Retail Price" value="<?= isset($row['retail_price']) && $type==3?$row['retail_price']:''?>">
                                               </td>
                                               <td class="text-center">
                                                  <input type="text" class="form-control p-mrp_percent" name="items_pr[<?=$k;?>][mrp_percent]" placeholder="Minimum Price(%)" value="<?= isset($row['mrp_percent']) && $type==3?$row['mrp_percent']:''?>">
                                               </td>
                                               <td class="text-center">
                                                  <input type="text" class="form-control p-mrp" name="items_pr[<?=$k;?>][mrp]" placeholder="Minimum Price" value="<?= isset($row['mrp']) && $type==3?$row['mrp']:''?>">
                                               </td>
                                               <td>
                                                  <input type="text" class="form-control p-current_inventory" name="items_pr[<?=$k;?>][current_inventory]" placeholder="Current Inventory" value="<?= isset($row['current_inventory']) && $type==3?$row['current_inventory']:''?>">
                                               </td>
                                               <td class="text-center">
                                                  <input type="text" class="form-control p-inventory_value" name="items_pr[<?=$k;?>][inventory_value]" placeholder="Inventory Value" value="<?= isset($row['inventory_value']) && $type==3?$row['inventory_value']:''?>">
                                               </td>
                                               <td class="text-center">
                                                  <input type="text" class="form-control p-reorder_point" name="items_pr[<?=$k;?>][reorder_point]" placeholder="ReOrder Point" value="<?= isset($row['re_order_point']) && $type==3?$row['re_order_point']:''?>">
                                               </td>
                                            </tr>
                                          <?php } } else { ?>
                                            <tr>
                                              <td style="text-align: center;" colspan="9">No Data Available</td>
                                            </tr>
                                          <?php } ?>
                                         </tbody>
                                      </table>
                                   </div>
                                 </div>
                              </div>
                              <div class="col-md-12 pt-2"></div>
                              <div class="col-8 border-right">
                                 <h5 class="text-bold-500">Item Details</h5>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Item Name" value="<?= isset($value['item_name']) && $type==3?$value['item_name']:''?>" >
                                          <label for="floatingInputGrid">Item Name</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select category_list category_id composite_category_id " name="category_id" id="composite_category_id" data-type="composite" aria-label="Floating label select example">
                                             <option value="">Please select</option>
                                             <?php if(!empty($data['category'])){
                                                foreach($data['category'] as $row){
                                                ?>
                                             <option <?php echo isset($value['category_id']) && ($value['category_id'] == $row['id']) && $type==3?"selected":""; ?> value="<?=$row['id']?>"><?=$row['category_name']?></option>
                                             <?php } } ?>
                                          <option class="font-color" value="category">Add Category</option>
                                          </select>
                                          <label for="category_id">Category</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select composite_subcategory_id" name="subcategory_id" id="composite_subcategory_id" aria-label="Floating label select example">
                                               <option value="">Please select</option>
                                             <?php if(isset($data['sub_category'])){ ?>
                                             <?php
                                                foreach($data['sub_category'] as $row){
                                                ?>
                                             <option <?php echo isset($value['subcategory_id']) && ($value['subcategory_id'] == $row['id']) && $type==3?"selected":""; ?>  value="<?=$row['id']?>"><?=$row['subcategory_name']?></option>
                                          <?php } } ?>
                                          <option class="font-color" value="subcategory">Add Subcategory</option>
                                          </select>
                                          <label for="subcategory_id">Sub Category</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row pt-1">
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <input type="text" class="form-control" name="sku_barcode" id="c-sku_barcode" placeholder="SKU/Barcode" value="<?= isset($value['sku_barcode']) && $type==3?$value['sku_barcode']:''?>" >
                                          <label for="sku_barcode">SKU</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" value="<?= isset($value['barcode']) && $type==3?$value['barcode']:''?>" >
                                          <label for="barcode">Barcode</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-floating">
                                        <input type="number" class="form-control" name="shelflife" id="shelflife" placeholder="Shelflife" value="<?= isset($value['shelflife'])?$value['shelflife']:''?>" >
                                        <label for="shelflife">Shelflife</label>
                                      </div>     
                                    </div>
                                 </div>
                                 <div class="row pt-1">
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select uom_list uom_id" name="uom_id" id="uom_id" aria-label="Floating label select example">
                                             <option value="">Please select</option>
                                             <?php if(!empty($data['uom'])){
                                                foreach($data['uom'] as $row){
                                                   ?>
                                             <option <?php echo isset($value['uom_id']) && ($value['uom_id'] == $row['id']) && $type==3?"selected":""; ?> value="<?= $row['id']?>"><?= $row['uom']?></option>
                                             <?php }
                                                } ?>
                                                <option class="font-color" value="uom">Add UOM</option>
                                          </select>
                                          <label for="uom_id">UOM</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-floating">
                                          <input type="number" class="form-control" name="pack_size" id="pack_size" placeholder="Shelflife" value="<?= isset($value['pack_size'])?$value['pack_size']:''?>">
                                          <label for="pack_size">Pack Size</label>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select tax_id tax_list" name="tax_id" id="tax_id" aria-label="Floating label select example">
                                             <!-- <option value="">Pleases select</option> -->
                                             <?php if(!empty($data['tax'])){
                                                foreach($data['tax'] as $row){
                                                   ?>
                                            <option <?php echo isset($value['tax_id']) && ($value['tax_id'] == $row['id']) && $type==3?"selected":""; ?> value="<?= $row['id']?>"><?= $row['tax_type']?></option>
                                             <?php }
                                                } ?>
                                                <option class="font-color" value="tax">Add Tax</option>
                                          </select>
                                          <label for="tax_id">Tax</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row pt-1">
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select" name="purchase_tax_id" id="purchase_tax_id" aria-label="Floating label select example">
                                             <!-- <option value="">Please sselect</option> -->
                                             <?php if(!empty($data['tax'])){
                                                foreach($data['tax'] as $row){
                                                   ?>
                                             <option <?php echo isset($value['purchase_tax_id']) && ($value['purchase_tax_id'] == $row['id']) && $type==3?"selected":""; ?>  value="<?= $row['id']?>"><?= $row['tax_type']?></option>
                                             <?php }
                                                } ?>
                                          </select>
                                          <label for="purchase_tax_id">Purchase Tax</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select brand_id brand_list" name="brand_id" id="brand_id" aria-label="Floating label select example">
                                             <option value="">Please select</option>
                                             <?php if(!empty($data['brand'])){
                                                foreach($data['brand'] as $row){
                                                   ?>
                                            <option <?php echo isset($value['brand_id']) && ($value['brand_id'] == $row['id']) && $type==3?"selected":""; ?> value="<?= $row['id']?>"><?= $row['brand_name']?></option>
                                             <?php }
                                                } ?>
                                                <option class="font-color" value="brand">Add Brand</option>
                                          </select>
                                          <label for="brand_id">Brand</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-floating" style="padding-top: 5px">
                                        <button type="button" class="btn" style="width:100%;" data-target="#select-modifiers-item" data-toggle="modal">Modifiers</button>
                                        <input type="hidden" class="u-modifiers" name="modifier_id" value='<?= isset($value['modifier_id']) && $type==3?$value['modifier_id']:"" ?>'>
                                       </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                       <div class="form-floating">
                                          <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                             <option>Select Status</option>
                                             <option value="Sell">Sell</option>
                                          </select>
                                          <label for="floatingSelectGrid">Status</label>
                                       </div>
                                    </div>  -->
                                       
                                    <!-- <div class="col-md-4">
                                       <div class="form-floating">
                                          <input type="text" class="form-control" name="item_description" id="item_description" placeholder="Item Description" value="<?= isset($value['item_description'])?$value['item_description']:''?>" >
                                          <label for="item_description">Item Description</label>
                                       </div>
                                    </div> -->
                                 </div>
                              </div>
                              <div class="col-4">
                                 <p class="text-bold-400">Item Image</p>
                                
                                 <div class="row align-center">
                                    <div class="col-md-6">
                                       <div class="uploadOuter">
                                          <input type="file" name="item_image_composite" id="item_image_composite" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"/>
                                          <label for="uploadFile" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i>  Browse Files</label>
                                          <p>128 * 128 Size</p>
                                          <p>Supported upto to 25 MB</p>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <img id="imagePreview" src="<?=GetImagePath(isset($value['item_image']) && $type==3?$value['item_image']:'','items')?>">
                                    </div>
                                 </div>
                                 <?php $item_option = isset($data['item']['item_options']) && $type==3?json_decode($data['item']['item_options']):"";
                                  ?>
                                 <p class="text-bold-400 pt-1">Item Options</p>
                                 <div class="row ">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[stockable]" <?= isset($item_option->stockable) && ($item_option->stockable == 1)?"checked":""; ?> id="stockable2" value="1"  >
                                          <label for="stockable2">Stockable</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[can_sale]" id="cansale2" value="1" <?= isset($item_option->can_sale) && ($item_option->can_sale == 1)?"checked":""; ?> >
                                          <label for="cansale2">Can Sale</label> 
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[weighing_scale]" id="weighing_scale2" value="1" <?= isset($item_option->weighing_scale) && ($item_option->weighing_scale == 1)?"checked":""; ?> >
                                          <label for="weighing_scale2">Weighing Scale</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[weight_item]" id="weight_item2" value="1" <?= isset($item_option->weight_item) && ($item_option->weight_item == 1)?"checked":""; ?>>
                                          <label for="weight_item2">Weight Item</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[favourite]" id="favourite2" value="1" <?= isset($item_option->favourite) && ($item_option->favourite == 1)?"checked":""; ?>>
                                          <label for="favourite2">Favourite</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[is_service]" id="is_service2" value="1" <?= isset($item_option->is_service) && ($item_option->is_service == 1)?"checked":""; ?> >
                                          <label for="is_service2">Is Service</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[is_recipe]" id="is_recipe2" value="1" <?= isset($item_option->is_recipe) && ($item_option->is_recipe == 1)?"checked":""; ?>  >
                                          <label for="is_recipe2">Recipe</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[is_ingredient]" id="is_ingredient2" value="1" <?= isset($item_option->is_ingredient) && ($item_option->is_ingredient == 1)?"checked":""; ?>  >
                                          <label for="is_ingredient2">Ingredient</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[can_purchase]" id="can_purchase2" value="1" <?= isset($item_option->can_purchase) && ($item_option->can_purchase == 1)?"checked":""; ?>  >
                                          <label for="can_purchase2">Can Purchase</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[pre_production]" id="pre_production2" value="1" <?= isset($item_option->pre_production) && ($item_option->pre_production == 1)?"checked":""; ?>  >
                                          <label for="pre_production2">Pre Production</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[track_expiry]" id="track_expiry2" value="1" <?= isset($item_option->track_expiry) && ($item_option->track_expiry == 1)?"checked":""; ?>  >
                                          <label for="track_expiry2">Track Expiry</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="checkbox" name="item_option[track_serial_no]" id="track_serial_no2" value="1" <?= isset($item_option->track_serial_no) && ($item_option->track_serial_no == 1)?"checked":""; ?>  >
                                          <label for="track_serial_no2">Track Serial Number</label>
                                          <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                       </div>
                                    </div>
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
                                             <p class="text-bold-400">Composite Item</p>
                                             <div class="repeater-default">
                                                <div data-repeater-list="car">
                                                   <div class="">
                                                      <table id="composite-item-table" class="table table-bordered module-items-tbl">
                                                         <thead class="threadClass">
                                                            <tr>
                                                               <th></th>
                                                               <th>Component</th>
                                                               <th>Quantity</th>
                                                               <th>Optional</th>
                                                               <th>Category</th>
                                                               <th>Action</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                                          <?php if(isset($data['compositeData']) && !empty($data['compositeData'])) {
                                                            foreach($data['compositeData'] as $k => $v) {
                                                          ?> 
                                                            <tr class="new-row">
                                                               <td class="text-center"><?= $k+1; ?></td>
                                                               <td class="text-left">
                                                                <input type="hidden" value="<?= $v['id'] ?>" name="composite[<?= $k+1; ?>][id]">
                                                                  <select name="composite[<?= $k+1; ?>][composite_item_id]" class="form-control form-select combo-<?= $k+1; ?> composite_data" data-type="combo-<?= $k+1; ?>">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if(!empty($data['itemsData'])){
                                                                        foreach($data['itemsData'] as $row){
                                                                           ?>
                                                                     <option value="<?= $row['id']?>" <?php if($v['composite_item_id'] == $row['id']) { echo 'selected';} ?>><?= $row['item_name']?></option>
                                                                     <?php }
                                                                        } ?>
                                                                     <option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Combo Items</option>
                                                                  </select>
                                                               </td>
                                                               <td>
                                                                  <input type="number" name="composite[<?= $k+1; ?>][quantity]" class="form-control" value="<?= $v['quantity'] ?>">
                                                                </td>
                                                               <td class="text-center form-group">
                                                                     <input type="checkbox" name="composite[<?= $k+1; ?>][optional]" value="1" id="optional" <?php if($v['optional'] == "1") { echo 'checked';} ?>>
                                                                     <label for="optional"></label>
                                                               </td>
                                                               <td>
                                                                  <select name="composite[<?= $k+1; ?>][category_id]" class="form-control form-select" id="">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if(!empty($data['category'])){
                                                                        foreach($data['category'] as $row){
                                                                           ?>
                                                                     <option value="<?= $row['id']?>" <?php if($v['category_id'] == $row['id']) { echo 'selected';} ?>><?= $row['category_name']?></option>
                                                                     <?php }
                                                                        } ?>
                                                                  </select>
                                                               </td>
                                                               <td class="text-center"><a href="javascript:void(0);" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>
                                                               </td>
                                                            </tr>
                                                          <?php } } else { ?>
                                                            <tr class="new-row">
                                                               <td class="text-center">1</td>
                                                               <td class="text-left">
                                                                  <select name="composite[0][composite_item_id]" class="form-control form-select combo-1 composite_data" data-type="combo-1" id="composite_data">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if(!empty($data['itemsData'])){
                                                                        foreach($data['itemsData'] as $row){
                                                                           ?>
                                                                     <option value="<?= $row['id']?>"><?= $row['item_name']?></option>
                                                                     <?php }
                                                                        } ?>
                                                                     <option value="add" class="storeColor"><i class="fa fa-plus"></i>Add New Combo Items</option>
                                                                  </select>
                                                               </td>
                                                               <td>
                                                                  <input type="number" name="composite[0][quantity]" class="form-control">
                                                                </td>
                                                               <td class="text-center form-group">
                                                                     <input type="checkbox" name="composite[0][optional]" value="1" id="optional">
                                                                     <label for="optional"></label>
                                                               </td>
                                                               <td>
                                                                  <select name="composite[0][category_id]" class="form-control form-select" id="">
                                                                     <option value="0">Click to select item</option>
                                                                     <?php if(!empty($data['category'])){
                                                                        foreach($data['category'] as $row){
                                                                           ?>
                                                                     <option value="<?= $row['id']?>"><?= $row['category_name']?></option>
                                                                     <?php }
                                                                        } ?>
                                                                  </select>
                                                               </td>
                                                               <td class="text-center"><a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>
                                                               </td>
                                                            </tr>
                                                          <?php } ?>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                                <div class="form-group overflow-hidden">
                                                   <div class="col-12">
                                                      <button  onclick="addCompositeItem();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Composite Item</button>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="form-footer">
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
   </div>
</div>
<!-- Model Start -->
<div class="modal fade text-left" id="select-modifiers-item" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Select Modifiers</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="set-modifier-form" action="">
          <div class="modal-body">
             <div class="row">
                <?php if(isset($data['modifier']) && !empty($data['modifier'])) { ?>
                <?php foreach($data['modifier'] as $val) { ?>
                 <div class="col-md-4">
                   <div class="form-group">
                      <input type="checkbox" class="modifier-input" name="modifiers[]" id="<?= $val['id']; ?>" value="<?= $val['id']; ?>" <?= isset($modifiers) && in_array($val['id'],$modifiers)?"checked":""; ?> >
                      <label for="<?= $val['id']; ?>"><?= $val['modifier_item_name']; ?></label>
                   </div>
                </div>
                <?php } } ?>
             </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button type="button" class="btn btn-info set-modifiers"> <i class="fa fa-file-o"></i>&nbsp;Save</button>
          </div>
          </form>
      </div>
   </div>
</div>

<div class="modal fade text-left" id="add-new-variant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Add New Variants</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="variant_form" name="variant_form">
            <input type="hidden" name="action" id="action" value="post_items_data">
            <input type="hidden" name="table_name" id="table_name" value="variant_master">
            <input type="hidden" name="id" id="id" value="">

            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="variant_name" id="variant_name" placeholder="Product Variant" value="" >
                        <label for="variant_name">Product Variant</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="btnSubmitVariant" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade text-left" id="add-new-composite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Add New Combo Items</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="composite_form" name="composite_form">
            <input type="hidden" name="action" id="action" value="post_items_data">
            <input type="hidden" name="table_name" id="table_name" value="composite_master">
            <input type="hidden" name="id" id="id" value="">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="variant_name" id="variant_name" placeholder="Product Variant" value="" >
                        <label for="variant_name">Product Name</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="btnSubmitVariant" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Model End-->

<!-- Standard Item -->
<!-- Add New Category Model Start -->         
<div class="modal fade text-left " id="add-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
       <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
             <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18">Add Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body">
                <form method="post" id="model_category_form" name="model_category_form">
                <input type="hidden" name="action" id="action" value="post_items_data">
                <input type="hidden" name="table_name" id="table_name" value="categories">
                <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                <input type="hidden" name="status" id="status" value="1">
                <div class="row">
                   <div class="col-md-6 ">
                      <div class="form-floating">
                         <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category Name" value="" >
                         <label for="floatingInputGrid">Category Name</label>
                      </div>
                   </div>
                   <div class="col-md-6 ">
                      <div class="form-floating">
                         <input type="text" class="form-control" name="prefix" id="prefix" placeholder="SKU Prefix" value="" >
                         <label for="floatingInputGrid">SKU Prefix</label>
                      </div>
                   </div>
                   <div class="col-md-6 pt-1">
                      <div class="form-floating">
                         <input type="text" class="form-control" name="custom_report" id="custom_report" placeholder="Category Name" value="" >
                         <label for="floatingInputGrid">Custom Reports</label>
                      </div>
                   </div>
                </div>
                <br>
                   <section id="form-repeater"></section>
             
             <div class="modal-footer">
                 <button  type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default_new"><i class="fa fa-close"></i> Cancel</button>
                 <button  type="submit" id="addcategory" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
             </div> 
             </form>
          </div>
       </div>
    </div>
</div>
      <!-- Add New Category Model End-->

      <!--  -->
  <div class="modal fade text-left" id="add-subcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18">Add Subcategory</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="model_subcategory_form" name="model_subcategory_form">
                    <input type="hidden" name="action" id="action" value="post_items_data" />
                    <input type="hidden" name="table_name" id="table_name" value="subcategories" />
                    <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>" />
                    <input type="hidden" name="status" id="status" value="1" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="hidden" name="category_id" id="set-category-id">
                                <input type="text" class="form-control" name="subcategory_name" id="subcategory_name" placeholder="Subcategory Name" value="" />
                                <label for="floatingInputGrid">Subcategory Name</label>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default_new"><i class="fa fa-close"></i> Cancel</button>
                        <button type="submit" id="addcategory" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

      <!-- Add New UOM Model Start -->
<div class="modal fade text-left" id="add-uom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Add UOM</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="model_uom_form" name="model_uom_form">
            <input type="hidden" name="action" id="action" value="post_items_data">
            <input type="hidden" name="table_name" id="table_name" value="uom_master">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="status" id="status" value="1">
            <div class="modal-body">
               <div class="row">
                   <div class="col-md-6 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="formal_name" id="formal_name" placeholder="UOM" value="" >
                        <label for="uom">Formal Name</label>
                     </div>
                  </div>
                  <div class="col-md-6 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="uom" id="uom" placeholder="UOM" value="" >
                        <label for="uom">Add UOM</label>
                     </div>
                  </div>
               </div><br>
               <div class="row">
                   <div class="col-md-6 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="decimal_point" id="decimal_point" placeholder="Decimal Point" value="" >
                        <label for="uom">Decimal Point</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="adduom" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
      <!-- Add New UOM Model End -->

<!-- Add New Tax Model Start -->
<div class="modal fade text-left" id="add-tax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Add Tax</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="model_tax_form" name="model_tax_form">
            <input type="hidden" name="action" id="action" value="post_items_data">
            <input type="hidden" name="table_name" id="table_name" value="tax_master">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="status" id="status" value="1">
            <div class="modal-body">
               <div class="row">
                   <div class="col-md-6 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="tax_type" id="tax_type" placeholder="Tax" value="" >
                        <label for="tax">Tax</label>
                     </div>
                  </div>
                  <div class="col-md-6 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="tax_rate" id="tax_rate" placeholder="Rate" value="" >
                        <label for="tax_rate">Rate</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="addtax" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Add New Tax Model End -->

<!-- Add New Brand Model Start -->
<div class="modal fade text-left" id="add-brand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Add Brand</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="model_brand_form" name="model_brand_form">
            <input type="hidden" name="action" id="action" value="post_items_data">
            <input type="hidden" name="table_name" id="table_name" value="brandmasters">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="status" id="status" value="1">
            <div class="modal-body">
               <div class="row">
                   <div class="col-md-12 ">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Brand Name" value="" >
                        <label for="tax">Brand Name</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="addbrand" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Add New Brand Model End -->

<!-- Add New Modifier Model Start -->
<div class="modal fade text-left" id="add-modifier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Add Modifier</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="model_modifier_form" name="model_modifier_form">
            <input type="hidden" name="action" id="action" value="post_items_data">
            <input type="hidden" name="table_name" id="table_name" value="modifiers">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="status" id="status" value="1">
            <div class="modal-body">
              <div class="row">
               <div class="col-md-6">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-floating">
                           <input type="text" class="form-control" name="name" id="name"  placeholder="name" >
                           <label for="name">Name</label>
                        </div>
                     </div>
                     <!--<div class="col-md-3">-->
                     <!--   <div class="form-group">-->
                     <!--      <input type="checkbox" id="is_Active" name="is_active" >-->
                     <!--      <label for="is_Active">Is Active</label>-->
                     <!--   </div>-->
                     <!--</div>-->
                  </div>
                 
                  <div class="row pt-1">
                     <div class="col-md-6">
                         <div class="form-floating">
                           <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity">
                           <label for="quantity">Quantity</label>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="number" class="form-control" name="group" id="group" placeholder="Group" >
                           <label for="group">Group</label>
                        </div>
                       </div>
                       
                  </div>
               </div>
               <div class="col-md-6">
                   <div class="row">
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="text" class="form-control" name="total_rate" id="total_rate" placeholder="total_rate">
                           <label for="total_rate">Total Rate</label>
                        </div>
                        </div>
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="text" class="form-control" name="unit_rate" id="unit_rate" placeholder="Unit Rate"  >
                           <label for="unit_rate">Unit Rate</label>
                        </div>
                        </div>
                  </div>
                  <div class="row pt-1">
                              <div class="col-md-12" style="top: 15px;">
                                  <?= StatusInput(1);?>
                          
                                 </div>
                             
                           </div>
               </div>
            </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="addmodifier" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Add New Modifier Model End -->