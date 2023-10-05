  <div class="app-content content">
      <div class="content-wrapper">
         <?= view('includes/breadcrumb.php');?> 
 <div class="card card-content collapse show">
      <div class="card-body card-dashboard">
            <div class="row">
               <div class="col-12">
                  <div class="card">
                     <div class="card-content collapse show">
                         <?php $value = isset($data['taxes'])?$data['taxes']:"";?>

                        <form method="post" id="tax_form" name="tax_form">
                           <input type="hidden" name="action" id="action" value="post_data_settings">
                            <input type="hidden" name="table_name" id="table_name" value="tax_master">
                            <input type="hidden" name="id" id="id" value="<?= isset($value['tax_type_id'])?$value['tax_type_id']:''?>">
                            <input type="hidden" name="tax_id" id="tax_id" value="<?= isset($value['id'])?$value['id']:''?>">
                           <div class="row">
                           <div class="col-md-3">
                               <label>Tax</label>
                             <div class="form-floating">
                                 <input type="text" class="form-control" name="tax_type" id="tax_type" placeholder="Tax" value="<?= isset($value['tax_name'])?$value['tax_name']:''?>" >
                                 <label for="tax">Tax</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                               <label>Tax Rate</label>
                              <div class="form-floating">
                                 <input type="text" name="tax_rate" class="form-control" id="tax_rate" placeholder="tax rate" value="<?= isset($value['tax_rate'])?$value['tax_rate']:''?>" >
                                 <label for="floatingSelectGrid">Tax Rate</label>
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