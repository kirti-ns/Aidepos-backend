<style type="text/css">
   .chk{
   height: 23px;
   width: 25px;
   }
   .icheckbox_minimal{
   height: 23px;
   width: 25px;
   }
</style>
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
                           <?php $value = isset($data['roles'])?$data['roles']:"";
                           if(!empty($value)){
                            $pos_permission = json_decode($value['pos_permission']);
                            $back_office_permission = json_decode($value['back_office_permission']);
                            $waiter_permission = json_decode($value['waiter_permission']);
                           }
                           ?>
                            <form method="post" id="role_form" name="role_form">
                            <input type="hidden" name="action" id="action" value="post_role">
                            <input type="hidden" name="table_name" id="table_name" value="role">
                            <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                               <div class="row">
                                  <div class="col-md-6">
                                     <div class="form-floating">
                                        <input type="text" class="form-control" id="role_name" name="role_name" placeholder="User Role" value="<?= isset($value['role_name'])?$value['role_name']:''?>" >
                                        <label for="floatingSelectGrid">User Role</label>
                                     </div>
                                  </div>
                               </div>

                               <br>
                               <p><b>Permissions</b></p>
                               <div class="row back-office">
                                  <div class="col-md-6">
                                     <div class="media mt-1">
                                        <div class="pr-2">
                                           <img src="<?= base_url()?>/public/app-assets/icons/backoffice.png"> 
                                        </div>
                                        <div class="media-body">
                                           <p class="text-bold-600 m-0">Back office</p>
                                           <p class="font-small-2 text-muted m-0">Employees can log in to the back office using their email and password</p>
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-md-6">
                                     <div class="mt-15">
                                        <input type="checkbox" name="back_office" value="1" data-size="sm" data-color="danger" id="back_office" class="switchery back_office-switchery" <?= isset($value['back_office']) && ($value['back_office'] == 1)?'checked':''?>/>
                                     </div>
                                  </div>
                               </div>
                               <br>
                                <div class="row icheck_minimal skin" data-sec="back-office">
                                  <div class="col-md-1 col-sm-12">
                                  </div>
                                  <div class="col-md-4 col-sm-12">
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[view_all_reports]" <?= isset($back_office_permission->view_all_reports) && ($back_office_permission->view_all_reports == 1)?'checked':''?> class="chk" id="input-12" value="1" >
                                        <label for="input-12">
                                           <p class="text-bold-600 m-0"><b>View All Reports</b></p>
                                           <p class="font-small-2 text-muted m-0">Permission to view all reports</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[items]" class="chk" id="input-13" value="1" <?= isset($back_office_permission->items) && ($back_office_permission->items == 1)?'checked':''?> >
                                        <label for="input-13">
                                           <p class="text-bold-600 m-0"><b>Items</b></p>
                                           <p class="font-small-2 text-muted m-0">Enable to manage Items </p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[manage_employees]" class="chk" id="input-14" value="1" <?= isset($back_office_permission->manage_employees) && ($back_office_permission->manage_employees == 1)?'checked':''?>  >
                                        <label for="input-14">
                                           <p class="text-bold-600 m-0"><b>Manage Employees</b></p>
                                           <p class="font-small-2 text-muted m-0">Enable to manage Employees</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[manage_customers]" class="chk" id="input-15" value="1" <?= isset($back_office_permission->manage_customers) && ($back_office_permission->manage_customers == 1)?'checked':''?> >
                                        <label for="input-15">
                                           <p class="text-bold-600 m-0"><b>Manage Customers</b></p>
                                           <p class="font-small-2 text-muted m-0">Enable to manage Customers</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[edit_general_settings]" class="chk" id="input-16" value="1" <?= isset($back_office_permission->edit_general_settings) && ($back_office_permission->edit_general_settings == 1)?'checked':''?> >
                                        <label for="input-16">
                                           <p class="text-bold-600 m-0"><b>Edit general settings</b></p>
                                           <p class="font-small-2 text-muted m-0">To change general settings</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[manage_billing]" class="chk" id="input-17" value="1" <?= isset($back_office_permission->manage_billing) && ($back_office_permission->manage_billing == 1)?'checked':''?>>
                                        <label for="input-17">
                                           <p class="text-bold-600 m-0"><b>Manage billing</b></p>
                                           <p class="font-small-2 text-muted m-0">Enable to manage billing</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[stock_transfer]" class="chk" id="input-18" value="1" <?= isset($back_office_permission->stock_transfer) && ($back_office_permission->stock_transfer == 1)?'checked':''?> >
                                        <label for="input-18">
                                           <p class="text-bold-600 m-0"><b>Stock Transfer</b></p>
                                           <p class="font-small-2 text-muted m-0">Perform stock transfer</p>
                                        </label>
                                     </fieldset>
                                  </div>
                                  <br>
                                  <div class="col-md-4 col-sm-12">
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[manage_payment_types]" class="chk" id="input-19" value="1" <?= isset($back_office_permission->manage_payment_types) && ($back_office_permission->manage_payment_types == 1)?'checked':''?>>
                                        <label for="input-19">
                                           <p class="text-bold-600 m-0"><b>Manage payment types</b></p>
                                           <p class="font-small-2 text-muted m-0">Enabletomanage payment types</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[manage_loyalty_program]" class="chk" id="input-20" value="1" <?= isset($back_office_permission->manage_loyalty_program) && ($back_office_permission->manage_loyalty_program == 1)?'checked':''?> >
                                        <label for="input-20">
                                           <p class="text-bold-600 m-0"><b>Manage loyalty program</b></p>
                                           <p class="font-small-2 text-muted m-0">Enable to manage loyalty program</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[manage_taxes]" class="chk" id="input-21" value="1" <?= isset($back_office_permission->manage_taxes) && ($back_office_permission->manage_taxes == 1)?'checked':''?>>
                                        <label for="input-21">
                                           <p class="text-bold-600 m-0"><b>Manage taxes</b></p>
                                           <p class="font-small-2 text-muted m-0">Enable to manage taxes</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[manage_pos_devices]" class="chk" id="input-22" value="1" <?= isset($back_office_permission->manage_pos_devices) && ($back_office_permission->manage_pos_devices == 1)?'checked':''?> >
                                        <label for="input-22">
                                           <p class="text-bold-600 m-0"><b>Manage POS devices</b></p>
                                           <p class="font-small-2 text-muted m-0">Manage store settings and terminal settings</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[inventory]" class="chk" id="input-23" value="1" <?= isset($back_office_permission->inventory) && ($back_office_permission->inventory == 1)?'checked':''?> >
                                        <label for="input-23">
                                           <p class="text-bold-600 m-0"><b>Inventory</b></p>
                                           <p class="font-small-2 text-muted m-0">Perform purchase</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[stock_adjustment]" class="chk" id="input-24" value="1" <?= isset($back_office_permission->stock_adjustment) && ($back_office_permission->stock_adjustment == 1)?'checked':''?> >
                                        <label for="input-24">
                                           <p class="text-bold-600 m-0"><b>Stock adjustment</b></p>
                                           <p class="font-small-2 text-muted m-0">Perform stock adjustment</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="back_office_permission[floor_plan]" class="chk" id="input-25" value="1" <?= isset($back_office_permission->floor_plan) && ($back_office_permission->floor_plan == 1)?'checked':''?> >
                                        <label for="input-25">
                                           <p class="text-bold-600 m-0"><b>Floor Plan</b></p>
                                           <p class="font-small-2 text-muted m-0">To change floor plan</p>
                                        </label>
                                     </fieldset>
                                  </div>
                               </div>
                               <br>
                               <div class="row pos">
                                  <div class="col-md-6">
                                     <div class="media mt-1">
                                        <div class="pr-2">
                                           <img src="<?= base_url()?>/public/app-assets/icons/pos.png"> 
                                        </div>
                                        <div class="media-body">
                                           <p class="text-bold-600 m-0">POS</p>
                                           <p class="font-small-2 text-muted m-0">Employees can log in to system </p>
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-md-6">
                                     <div class="mt-15">
                                        <input type="checkbox" name="pos" value="1" data-size="sm" data-color="danger"  id="pos" class="switchery pos-switchery" data-id="1" <?= isset($value['pos']) && ($value['pos'] == 1)?'checked':''?>  />
                                     </div>
                                  </div>
                               </div>
                               <br>
                               <div class="row icheck_minimal skin" data-sec="pos">
                                  <div class="col-md-1 col-sm-12">
                                  </div>
                                  <div class="col-md-4 col-sm-12">
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[view_all_receipt]" <?= isset($pos_permission->view_all_receipt) && ($pos_permission->view_all_receipt == 1)?'checked':''?> class="chk" id="input-1" value="1" >
                                        <label for="input-1">
                                           <p class="text-bold-600 m-0"><b>View All Receipt</b></p>
                                           <p class="font-small-2 text-muted m-0">Is disabled,user can't view receipts</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[bill_apply]" class="chk" id="input-2" value="1" <?= isset($pos_permission->bill_apply) && ($pos_permission->bill_apply == 1)?'checked':''?> >
                                        <label for="input-2">
                                           <p class="text-bold-600 m-0"><b>Apply bill discount with restricted access</b></p>
                                           <p class="font-small-2 text-muted m-0">Apply discount with restricted access </p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[item_sale_rate]" class="chk" id="input-3" value="1" <?= isset($pos_permission->item_sale_rate) && ($pos_permission->item_sale_rate == 1)?'checked':''?>  >
                                        <label for="input-8">
                                           <p class="text-bold-600 m-0"><b>Change item sale rate</b></p>
                                           <p class="font-small-2 text-muted m-0">User can change item rate in a sale</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[perform_refund]" class="chk" id="input-4" value="1" <?= isset($pos_permission->perform_refund) && ($pos_permission->perform_refund == 1)?'checked':''?> >
                                        <label for="input-4">
                                           <p class="text-bold-600 m-0"><b>Perform Refunds</b></p>
                                           <p class="font-small-2 text-muted m-0">User can perform refunds</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[open_cash_drawer]" class="chk" id="input-5" value="1" <?= isset($pos_permission->open_cash_drawer) && ($pos_permission->open_cash_drawer == 1)?'checked':''?> >
                                        <label for="input-5">
                                           <p class="text-bold-600 m-0"><b>Open cash drawer without making a sale</b></p>
                                           <p class="font-small-2 text-muted m-0">Open cash drawer without making a sale</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[change_settings]" class="chk" id="input-6" value="1" <?= isset($pos_permission->change_settings) && ($pos_permission->change_settings == 1)?'checked':''?>>
                                        <label for="input-6">
                                           <p class="text-bold-600 m-0"><b>Change settings</b></p>
                                           <p class="font-small-2 text-muted m-0">Access rights to change settings</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                  </div>
                                  <div class="col-md-4 col-sm-12">
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[cashin_cashout]" class="chk" id="input-7" value="1" <?= isset($pos_permission->cashin_cashout) && ($pos_permission->cashin_cashout == 1)?'checked':''?>>
                                        <label for="input-7">
                                           <p class="text-bold-600 m-0"><b>Cashin and Cashout</b></p>
                                           <p class="font-small-2 text-muted m-0">Perform Cashin and Cashout</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[add_new_items]" class="chk" id="input-8" value="1" <?= isset($pos_permission->add_new_items) && ($pos_permission->add_new_items == 1)?'checked':''?> >
                                        <label for="input-8">
                                           <p class="text-bold-600 m-0"><b>Add New Items</b></p>
                                           <p class="font-small-2 text-muted m-0">Add new items from POS</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[item_details]" class="chk" id="input-9" value="1" <?= isset($pos_permission->item_details) && ($pos_permission->item_details == 1)?'checked':''?>>
                                        <label for="input-9">
                                           <p class="text-bold-600 m-0"><b>Item Details</b></p>
                                           <p class="font-small-2 text-muted m-0">Show item details from POS</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[cancel_order]" class="chk" id="input-10" value="1" <?= isset($pos_permission->cancel_order) && ($pos_permission->cancel_order == 1)?'checked':''?> >
                                        <label for="input-10">
                                           <p class="text-bold-600 m-0"><b>Cancel Order</b></p>
                                           <p class="font-small-2 text-muted m-0">Cancel order in POS</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="pos_permission[reprint]" class="chk" id="input-11" value="1" <?= isset($pos_permission->reprint) && ($pos_permission->reprint == 1)?'checked':''?> >
                                        <label for="input-11">
                                           <p class="text-bold-600 m-0"><b>Reprint</b></p>
                                           <p class="font-small-2 text-muted m-0">Is enabled,user can take duplicate print of receipt</p>
                                        </label>
                                     </fieldset>
                                  </div>
                               </div>
                               <!-- <div class="row">
                                  <div class="col-md-6">
                                     <div class="media mt-1">
                                        <div class="pr-2">
                                           <img src="<?= base_url()?>/public/app-assets/icons/waiter.png"> 
                                        </div>
                                        <div class="media-body">
                                           <p class="text-bold-600 m-0">Waiter</p>
                                           <p class="font-small-2 text-muted m-0">Employees can log in to waiter system</p>
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-md-6">
                                     <div class="mt-15">
                                        <input type="checkbox" name="waiter" value="1" data-size="sm" data-color="danger" id="waiter" class="switchery waiter-switchery" <?= isset($value['waiter']) && ($value['waiter'] == 1)?'checked':''?>/>
                                     </div>
                                  </div>
                               </div>
                               <br>
                               <div class="row icheck_minimal skin">
                                  <div class="col-md-1 col-sm-12">
                                  </div>
                                  <div class="col-md-4 col-sm-12">
                                     <fieldset>
                                        <input type="checkbox" name="waiter_permission[view_all_orders]"  <?= isset($waiter_permission->view_all_orders) && ($waiter_permission->view_all_orders == 1)?'checked':''?> class="chk" id="input-26" value="1">
                                        <label for="input-26">
                                           <p class="text-bold-600 m-0"><b>View All Orders</b></p>
                                           <p class="font-small-2 text-muted m-0">Is disabled,user can view only his owen orders</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="waiter_permission[manage_orders]" class="chk" id="input-27" value="1" <?= isset($waiter_permission->manage_orders) && ($waiter_permission->manage_orders == 1)?'checked':''?> >
                                        <label for="input-27">
                                           <p class="text-bold-600 m-0"><b>Manage Orders</b></p>
                                           <p class="font-small-2 text-muted m-0">Is disabled,user can update/manage only his owen orders</p>
                                        </label>
                                     </fieldset>
                                     
                                     <br>
                                  </div>
                                  <div class="col-md-4 col-sm-12">
                                     <fieldset>
                                        <input type="checkbox" name="waiter_permission[cancel_order]" class="chk" id="input-28" value="1" <?= isset($waiter_permission->cancel_order) && ($waiter_permission->cancel_order == 1)?'checked':''?>>
                                        <label for="input-28">
                                           <p class="text-bold-600 m-0"><b>Cancel order</b></p>
                                           <p class="font-small-2 text-muted m-0">Cancel order from waite system</p>
                                        </label>
                                     </fieldset>
                                     <br>
                                     <fieldset>
                                        <input type="checkbox" name="waiter_permission[change_settings]" class="chk" id="input-29" value="1" <?= isset($waiter_permission->change_settings) && ($waiter_permission->change_settings == 1)?'checked':''?> >
                                        <label for="input-29">
                                           <p class="text-bold-600 m-0"><b>Change settings</b></p>
                                           <p class="font-small-2 text-muted m-0">Access rights to change settings</p>
                                        </label>
                                     </fieldset>
                                     
                                     
                                     <br>
                                  </div>
                               </div> -->
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
   </div>
</div>