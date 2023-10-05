<style type="text/css">
  span.main-item > span.select2-selection__rendered {
    line-height: 60px!important;
  }
  span .main-item {
    height: 50px!important;
}
</style>
<div class="app-content content">
   <div class="content-wrapper">
      <?= view('includes/breadcrumb.php');?> 
      <div class="content-body">
        <form method="post" id="production_form" name="production_form">       
          <div class="card">
            <div class="card-body">
                <?php $items = json_decode($data['items']);
                      $ingredients = json_decode($data['ingredients']); ?>
                <input type="hidden" name="action" id="action" value="post_data_inventory">
                <input type="hidden" name="table_name" id="table_name" value="production">
                <input type="hidden" name="id" id="id" value="">
                <div class="row">
                  <div class="col-md-4">
                     <div class="form-floating">
                        <input type="text" class="form-control" name="production_no" value="<?= $data['production_no']; ?>" readonly>
                        <label for="floatingSelectGrid">Production No*</label>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-floating">
                        <select class="form-select pr-items" id="item" name="item_id" aria-label="Floating label select example">
                           <option value="">Select</option>
                           <?php 
                              if(!empty($items)) {
                              foreach($items as $row) { ?>
                                <option value="<?= $row->id?>"><?=$row->item_name?> </option>
                            <?php } } ?>
                        </select>
                        <label for="floatingSelectGrid">Item*</label>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-floating">
                          <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity">
                          <label for="quantity">Quantity*</label>
                     </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-4">
                     <div class="form-floating">
                        <select  class="form-select" name="store_id" id="store" aria-label="Floating label select example" value="">
                           <option value="">Select</option>
                           <?php 
                              if(!empty($data['store'])) {
                              foreach($data['store'] as $row) { ?>
                                <option value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                            <?php } } ?>
                        </select>
                        <label for="floatingInputGrid">Store</label>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-floating">
                        <input type="date" class="form-control" id="date" name="date" placeholder="Date">
                        <label for="floatingInputGrid">Date</label>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-floating">
                        <input type="narration" class="form-control" id="narration" name="narration" placeholder="Narration">
                        <label for="floatingInputGrid">Narration</label>
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
                                          <table id="production-tbl" class="table table-bordered">
                                             <thead class="threadClass">
                                                <tr>
                                                   <th>S/N</th>
                                                   <th>Item Name</th>
                                                   <th>Price</th>
                                                   <th>Qty</th>
                                                   <th>Action</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                 <tr class="new-row">
                                                 <td class="text-center">1</td>
                                                 <td><select class="form-control form-select item-add items-pr-1" name="items[0][item_id]">
                                                   <option value="">Please Select</option>
                                                   <?php foreach($ingredients as $row){ ?>
                                                    <option value="<?= $row->id?>"><?= $row->item_name?></option>
                                                   <?php } ?>
                                                 </select></td>
                                                 <td><input class="form-control selling_price" type="number" name="items[0][selling_price]" id=""></td>
                                                 <td><input class="form-control" type="number" name="items[0][quantity]" value="1" id="qty"  ></td>
                                                 <td></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                    <div class="form-group overflow-hidden">
                                       <div class="col-12">
                                          <button  onclick="addProductionField();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
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