      <div class="app-content content">
         <div class="content-wrapper">
            <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <div class="card">
                  <div class="card-body">
                     <?php $value = isset($data['supplier'])?$data['supplier']:"";?>
                     <form method="post" id="supplier_form" name="supplier_form">
                           <input type="hidden" name="action" id="action" value="post_data_purchase">
                            <input type="hidden" name="table_name" id="table_name" value="suppliers">
                            <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row">
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" name="registered_name" id="registered_name" placeholder="Registered Name" value="<?= isset($value['registered_name'])?$value['registered_name']:''?>" >
                                 <label for="floatingSelectGrid">Registered Name*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="tax_amount_name" placeholder="Tax Account Name" name="tax_amount_name" value="<?= isset($value['tax_amount_name'])?$value['tax_amount_name']:''?>" >
                                 <label for="floatingSelectGrid">Tax Account Name*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="operator" placeholder="Operator" name="operator" value="<?= isset($value['operator'])?$value['operator']:''?>" >
                                 <label for="floatingSelectGrid">Operator*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="payable" placeholder="Payable" name="payable" value="<?= isset($value['payable'])?$value['payable']:''?>" >
                                 <label for="floatingSelectGrid">Payable $*</label>
                              </div>
                           </div>
                        </div>
                        <div class="row pt-1">
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="email" placeholder="Email Id" name="email" value="<?= isset($value['email'])?$value['email']:''?>" >
                                 <label for="floatingSelectGrid">Email ID*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                             
                               <div class="form-floating">
                                 <input type="text" class="form-control"  name="phone" id="phone" placeholder="Phone" value="<?= isset($value['phone'])?$value['phone']:''?>" style="height: 50px;">
                                 <!-- <label for="floatingSelectGrid">Phone*</label> -->
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="address" placeholder="Address"  name="address" value="<?= isset($value['address'])?$value['address']:''?>" >
                                 <label for="floatingSelectGrid">Address*</label>
                              </div>
                           </div>
                        </div>
                        <div class="row pt-1">
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="date" class="form-control" id="floatingInputGrid" placeholder="Date" name="date" value="<?= isset($value['date'])?$value['date']:''?>" >
                                 <label for="floatingSelectGrid">Select Created Date</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <select class="form-select" id="status_type" name="status_type" aria-label="Floating label select example">
                                    <option>Select</option>
                                    <option <?= isset($value['status_type']) && ($value['status_type'] == 1)?'selected':''?> value="Approved">Approved</option>
                                    <option <?= isset($value['status_type']) && ($value['status_type'] == 2)?'selected':''?> value="Pending">Pending</option>
                                    <option  <?= isset($value['status_type']) && ($value['status_type'] == 3)?'selected':''?>value="Cancelled">Cancelled</option>
                                 </select>
                                 <label for="floatingSelectGrid">Status</label>
                              </div>
                           </div>
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
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>