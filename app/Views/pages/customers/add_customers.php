      <div class="app-content content">
         <div class="content-wrapper">
             <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <div class="card">
                  <div class="card-body">
                      <?php $value = isset($data['customer'])?$data['customer']:"";?>
                      <form method="post" id="customer_form" name="customer_form">
                         <input type="hidden" name="action" id="action" value="post_data">
                            <input type="hidden" name="table_name" id="table_name" value="customers">
                            <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row">
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="Account ID" name="account_id" value="<?= isset($value['account_id'])?$value['account_id']:''?>" maxlength="30">
                                 <label for="floatingSelectGrid">Account ID*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="TPIN No" name="tpin_no" value="<?= isset($value['tpin_no'])?$value['tpin_no']:''?>" maxlength="30">
                                 <label for="floatingSelectGrid">TPIN No.*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="LPO No" name="lpo_no" value="<?= isset($value['lpo_no'])?$value['lpo_no']:''?>" maxlength="30">
                                 <label for="floatingSelectGrid">LPO No.</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="ID No" name="id_no" value="<?= isset($value['id_no'])?$value['id_no']:''?>" maxlength="50">
                                 <label for="floatingSelectGrid">ID No.*</label>
                              </div>
                           </div>
                        </div>
                        <div class="row pt-1">
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="Registered Name" name="registerd_name" value="<?= isset($value['registerd_name'])?$value['registerd_name']:''?>" maxlength="80">
                                 <label for="floatingSelectGrid">Registered Name*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="Tax Account Name" name="tax_account_name" value="<?= isset($value['tax_account_name'])?$value['tax_account_name']:''?>" maxlength="80">
                                 <label for="floatingSelectGrid">Tax Account Name *</label>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="Address" name="address" value="<?= isset($value['address'])?$value['address']:''?>" maxlength="150">
                                 <label for="floatingSelectGrid">Address*</label>
                              </div>
                           </div>
                        </div>
                        <div class="row pt-1">
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="email" class="form-control" id="floatingInputGrid" placeholder="Email Id" name="email" value="<?= isset($value['email'])?$value['email']:''?>" maxlength="40">
                                 <label for="floatingSelectGrid">Email ID</label>
                              </div>
                           </div>
                            <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control"  name="phone" id="phone" placeholder="Phone" value="<?= isset($value['phone'])?$value['phone']:''?>" style="height: 50px;" maxlength="18">
                                 <!-- <label for="floatingSelectGrid">Phone*</label> -->
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="Receivable" name="receivables" value="<?= isset($value['receivables'])?$value['receivables']:''?>" maxlength="30">
                                 <label for="floatingSelectGrid">Receivable</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="Loyalty" name="loyalty" value="<?= isset($value['loyalty'])?$value['loyalty']:''?>" maxlength="30">
                                 <label for="floatingSelectGrid">Loyalty</label>
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