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
                            <?php $value = isset($data['payments'])?$data['payments']:"";

                            if(!empty($value)){
                            $stores = json_decode($value['store_id']);
                            }
                                                          
                            ?>
                           <form method="post" id="payment_form" name="payment_form">
                           <input type="hidden" name="action" id="action" value="post_data_settings">
                            <input type="hidden" name="table_name" id="table_name" value="payments">
                             <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                           <div class="row">
                           <div class="col-md-4">
                              <div class="form-floating">
                               <input type="text" class="form-control" name="payment_type_id" id="payment_type_id" placeholder="Payment Type" value="<?= isset($value['payment_type_id'])?$value['payment_type_id']:''?>" >
                                 
                                 <label for="floatingSelectGrid">Payment Type*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <select class="form-select" id="type_id" name="type_id" aria-label="Floating label select example">
                                    <option value="" >Select Type</option>
                                     <?php 
                                       if(!empty($data['payment_master']))
                                       {
                                          foreach($data['payment_master'] as $row)
                                             { ?>
                                                <option <?= isset($value['type_id']) && ($value['type_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['payment_type']?></option>
                                       <?php
                                             }
                                        } 
                                       ?>
                                 </select>
                                 <label for="floatingSelectGrid">Type*</label>
                              </div>
                           </div>
                           <div class="col-md-5">
                              <div class="form-floating">
                                 <input type="text" class="form-control" name="receipt_name" id="receipt_name" placeholder="Receipt Name" value="<?= isset($value['receipt_name'])?$value['receipt_name']:''?>" >
                                 <label for="floatingSelectGrid">Receipt Name</label>
                              </div>
                           </div>
                        </div>
                        <br>
                        
                       <div class="row">
                           <div class="col-md-6">
                          <div class="media mt-1">
                              <div class="pr-2">
                                 <img src="<?= base_url()?>/public/app-assets/icons/shifts.png"> 
                              </div>
                              <div class="media-body">
                                  <p class="text-bold-600 m-0">Track Card Details</p>
                                  <p class="font-small-2 text-muted m-0">Track card type and last 4 digits</p>
                              </div>
                          </div>
                       </div>
                       <div class="col-md-6">
                           <div class="mt-15">
                            <input type="checkbox" data-size="sm" data-color="danger"
                           id="track_card_details" value="1" name="track_card_details" class="switchery" <?= isset($value['track_card_details']) && ($value['track_card_details'] == 1)?'checked':''?> />
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
                                  <p class="text-bold-600 m-0">MDR Collect from Customers</p>
                                   
                                  <p class="font-small-2 text-muted m-0">Collect Payment Surcharge from Customer</p>
                              </div>
                          </div>
                       </div>
                       <div class="col-md-6">
                           <div class="mt-15">
                            <input type="checkbox" data-size="sm" data-color="danger" name="mdr_collect_from_customer" id="mdr_collect_from_customer" class="switchery" value="1" <?= isset($value['mdr_collect_from_customer']) && ($value['mdr_collect_from_customer'] == 1)?'checked':''?>/>
                          </div>
                       </div>
                          </div>
                          <br>
                          <b>Rounding</b>
                          <p>Select Stores</p>
                          <div class="row">
                           <div class="col-md-6">
                              <div class="form-floating">
                                 <select class="select2 form-control" name="store_id[]" id="store_id" multiple="multiple">
                                    <?php 
                                    if(!empty($data['stores']))
                                    {
                                       foreach($data['stores'] as $row)
                                          { ?>
                                             <option <?=  isset($stores) && in_array($row['id'],$stores)? 'selected="selected"':"" ?>  value="<?=$row['id']?>"><?=$row['store_name']?></option>
                                          <?php
                                          }
                                     } 
                                    ?>

                                 </select>
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