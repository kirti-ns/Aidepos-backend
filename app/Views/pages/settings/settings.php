<?php @include('<?= base_url()?>/includes/header.php') ?>
      <div class="app-content content">
      <div class="content-wrapper">
         <?= view('includes/breadcrumb.php');?> 
         <div class="content-body">
            <div class="row">
               <!-- Icon Tab with bottom line -->
               <div class="col-xl-12 col-lg-12">
                  <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                    <?php if(isset($data['permission']->edit_general_settings) && $data['permission']->edit_general_settings == 1) { ?>
                     <li class="nav-item">
                        <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#general" aria-controls="activeIcon12" aria-expanded="true">General</a>
                     </li>
                   <?php } ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#features" aria-controls="linkIcon12" aria-expanded="false">Features</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#subscriptions" aria-controls="linkIcon12" aria-expanded="false">Subscriptions</a>
                     </li>
                     <?php if(isset($data['permission']->payment_types) && $data['permission']->payment_types == 1) { ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#payment" aria-controls="linkIcon12" aria-expanded="false">Payment Types</a>
                     </li>
                     <?php } ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#receipt" aria-controls="linkIcon12" aria-expanded="false">Receipt</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#weighing_scale" aria-controls="linkIcon12" aria-expanded="false">Weighing Scale</a>
                     </li>
                     <?php if(isset($data['permission']->tax) && $data['permission']->tax == 1) { ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#tax" aria-controls="linkIcon12" aria-expanded="false">Taxes</a>
                     </li>
                     <?php } ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#aggregator" aria-controls="linkIcon12" aria-expanded="false">Aggregator</a>
                     </li>
                     <?php if(isset($data['permission']->store_terminal) && $data['permission']->store_terminal == 1) { ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#stores" aria-controls="linkIcon12" aria-expanded="false">Stores</a>
                     </li>
                     <?php } if(isset($data['permission']->location) && $data['permission']->location == 1) { ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#location" aria-controls="linkIcon12" aria-expanded="false">Location</a>
                     </li>
                     <?php } if(isset($data['permission']->store_terminal) && $data['permission']->store_terminal == 1) { ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#terminals" aria-controls="linkIcon12" aria-expanded="false">Terminals</a>
                     </li>
                     <?php } if(isset($data['permission']->employees) && $data['permission']->employees == 1) { ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#employees" aria-controls="linkIcon12" aria-expanded="false">Employees</a>
                     </li>
                     <?php } if(isset($data['is_super_user']) && $data['is_super_user'] == "1") { ?>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#roles" aria-controls="linkIcon12" aria-expanded="false">Roles</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#currency" aria-controls="linkIcon12" aria-expanded="false">Currency</a>
                     </li>
                     <?php } ?>
                  </ul>
               </div>
            </div>
            <div class="tab-content ">
               <!-- General start -->
              <?php if(isset($data['permission']->edit_general_settings) && $data['permission']->edit_general_settings == 1) { ?>
              <div role="tabpanel" class="tab-pane active show" id="general" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
                 <div class="card card-content collapse show">
                    <div class="card-body card-dashboard">
                          <div class="row">
                             <div class="col-12">
                                <div class="card">
                                   <div class="card-content collapse show">
                                      <div class="card-body card-dashboard" >
                                        <form method="post" id="general_form" name="general_form">
                                          <input type="hidden" name="action" id="action" value="post_data_settings">
                                          <input type="hidden" name="table_name" id="table_name" value="general">
                                          <input type="hidden" name="id" id="general_id" value="">
                                          <div class="row">
                                            <div class="col-md-3">
                                              <div class="form-floating">
                                                <select class="form-select" name="store_id" id="general-store_id" aria-label="Floating label select example">
                                                    <option value="">Please select</option>
                                                    <?php if(!empty($data['stores'])){
                                                       foreach($data['stores'] as $row){
                                                          ?>
                                                    <option value="<?= $row['id']?>"><?= $row['store_name']?></option>
                                                    <?php }
                                                       } ?>
                                                 </select>
                                                 <label for="floatingSelectGrid">Store</label>
                                              </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="form-floating">
                                                   <select class="form-select" name="currency_id" id="currency_id" aria-label="Floating label select example">
                                                      <option value="">Please select</option>
                                                      <?php if(!empty($data['currency'])){
                                                         foreach($data['currency'] as $row){
                                                            ?>
                                                      <option value="<?= $row['id']?>"><?= $row['currency_code'].' - '.$row['currency_name']?></option>
                                                      <?php }
                                                         } ?>
                                                   </select>
                                                   <label for="floatingSelectGrid">Currency</label>
                                                </div>
                                             </div>
                                            <!-- <div class="col-md-3">
                                              <div class="form-floating">
                                                <select class="form-select" name="tax_id" id="tax_id" aria-label="Floating label select example">
                                                    <option value="">Please select</option>
                                                    <?php if(!empty($data['tax'])){
                                                       foreach($data['tax'] as $row){
                                                          ?>
                                                    <option value="<?= $row['id']?>"><?= $row['tax_type']?></option>
                                                    <?php }
                                                       } ?>
                                                 </select>
                                                 <label for="floatingSelectGrid">Tax Type</label>
                                              </div>
                                            </div> -->
                                            <div class="col-md-3">
                                              <div class="form-floating">
                                                 <input type="time" class="form-control" id="opening_hour" name="opening_hour" placeholder="Opening Hour" value="" >
                                                 <label for="floatingSelectGrid">Opening Hour</label>
                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                 <input type="time" class="form-control" id="closing_hour" name="closing_hour"placeholder="Closing Hour" value="" >
                                                 <label for="floatingSelectGrid">Closing Hour</label>
                                              </div>
                                            </div>
                                            <!-- <div class="col-md-3">
                                              
                                            </div> -->
                                          </div>
                                          <br>
                                          <b>Rounding</b>
                                          <div class="row">
                                             <div class="col-md-3">
                                                <div class="form-floating">
                                                  <input type="text" class="form-control" id="rounding_to" name="rounding_to" placeholder="Roundig To" value="" >
                                                   <label for="floatingSelectGrid">Rounding To</label>
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-floating">
                                                   <input type="text" class="form-control" id="middle_point" name="middle_point" placeholder="Middle Point" value="" >
                                                   <label for="floatingSelectGrid">Middle Point</label>
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-floating">
                                                  <input type="text" class="form-control" id="from_email" name="from_email" placeholder="From Email" value="" >
                                                   <label for="floatingSelectGrid">From Email</label>
                                                </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="form-floating">
                                                  <input type="number" class="form-control" id="layby_deposit_per" name="layby_deposit_per" placeholder="Layby Deposit %" value="">
                                                   <label for="floatingSelectGrid">Layby Deposit(%)</label>
                                                </div>
                                              </div>
                                          </div> <br/>
                                          <div class="row">
                                             <div class="col-md-3">
                                                <div class="form-floating">
                                                  <select class="form-select" id="layby_source_location" name="layby_source_location">
                                                    <option>Please select</option>
                                                  </select>
                                                   <label for="floatingSelectGrid">Layby Source Location</label>
                                                </div>
                                              </div>
                                          </div> <br>
                                          <i class="feather ft-alert-circle"></i>   
                                          If bill amount is 10.45 its rounded to 10.50 and bill amount of 10.55 rounded to 11.00
                                          <br><br>

                                      <div class="row">
                                         <div class="col-md-6">
                                        <div class="media mt-1">
                                            <div class="pr-2">
                                                <img src="<?= base_url()?>/public/app-assets/icons/barcode.png">
                                            </div>
                                            <div class="media-body">
                                                <p class="text-bold-600 m-0">Barcode Auto Generation</p>
                                                 
                                                <p class="font-small-2 text-muted m-0">Auto generate Barcode/SKU For Newly added items/Variants</p>
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="mt-15">
                                         <input type="checkbox" data-size="sm" data-color="danger" name="general_features[barcode_generation]"  id="barcode_generation" class="switchery" >
                                        </div>
                                     </div>
                                        </div>
                                         <br>
                                         <b>General Features</b><br><br>
                                         <div class="row">
                                         <div class="col-md-6">
                                        <div class="media mt-1">
                                            <div class="pr-2">
                                               <img src="<?= base_url()?>/public/app-assets/icons/tax.png">
                                            </div>
                                            <div class="media-body">
                                                <p class="text-bold-600 m-0">Included Tax</p>
                                                 
                                                <p class="font-small-2 text-muted m-0">On adding items Retail price entering Including Tax</p>
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="mt-15">
                                          <input type="checkbox" data-size="sm" data-color="danger" name="general_features[included_tax]" id="included_tax" class="switchery"/>
                                        </div>
                                     </div>
                                        </div>
                                         <br>
                                         <div class="row">
                                         <div class="col-md-6">
                                        <div class="media mt-1">
                                            <div class="pr-2">
                                                <img src="<?= base_url()?>/public/app-assets/icons/rounding.png">
                                            </div>
                                            <div class="media-body">
                                                <p class="text-bold-600 m-0">Rounding</p>
                                                 
                                                <p class="font-small-2 text-muted m-0">Automatic bill amount rounding based on given rules</p>
                                            </div>
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="mt-15">
                                         <input type="checkbox" data-size="sm" data-color="danger" class="switchery" name="general_features[rounding]"  id="rounding"/>
                                        </div>
                                     </div>
                                        </div>
                                        <br>
                                      <div class="form-footer text-right">
                                         <?= SubmitButton();?>
                                      </div>
                                   </form>
                                       
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                    </div>
                 </div>
              </div>
              <?php } ?>
               <!-- General End -->
               <!-- Features Start -->
               <div class="tab-pane" id="features" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                       <div class="row">
                                       <div class="col-md-6">
                                      <div class="media mt-1">
                                          <div class="pr-2">
                                              <img src="<?= base_url()?>/public/app-assets/icons/shifts.png"> 
                                          </div>
                                          <div class="media-body">
                                              <p class="text-bold-300 m-0">Shifts</p>
                                               
                                              <p class="font-small-2 text-muted m-0">Track cash that goes in and out of your drawers</p>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="mt-15">
                                        <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" checked/>
                                      </div>
                                   </div>
                                      </div>
                                       <br>
                                    
                                    <div class="row">
                                       <div class="col-md-6">
                                      <div class="media mt-1">
                                          <div class="pr-2">
                                              <img src="<?= base_url()?>/public/app-assets/icons/customers_loyalty.png"> 
                                          </div>
                                          <div class="media-body">
                                              <p class="text-bold-300 m-0">Customer Loyalty</p>
                                               
                                              <p class="font-small-2 text-muted m-0">A % of the purchase amount credit to points account of the customer</p>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="mt-15">
                                        <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" unchecked/>
                                      </div>
                                   </div>
                                      </div>
                                      <br>
                                    
                                     <div class="row">
                                       <div class="col-md-6">
                                      <div class="media mt-1">
                                          <div class="pr-2">
                                             <img src="<?= base_url()?>/public/app-assets/icons/online_sale.png"> 
                                          </div>
                                          <div class="media-body">
                                              <p class="text-bold-300 m-0">Online Sale</p>
                                               
                                              <p class="font-small-2 text-muted m-0">Enable to sale your product through integrated e-commerce</p>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="mt-15">
                                        <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" unchecked/>
                                      </div>
                                   </div>
                                      </div>
                                      <br>
                                       <div class="row">
                                       <div class="col-md-6">
                                      <div class="media mt-1">
                                          <div class="pr-2">
                                              <img src="<?= base_url()?>/public/app-assets/icons/weighing_scale.png"> 
                                          </div>
                                          <div class="media-body">
                                              <p class="text-bold-300 m-0">Weighing Scale</p>
                                               
                                              <p class="font-small-2 text-muted m-0">Enable barcode weighing scale</p>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="mt-15">
                                        <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" checked/>
                                      </div>
                                   </div>
                                      </div>
                                      <br>

                                    <div class="row">
                                       <div class="col-md-6">
                                      <div class="media mt-1">
                                          <div class="pr-2">
                                              <img src="<?= base_url()?>/public/app-assets/icons/low_stock.png">
                                          </div>
                                          <div class="media-body">
                                              <p class="text-bold-300 m-0">Low Stock Notification</p>
                                               
                                              <p class="font-small-2 text-muted m-0">Get daily email on items that are lower than your reorder point</p>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="mt-15">
                                        <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" checked/>
                                      </div>
                                   </div>
                                      </div>
                                      <br>
                                     <div class="row">
                                       <div class="col-md-6">
                                      <div class="media mt-1">
                                          <div class="pr-2">
                                             <img src="<?= base_url()?>/public/app-assets/icons/tip.png">
                                          </div>
                                          <div class="media-body">
                                              <p class="text-bold-300 m-0">Tip</p>
                                               
                                              <p class="font-small-2 text-muted m-0">Waiter or captain tip option</p>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="mt-15">
                                        <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" unchecked/>
                                      </div>
                                   </div>
                                      </div>
                                      <br>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="media mt-1">
                                              <div class="pr-2">
                                                    <img src="<?= base_url()?>/public/app-assets/icons/gift_cards.png"> 
                                              </div>
                                              <div class="media-body">
                                                  <p class="text-bold-300 m-0">Gift</p>
                                                   
                                                  <p class="font-small-2 text-muted m-0">Prepaid gift card management and redeem</p>
                                              </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="mt-15">
                                            <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" checked/>
                                          </div>
                                       </div>
                                    </div>
                                     <?php if(isset($data['permission']->clear_inventory) && $data['permission']->clear_inventory == 1) { ?>
                                      <br/><br/>
                                      <b>Stock & Transaction Clearance</b>
                                      <div class="row mt-1">
                                        <div class="col-md-3">
                                          <input type="date" name="s_t_date" id="s-t-date" class="form-control">
                                        </div>
                                      </div>
                                      <div class="row mt-1">
                                        <div class="col-md-6">
                                          <div class="media mt-1">
                                            <div class="pr-2">
                                              <img src="<?=base_url()?>/public/app-assets/icons/tick.png">
                                            </div>
                                            <div class="media-body">
                                                <p class="text-bold-300 m-0">Clear Stock</p>
                                                 
                                                <p class="font-small-2 text-muted m-0">Clear Stock only (Transactions will not be affected)</p>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                           <div class="mt-15">
                                            <button class="btn btn-info clear-s-t" data-type="1" style="height:32px;">Clear</button>
                                          </div>
                                       </div>
                                      </div>
                                      <div class="row mt-1">
                                        <div class="col-md-6">
                                          <div class="media mt-1">
                                            <div class="pr-2">
                                              <img src="<?=base_url()?>/public/app-assets/icons/tick.png">
                                            </div>
                                            <div class="media-body">
                                                <p class="text-bold-300 m-0">Clear Transactions</p>
                                                 
                                                <p class="font-small-2 text-muted m-0">Clear Transactions only (Stock will not be affected)</p>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                           <div class="mt-15">
                                            <button class="btn btn-info clear-s-t" data-type="2" style="height:32px;">Clear</button>
                                          </div>
                                       </div>
                                      </div>
                                      <div class="row mt-1">
                                        <div class="col-md-6">
                                          <div class="media mt-1">
                                            <div class="pr-2">
                                              <img src="<?=base_url()?>/public/app-assets/icons/tick.png">
                                            </div>
                                            <div class="media-body">
                                                <p class="text-bold-300 m-0">Clear Stock and Transactions</p>
                                                 
                                                <p class="font-small-2 text-muted m-0">Clear Both Stock & Transactions (Everything goes to Zero)</p>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                           <div class="mt-15">
                                            <button class="btn btn-info clear-s-t" data-type="3" style="height:32px;">Clear</button>
                                          </div>
                                       </div>
                                      </div>
                                      <?php } ?>
                                      </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
               <!-- Features End -->
              <!-- Subscriptions Start -->
               <div class="tab-pane" id="subscriptions" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
                  
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                          <div class="media mt-1">
                                         <div class="pr-2">
                                             &nbsp;&nbsp;&nbsp;<img class="brand-logo admin-logo" alt="robust admin logo" src="<?= base_url()?>/public/app-assets/images/logo/logo.png">
                                          </div>
                                          <div class="media-body">
                                              <p class="text-bold-600 m-0">Aidepos Pro USD
                                              <p class="font-small-2 text-muted m-0">Billed Monthly : <span class="" style="color:red;">07</span>&nbsp;&nbsp;Expiring on : <span class="" style="color:red;">09,Dec,2022</span>&nbsp;&nbsp;Last Renewed on : <span class="" style="color:red;">08,Dec,2022</span></p>
                                          </div>
                                      </div>
                                       <hr>
                                        <div class="media mt-1">
                                         <div class="pr-2">
                                             &nbsp;&nbsp;&nbsp;<img src="<?= base_url()?>/public/app-assets/icons/stores.png"> 
                                          </div>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <div class="media-body">
                                              <p class="text-bold-600 m-0">Stores
                                              <p class="font-small-2 text-muted m-0">Active POS Terminals/devices Licenses&nbsp;&nbsp;Number of Stores : <span class="" style="color:red;">1</span></p>
                                          </div>
                                      </div>
                                       <hr>
                                       <div class="media mt-1">
                                         <div class="pr-2">
                                             &nbsp;&nbsp;&nbsp;<img src="<?= base_url()?>/public/app-assets/icons/pos.png"> 
                                          </div>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <div class="media-body">
                                              <p class="text-bold-600 m-0">POS Terminal
                                              <p class="font-small-2 text-muted m-0">Active POS Terminals/devices Licenses&nbsp;&nbsp;Number of POS Terminal : <span class="" style="color:red;">2</span></p>
                                          </div>
                                      </div>
                                       <hr>
                                       <div class="media mt-1">
                                         <div class="pr-2">
                                             &nbsp;&nbsp;&nbsp;<img src="<?= base_url()?>/public/app-assets/icons/email.png"> 
                                          </div>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <div class="media-body">
                                              <p class="text-bold-600 m-0">Email Recepits
                                              <p class="font-small-2 text-muted m-0">Subscription to Email Receipts  <span class="" style="color:red;">0 left</span></p>
                                          </div>
                                      </div>
                                       <hr>
                                       <div class="media mt-1">
                                         <div class="pr-2">
                                             &nbsp;&nbsp;&nbsp;<img src="<?= base_url()?>/public/app-assets/icons/sms.png"> 
                                          </div>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <div class="media-body">
                                              <p class="text-bold-600 m-0">SMS Recepits
                                              <p class="font-small-2 text-muted m-0">Subscription to SMS Receipts  <span class="" style="color:red;">0 left</span></p>
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
              <!-- Subscriptions End -->
              <!-- Payment Start -->
              <?php if(isset($data['permission']->payment_types) && $data['permission']->payment_types == 1) { ?>
              <div class="tab-pane" id="payment" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
                  <form class="filterPayment">
                <section class="mb-1 filter-bar">
                      <div class="filter-bar-item f-12">
                  <span>
                     <select name="equal[status]" class="form-control form-select purchase-search">
                        <option value="">Payments: All</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                     </select>
                  </span>
               </div>
                     <div class="filter-bar-item">
                          <span>
                          <select class="form-control form-select purchase-search" id="type_id" name="equal[type_id]" aria-label="Floating label select example">
                              <option value="" >Select Payment Type</option>
                               <?php 
                                 if(!empty($data['payment_master']))
                                 {
                                    foreach($data['payment_master'] as $row)
                                       { ?>
                                          <option value="<?= $row['id']?>"><?= $row['payment_type']?></option>
                                 <?php
                                       }
                                  } 
                                 ?>
                        </select>
                        </span>
                     </div>
                    <div class="filter-bar-item" style="flex-grow:1;">
                       <span>
                          <input type="text" placeholder="Search"  name="match[search]" class="form-control purchase-search searchDtField" value="">
                          <div class="form-control-position">
                             <i class="fa fa-search"></i>
                          </div>
                       </span>
                    </div>
                    <div class="filter-bar-item">
                       <span><button type="button" id="paymenttypebtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                    </div>
                    <div class="filter-bar-item border-side-right"></div>
                    <div class="filter-bar-item filter-bar-last pl-2">
                       <span>
                          <a href="<?= base_url("settings/add_payment_type")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                          <span class="dropdown">
                          <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                             <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                             <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                             <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                             <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                             <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                             </span>
                          </span>
                       </span>
                    </div>
                  </section>
                  </form>
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table id="payment-type-table" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <!-- <th>Payment</th> -->
                                                <th>Payment Type</th>
                                                <th>Receipt Name</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
              </div>
              <?php } ?>
              <!-- Payment End -->
             <!-- Receipt Start -->
              <div role="tabpanel" class="tab-pane" id="receipt" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <?php $value = isset($data['receipt'])?$data['receipt']:"";?>
                         <form method="post" id="receipt_form" name="receipt_form" enctype="multipart/form-data">
                         <input type="hidden" name="action" id="action" value="post_data_settings">
                            <input type="hidden" name="table_name" id="table_name" value="receipt">
                            <input type="hidden" name="id" id="receipt_id" value="">
                            <input type="hidden" name="receipt_image_old" id="receipt_image_old" value="">
                            <input type="hidden" name="store_image_old" id="store_image_old" value="">
                             <div class="row">
                                <div class="col-12">
                                   <div class="card">
                                      <div class="card-content collapse show">
                                         <div class="card-body card-dashboard">
                                           <div class="row">
                                            <div class="col-md-3">
                                               <div class="form-floating">
                                                 <select class="form-select" id="receipt-store_id" name="store_id" aria-label="Floating select example">
                                                  <option value="">Select Store</option>
                                                  <?php if(!empty($data['stores'])){
                                                     foreach($data['stores'] as $row){
                                                  ?>
                                                  <option value="<?=$row['id']?>"><?=$row['store_name']?></option>
                                                  <?php }} ?>
                                               </select>
                                                  <label for="store_id">Stores*</label>
                                               </div>
                                            </div>
                                            <div class="col-md-3">
                                               <div class="form-floating">
                                                   <input type="text" class="form-control" id="receipt_title" name="receipt_title" placeholder="Receipt Title">
                                                  <label for="receipt_title">Receipt Title*</label>
                                               </div>
                                            </div>
                                            <div class="col-md-3">
                                               <div class="form-floating">
                                                  <input type="text" class="form-control" id="receipt_footer" name="receipt_footer" placeholder="Receipt Footer">
                                                  <label for="receipt_footer">Receipt Footer*</label>
                                               </div>
                                            </div>
                                            <div class="col-md-3">
                                               <div class="form-floating">
                                                <select class="form-select" id="receipt_language" name="receipt_language">
                                                  <option disabled value="">Select Language</option>
                                                  <option value="AF">Afrikaans</option>
                                                  <option value="SQ">Albanian</option>
                                                  <option value="AR">Arabic</option>
                                                  <option value="BG">Bulgarian</option>
                                                  <option value="CA">Catalan</option>
                                                  <option value="KM">Cambodian</option>
                                                  <option value="ZH">Chinese (Mandarin)</option>
                                                  <option value="DA">Danish</option>
                                                  <option value="NL">Dutch</option>
                                                  <option value="EN" selected>English</option>
                                                  <option value="FR">French</option>
                                                  <option value="KA">Georgian</option>
                                                  <option value="DE">German</option>
                                                  <option value="EL">Greek</option>
                                                  <option value="ID">Indonesian</option>
                                                  <option value="GA">Irish</option>
                                                  <option value="IT">Italian</option>
                                                  <option value="JA">Japanese</option>
                                                  <option value="JW">Javanese</option>
                                                  <option value="KO">Korean</option>
                                                  <option value="LA">Latin</option>
                                                  <option value="MN">Mongolian</option>
                                                  <option value="NE">Nepali</option>
                                                  <option value="NO">Norwegian</option>
                                                  <option value="FA">Persian</option>
                                                  <option value="PT">Portuguese</option>
                                                  <option value="RO">Romanian</option>
                                                  <option value="RU">Russian</option>
                                                  <option value="SR">Serbian</option>
                                                  <option value="ES">Spanish</option>
                                                  <option value="SV">Swedish </option>
                                                  <option value="TH">Thai</option>
                                                  <option value="BO">Tibetan</option>
                                                  <option value="TR">Turkish</option>
                                                  <option value="UR">Urdu</option>
                                                  <option value="VI">Vietnamese</option>
                                                </select>
                                                  <!-- <input type="text" class="form-control" id="receipt_language" name="receipt_language" placeholder="Receipt Languages"> -->
                                                  <label for="receipt_language">Receipt Languages*</label>
                                               </div>
                                            </div>
                                         </div>
                                         <br>
                                         <div class="row">
                                           <div class="col-md-2">
                                              <b>Store Logo</b><br>
                                              For Receipt Email<br>
                                              <div class="uploadOuter">
                                                <input type="file" name="store_logo" id="store_logo" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"/>
                                                <label for="uploadFile" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i>  Browse Files</label>
                                                <p>128 * 128 Size</p>
                                                <p>Supported upto to 25 MB</p>
                                              </div>
                                           </div>
                                           <div class="col-md-2">
                                              <b>Receipt Logo</b><br>
                                                 Print Receipt<br>
                                              <div class="uploadOuter">
                                                <input type="file" name="receipt_logo" id="receipt_logo" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"/>
                                                <label for="uploadFile" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i>  Browse Files</label>
                                                <p>128 * 128 Size</p>
                                                <p>Supported upto to 25 MB</p>
                                              </div>
                                           </div>
                                           <div class="col-md-2 d-none" id="storeLogoView">
                                            <b>Store Logo</b><br>
                                              View<br>
                                              <img src="" class="mt-1" width="150" height="150">
                                           </div>
                                           <div class="col-md-2 d-none" id="recLogoView">
                                            <b>Receipt Logo</b><br>
                                              View<br>
                                              <img src="" class="mt-1" width="150" height="150">
                                           </div>
                                         </div>
                                         <br>
                                         <div class="row">
                                            <div class="col-md-6">
                                              <div class="media mt-1">
                                                   <div class="pr-2">
                                                       <img src="<?= base_url()?>/public/app-assets/icons/tax_clarification.png"> 
                                                   </div>
                                                   <div class="media-body">
                                                       <p class="text-bold-600 m-0">Tax Clarification</p>
                                                       <p class="font-small-2 text-muted m-0">Print tax clarification in endof receipt</p>
                                                   </div>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="mt-15">
                                                <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" checked/>
                                              </div>
                                            </div>
                                         </div>
                                         <br>
                                         <div class="row">
                                            <div class="col-md-6">
                                              <div class="media mt-1">
                                                   <div class="pr-2">
                                                       <img src="<?= base_url()?>/public/app-assets/icons/mail_sent.png"> 
                                                   </div>
                                                   <div class="media-body">
                                                       <p class="text-bold-600 m-0">Auto Mail</p>
                                                       <p class="font-small-2 text-muted m-0">Auto send email receipt to customer if email avaliable</p>
                                                   </div>
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="mt-15">
                                                <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" unchecked/>
                                              </div>
                                            </div>
                                         </div>
                                         <br>
                                         <div class="row">
                                            <div class="col-md-6">
                                           <div class="media mt-1">
                                               <div class="pr-2">
                                                   <img src="<?= base_url()?>/public/app-assets/icons/auto_sms.png"> 
                                               </div>
                                               <div class="media-body">
                                                   <p class="text-bold-600 m-0">Auto SMS</p>
                                                   <p class="font-small-2 text-muted m-0">Auto send email receipt to customer if Mobile Number avaliable</p>
                                               </div>
                                           </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mt-15">
                                             <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" checked/>
                                           </div>
                                        </div>
                                         </div>
                                         <br>
                                         <div class="row">
                                            <div class="col-md-6">
                                           <div class="media mt-1">
                                               <div class="pr-2">
                                                   <img src="<?= base_url()?>/public/app-assets/icons/barcode.png"> 
                                               </div>
                                               <div class="media-body">
                                                   <p class="text-bold-600 m-0">Print Invoice Number As Barcode</p>
                                                   <p class="font-small-2 text-muted m-0">Auto send email receipt to customer if Mobile Number avaliable</p>
                                               </div>
                                           </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mt-15">
                                             <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" unchecked/>
                                           </div>
                                        </div>
                                         </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                            <br>
                            <div class="form-footer text-right">
                             <?= SubmitButton();?>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
              <!-- Receipt End -->
               <!-- Weighing Scale Start -->
               <div class="tab-pane" id="weighing_scale" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <?php $value = isset($data['weighingscales'])?$data['weighingscales']:"";?>
                      <form method="post" id="weighingscale_form" name="weighingscale_form">
                         <input type="hidden" name="action" id="action" value="post_data_settings">
                            <input type="hidden" name="table_name" id="table_name" value="weighingscales">
                            <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row">
                           <div class="col-12">
                              <div class="card">
                                 <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                       <div class="row">
                                          <div class="col-md-3">
                                             <div class="form-floating">
                                               <input type="text" class="form-control" id="prefix" placeholder="Prefix" name="prefix" value="<?= $value['prefix'] ?>">
                                                <label for="floatingSelectGrid">POS Flag</label>
                                             </div>
                                          </div>
                                          <div class="col-md-3">
                                             <div class="form-floating">
                                                 <input type="number" class="form-control" id="entry_code" name="entry_code" placeholder="Entry Code"  value="<?= $value['entry_code'] ?>">
                                                <label for="floatingSelectGrid">POS Code</label>
                                             </div>
                                          </div>
                                          <div class="col-md-3">
                                             <div class="form-floating">
                                                <select class="form-select" id="type" name="type" aria-label="Floating label select example">
                                                <option value="" >Select Type</option>
                                                 <?php 
                                                   if(!empty($data['weighing_master']))
                                                   {
                                                      foreach($data['weighing_master'] as $row)
                                                         { ?>
                                                            <option <?= isset($value['type']) && ($value['type'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['weighing_type']?></option>
                                                   <?php
                                                         }
                                                    } 
                                                   ?>
                                             </select>
                                                <label for="floatingSelectGrid">Type</label>
                                             </div>
                                          </div>
                                          <div class="col-md-3">
                                             <div class="form-floating">
                                                <input type="number" class="form-control" id="digit" placeholder="Digits" name="digit" value="<?= $value['digit'] ?>">
                                                <label for="floatingSelectGrid">Digits</label>
                                             </div>
                                          </div>
                                       </div>
                                       <br>
                                       <div class="form-footer text-right">
                                         <?= SubmitButton();?>
                                       </div>
                                    </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Weighing Scale End -->
               <!-- Tax Start -->
               <?php if(isset($data['permission']->tax) && $data['permission']->tax == 1) { ?>
               <div class="tab-pane" id="tax" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                   <form class="filterTax">
                  <section class="mb-1 filter-bar">
                      <div class="filter-bar-item f-12">
                     <span>
                     <select name="equal[status]" class="form-control form-select purchase-search">
                        <option value="">Tax: All</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                     </select>
                  </span>
               </div>
                   <div class="filter-bar-item f-12">
                     <span>
                       <select class="form-control form-select purchase-search" id="tax_type_id" name="equal[tax_type_id]" aria-label="Floating label select example">
                           <option value="" >Select Tax</option>
                            <?php 
                              if(!empty($data['tax']))
                              {
                                 foreach($data['tax'] as $row)
                                    { ?>
                                       <option value="<?= $row['id']?>"><?= $row['tax_type']?></option>
                              <?php
                                    }
                               } 
                              ?>
                        </select>
                      </span>
                  </div>
                  <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                  </div>
                  <div class="filter-bar-item">
                     <span><button type="button" id="taxbtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                  </div>
                  <div class="filter-bar-item border-side-right"></div>
                  <div class="filter-bar-item filter-bar-last pl-2">
                     <span>
                        <a href="<?= base_url("settings/add_tax")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                        <span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                           <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                           <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                           <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                           </span>
                        </span>
                     </span>
                  </div>
                  </section>
                  </form>
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table id="tax-table" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>Tax</th>
                                                <th>Tax Rate</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
               <?php } ?>
               <!-- Tax End --> 
                <!-- Aggregator Start -->
               <div class="tab-pane" id="aggregator" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                  <section class="mb-1 filter-bar">
                  <div class="filter-bar-item f-12">
                    <span>
                      <select name="customer" class="form-control form-select purchase-search">
                         <option value="0">Aggregator : All</option>
                      </select>
                    </span>
                  </div>
                  <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                  </div>
                  <div class="filter-bar-item">
                     <span><button type="button" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                  </div>
                  <div class="filter-bar-item border-side-right"></div>
                  <div class="filter-bar-item filter-bar-last pl-2">
                     <span>
                        <a href="aggregator_add.php" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                        <span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                           <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                           <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                           <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                           </span>
                        </span>
                     </span>
                  </div>
                </section>
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table class="table table-striped table-bordered zero-configuration">
                                          <thead>
                                             <tr>
                                                <th>Name</th>
                                                <th>Aggregator Type</th>
                                                <th>Rate</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                                <td class="storeColor <?= RowStatus($row['status']); ?>">Readable Content</td> 
                                                <td>Zomato</td>
                                                <td>Sale Rate</td>
                                                <td><a href="aggregator_edit.php"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a></td>
                                             </tr>
                                             
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
               <!-- Aggregator End --> 
               <!-- Stores Start -->
               <?php if(isset($data['permission']->store_terminal) && $data['permission']->store_terminal == 1) { ?>
               <div class="tab-pane" id="stores" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                   <form class="filterStore">
                      <section class="mb-1 filter-bar">
                          <div class="filter-bar-item f-12">
                               <span>
                               <select name="equal[status]" class="form-control form-select purchase-search">
                                  <option value="">Store: All</option>
                                  <option value="1">Active</option>
                                  <option value="2">Deactive</option>
                               </select>
                            </span>
                         </div>
                        
                          <div class="filter-bar-item" style="flex-grow:1;">
                             <span>
                                <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                                <div class="form-control-position">
                                   <i class="fa fa-search"></i>
                                </div>
                             </span>
                          </div>
                          <div class="filter-bar-item">
                             <span><button type="button" id="storebtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                          </div>
                          <div class="filter-bar-item border-side-right"></div>
                          <div class="filter-bar-item filter-bar-last pl-2">
                             <span>
                                <a href="<?= base_url('settings/add_store')?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                                <span class="dropdown">
                                <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                                   <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                                   <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                                   <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                                   <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                                   <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                                   </span>
                                </span>
                             </span>
                          </div>     
                      </section>
                  </form>
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table id="store-table" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Tax No.</th>
                                                <th>Address</th>
                                                <th>Terminals</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
               <!-- Stores End -->
               <!-- Location Start -->
               <?php } if(isset($data['permission']->location) && $data['permission']->location == 1) { ?>
               <div class="tab-pane" id="location" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                   <form class="filterloc">
                      <section class="mb-1 filter-bar">
                          <div class="filter-bar-item f-12">
                               <span>
                               <select name="equal[status]" class="form-control form-select purchase-search">
                                  <option value="">Store: All</option>
                                  <option value="1">Active</option>
                                  <option value="2">Deactive</option>
                               </select>
                            </span>
                         </div>
                        
                          <div class="filter-bar-item" style="flex-grow:1;">
                             <span>
                                <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                                <div class="form-control-position">
                                   <i class="fa fa-search"></i>
                                </div>
                             </span>
                          </div>
                          <div class="filter-bar-item">
                             <span><button type="button" id="locSubmit" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                          </div>
                          <div class="filter-bar-item border-side-right"></div>
                          <div class="filter-bar-item filter-bar-last pl-2">
                            <span>
                                <a href="javascript:void(0);" class="btn btn-info btn-sm mr-10" id="addLocation"><i class="fa fa-plus"></i> Add New</a>
                            </span>
                          </div>     
                      </section>
                  </form>
                  <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table id="location-tbl" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>Location Description</th>
                                                <th>Store</th>
                                                <th>Location Type (Area)</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
               <?php } if(isset($data['permission']->store_terminal) && $data['permission']->store_terminal == 1) { ?>
               <!-- Terminals Start -->
               <div class="tab-pane" id="terminals" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                    <form class="filterTerminal">
                   <section class="mb-1 filter-bar">
                       <div class="filter-bar-item f-12">
                  <span>
                     <select name="equal[status]" class="form-control form-select purchase-search">
                        <option value="">Terminal: All</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                     </select>
                  </span>
               </div>
                  <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                  </div>
                  <div class="filter-bar-item">
                     <span><button type="button" id="terminalbtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                  </div>
                  <div class="filter-bar-item border-side-right"></div>
                  <div class="filter-bar-item filter-bar-last pl-2">
                     <span>
                        <a href="<?= base_url('settings/add_terminal')?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                        <span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                           <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                           <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                           <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                           </span>
                        </span>
                     </span>
                  </div>     
               </section>
               </form>
               <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table id="terminal-table" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>Name</th>
                                                <th>Store</th>
                                                <th>Type</th>
                                                <th>Sale Invoice Starting No.</th>
                                                <th>Sales Return Starting No.</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
               <!-- Terminals End --> 
               <!-- Employees Start -->
               <?php } if(isset($data['permission']->employees) && $data['permission']->employees == 1) { ?>
               <div class="tab-pane" id="employees" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                    <form class="filterEmployee">
                    <section class="mb-1 filter-bar">
                        <div class="filter-bar-item f-12">
                        <span>
                           <select name="equal[status]" class="form-control form-select purchase-search">
                              <option value="">Employee: All</option>
                              <option value="1">Active</option>
                              <option value="2">Deactive</option>
                           </select>
                        </span>
                     </div>
                    <div class="filter-bar-item f-12">
                      <span>
                        <select class="form-control form-select purchase-search" name="equal[role_id]" id="role_id" aria-label="Floating label select example">
                        <option value="" >Select Role</option>
                         <?php 
                           if(!empty($data['role']))
                           {
                              foreach($data['role'] as $row)
                                 { ?>
                                    <option value="<?= $row['id']?>"><?= $row['role_name']?></option>
                           <?php
                                 }
                            } 
                           ?>
                     </select>
                      </span>
                    </div>
                   
                  <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                  </div>
                  <div class="filter-bar-item">
                     <span><button type="button" id="employeebtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                  </div>
                  <div class="filter-bar-item border-side-right"></div>
                  <div class="filter-bar-item filter-bar-last pl-2">
                     <span>
                        <a href="<?= base_url('settings/add_employee')?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                        <span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                           <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                           <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                           <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                           </span>
                        </span>
                     </span>
                  </div>
               </section>
               </form>
               <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table id="employee-table" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
               <!-- Employees End -->
                 <!-- Roles Start -->
               <?php } if(isset($data['is_super_user']) && $data['is_super_user'] == "1") { ?>
               <div class="tab-pane" id="roles" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                    <form class="filterRole">
                  <section class="mb-1 filter-bar">
                      <div class="filter-bar-item f-12">
                        <span>
                           <select name="equal[status]" class="form-control form-select purchase-search">
                              <option value="">Role: All</option>
                              <option value="1">Active</option>
                              <option value="2">Deactive</option>
                           </select>
                        </span>
                     </div>
                    <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                    </div>
                    <div class="filter-bar-item">
                       <span><button type="button" id="rolebtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                    </div>
                    <div class="filter-bar-item border-side-right"></div>
                    <div class="filter-bar-item filter-bar-last pl-2">
                       <span>
                          <a href="<?= base_url('settings/add_role')?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                          <span class="dropdown">
                          <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                             <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                             <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                             <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                             <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                             <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                             </span>
                          </span>
                       </span>
                    </div>
                </section>
                </form>
               <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table id="role-table" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>Role</th>
                                                <th>Description</th>
                                                <!-- <th>Backoffice</th>
                                                <th>POS</th>
                                                <th>Waiter</th> -->
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
               <!-- Roles End -->
               <!-- Currency Start -->
               <div class="tab-pane" id="currency" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                   <form class="filterCurrency">
                  <section class="mb-1 filter-bar">
                      <div class="filter-bar-item f-12">
                  <span>
                     <select name="equal[status]" class="form-control form-select purchase-search">
                        <option value="">Currency: All</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                     </select>
                  </span>
               </div>
                    <div class="filter-bar-item test" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                    </div>
                    <div class="filter-bar-item">
                       <span><button type="button" id="currencybtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                    </div>
                    <div class="filter-bar-item border-side-right"></div>
                    <div class="filter-bar-item filter-bar-last pl-2">
                       <span>
                          <a href="<?= base_url('settings/add_currency')?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                          <span class="dropdown">
                          <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                             <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                             <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                             <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                             <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                             <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                             </span>
                          </span>
                       </span>
                    </div>
                  </section>
                  </form>
               <div class="card card-content collapse show">
                     <div class="card-body card-dashboard">
                        <section id="configuration">
                            <div class="col-12">
                                 <div class="status-div">
                              <span class="active-span"></span><span> Active</span>   
                              <span class="inactive-span"></span><span> Inactive</span>
                           </div>
                              </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="card">
                                    <div class="card-content collapse show">
                                       <div class="card-body card-dashboard">
                                        <table id="currency-table" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>Name</th>
                                                <th>Symbol</th>
                                                <th>Forex Rate <?= $data['base_currency']!=""?'(in '.$data['base_currency'].')':"" ?></th>
                                                <th>As of Date</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
               </div>
               <?php } ?>
               <!-- Currency End -->
      </div>
      <div class="modal fade text-left" id="add-new-location" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" aria-hidden="true">
                  <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel19">Add New Location</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <form method="post" id="location_master_form" name="location_master_form">
                              <input type="hidden" name="action" id="action" value="post_items_data" />
                              <input type="hidden" name="table_name" id="table_name" value="location" />
                              <input type="hidden" name="id" id="location_id" />

                              <div class="modal-body">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-floating">
                                              <select class="form-select" id="store_id" name="store_id" aria-label="Floating label select example">
                                                 <option value="">Select</option>
                                                 <?php 
                                                 if(!empty($data['stores'])) { 
                                                 foreach($data['stores'] as $row) { ?>
                                                 <option value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                                                 <?php } } ?>
                                              </select>
                                              <label>Store</label>
                                          </div>
                                      </div>
                                      <div class="col-md-12 pt-1">
                                          <div class="form-floating">
                                              <select class="form-select" id="location_type" name="location_type" aria-label="Floating label select example">
                                                 <option value="">Select</option>
                                                 <?php 
                                                 if(!empty($data['location_master'])) { 
                                                 foreach($data['location_master'] as $row) { ?>
                                                 <option value="<?= $row['id']?>"><?=$row['location_type']?> </option>
                                                 <?php } } ?>
                                              </select>
                                              <label>Location Type</label>
                                          </div>
                                      </div>
                                      <div class="col-md-12 pt-1">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="location_description" id="location_description" placeholder="Location Description" value="" />
                                              <label for="variant_name">Location Description</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> Cancel</button>
                                  <button id="btnSubmitVariant" type="submit" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
     