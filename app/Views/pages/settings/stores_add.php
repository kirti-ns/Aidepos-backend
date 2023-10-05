<div class="app-content content">
<div class="content-wrapper">
<?= view('includes/breadcrumb.php');?> 
<div class="card card-content collapse show">
   <div class="card-body card-dashboard">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-content collapse show">
                  <div class="card-body card-dashboard" >
                     <?php $value = isset($data['stores'])?$data['stores']:"";?>
                    <form method="post" id="store_form" name="store_form">
                        <input type="hidden" name="action" id="action" value="post-store-data">
                        <input type="hidden" name="table_name" id="table_name" value="stores">
                        <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control" name="store_name" id="store_name" placeholder="Store Name" value="<?= isset($value['store_name'])?$value['store_name']:''?>" >
                                 <label for="floatingSelectGrid">Store Name</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control"  name="phone" id="phone" placeholder="Phone" value="<?= isset($value['phone'])?$value['phone']:''?>" style="height: 50px;">
                                 <!-- <label for="floatingSelectGrid">Phone*</label> -->
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control" name="tax_no" id="tax_no"  placeholder="Tax No" value="<?= isset($value['tax_no'])?$value['tax_no']:''?>" >
                                 <label for="floatingSelectGrid">Tax No</label>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?= isset($value['address'])?$value['address']:''?>" >
                                 <label for="floatingSelectGrid">Address</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control"  name="zip" id="zip"  placeholder="ZIP" value="<?= isset($value['zip'])?$value['zip']:''?>" >
                                 <label for="floatingSelectGrid">ZIP</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control"  name="city" id="city"  placeholder="City" value="<?= isset($value['city'])?$value['city']:''?>" >
                                 <label for="floatingSelectGrid">City</label>
                              </div>
                           </div>
                        </div>
                        <br>
                        <b>Features</b>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="media mt-1">
                                 <div class="pr-2">
                                    <img src="<?= base_url() ?>/public/app-assets/icons/order_option.png"> 
                                 </div>
                                 <div class="media-body">
                                    <p class="text-bold-600 m-0">Order Options</p>
                                    <p class="font-small-2 text-muted m-0">Mark Order as dine in,takeout or for delivery.</p>
                                 </div>
                              </div>
                           </div>
                           <?php
                           if(isset($data['stores'])){
                              
                           $value = $data['stores'];
                           $features = json_decode($value['features']);
                           }
                           ?>
                           <div class="col-md-6">
                              <div class="mt-15">
                                 <input type="checkbox" data-size="sm" data-color="danger" name="features[order_option]" <?= isset($features->order_option) && ($features->order_option == 1)?'checked':''?>  value="1" id="order_option" class="switchery"/>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="media mt-1">
                                 <div class="pr-2">
                                    <img src="<?= base_url()?>/public/app-assets/icons/table_option.png"> 
                                 </div>
                                 <div class="media-body">
                                    <p class="text-bold-600 m-0">Table Options</p>
                                    <p class="font-small-2 text-muted m-0">Auto send email receipt to customer if email available</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="mt-15">
                                 <input type="checkbox" data-size="sm" data-color="danger" name="features[table_option]" value="1" id="table_option" class="switchery" <?= isset($features->table_option) && ($features->table_option == 1)?'checked':''?>/>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="media mt-1">
                                 <div class="pr-2">
                                    <img src="<?= base_url()?>/public/app-assets/icons/track_guest.png"> 
                                 </div>
                                 <div class="media-body">
                                    <p class="text-bold-600 m-0">Track Guest</p>
                                    <p class="font-small-2 text-muted m-0">Track Number of guests for each other</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="mt-15">
                                 <input type="checkbox" data-size="sm" data-color="danger" name="features[track_guest]" value="1" id="track_guest" class="switchery" <?= isset($features->track_guest) && ($features->track_guest == 1)?'checked':''?>/>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="media mt-1">
                                 <div class="pr-2">
                                    <img src="<?= base_url()?>/public/app-assets/icons/kot.png"> 
                                 </div>
                                 <div class="media-body">
                                    <p class="text-bold-600 m-0">KOT</p>
                                    <p class="font-small-2 text-muted m-0">Send orders to kitchen printer or display</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="mt-15">
                                 <input type="checkbox" data-size="sm" data-color="danger" name="features[kot]" value="1" id="kot" class="switchery" <?= isset($features->kot) && ($features->kot == 1)?'checked':''?> />
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                    <option >KOT then Bill then Payment</option>
                                    <option value="">Beguiled  and Dem</option>
                                    <option value="">Two</option>
                                    <option value="3">Three</option>
                                 </select>
                                 <label for="floatingSelectGrid">Dine-in KOT Types</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                    <option >KOT then Bill then Payment</option>
                                    <option value="">Beguiled  and Dem</option>
                                    <option value="">Two</option>
                                    <option value="3">Three</option>
                                 </select>
                                 <label for="floatingSelectGrid">Take Away KOT Types</label>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="media mt-1">
                                 <div class="pr-2">
                                    <img src="<?= base_url()?>/public/app-assets/icons/tax.png"> 
                                 </div>
                                 <div class="media-body">
                                    <p class="text-bold-600 m-0">Tax</p>
                                    <p class="font-small-2 text-muted m-0">Enable/Disable tax for the store</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="mt-15">
                                 <input type="checkbox" data-size="sm" data-color="danger" name="features[tax]" value="1" id="tax" class="switchery" <?= isset($features->tax) && ($features->tax == 1)?'checked':''?>/>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="media mt-1">
                                 <div class="pr-2">
                                    <img src="<?= base_url()?>/public/app-assets/icons/finish.png"> 
                                 </div>
                                 <div class="media-body">
                                    <p class="text-bold-600 m-0">Finish To Complete Order</p>
                                    <p class="font-small-2 text-muted m-0">Complete a order manually</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="mt-15">
                                 <input type="checkbox" data-size="sm" data-color="danger" name="features[finish_complete_order]" value="1" id="finish_complete_order" class="switchery" <?= isset($features->finish_complete_order) && ($features->finish_complete_order == 1)?'checked':''?>/>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="media mt-1">
                                 <div class="pr-2">
                                    <img src="<?= base_url()?>/public/app-assets/icons/active.png"> 
                                 </div>
                                 <div class="media-body">
                                    <p class="text-bold-600 m-0">Active</p>
                                    <p class="font-small-2 text-muted m-0">To activate/deactivate this store</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="mt-15">
                                 <input type="checkbox" data-size="sm" data-color="danger" name="features[store_active]" value="1" id="store_active" class="switchery"/>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                             <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                           </div>
                           <div class="col-md-6 text-right">
                             <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                           </div>
                        </div>
                    </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>